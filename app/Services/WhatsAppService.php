<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected $apiToken;
    protected $apiUrl;
    protected $enabled;

    public function __construct()
    {
        $this->apiToken = config('services.fonnte.token');
        $this->apiUrl = config('services.fonnte.url', 'https://api.fonnte.com/send');
        $this->enabled = config('services.fonnte.enabled', true);
    }

    /**
     * Send WhatsApp message via Fonnte API
     *
     * @param string $phoneNumber Format: 628xxx (tanpa +)
     * @param string $message
     * @return array
     */
    public function sendMessage($phoneNumber, $message)
    {
        if (!$this->enabled) {
            Log::info('WhatsApp service disabled. Message not sent.', [
                'phone' => $phoneNumber,
                'message' => $message
            ]);
            
            return [
                'success' => false,
                'message' => 'WhatsApp service is disabled'
            ];
        }

        if (empty($this->apiToken)) {
            Log::error('Fonnte API token not configured');
            
            return [
                'success' => false,
                'message' => 'WhatsApp API token not configured'
            ];
        }

        // Format phone number (remove +, spaces, dashes)
        $phoneNumber = $this->formatPhoneNumber($phoneNumber);

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->apiToken,
            ])->post($this->apiUrl, [
                'target' => $phoneNumber,
                'message' => $message,
                'countryCode' => '62', // Indonesia
            ]);

            $result = $response->json();

            if ($response->successful() && isset($result['status']) && $result['status']) {
                Log::info('WhatsApp message sent successfully', [
                    'phone' => $phoneNumber,
                    'response' => $result
                ]);

                return [
                    'success' => true,
                    'message' => 'WhatsApp message sent successfully',
                    'data' => $result
                ];
            }

            Log::warning('WhatsApp message failed', [
                'phone' => $phoneNumber,
                'response' => $result
            ]);

            return [
                'success' => false,
                'message' => $result['reason'] ?? 'Failed to send WhatsApp message',
                'data' => $result
            ];

        } catch (\Exception $e) {
            Log::error('WhatsApp API error', [
                'phone' => $phoneNumber,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Error sending WhatsApp message: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Send order notification to customer
     *
     * @param \App\Models\Order $order
     * @return array
     */
    public function sendOrderNotification($order)
    {
        $user = $order->user;
        
        if (!$user || !$user->no_telp) {
            return [
                'success' => false,
                'message' => 'User phone number not found'
            ];
        }

        $message = $this->buildOrderMessage($order);
        
        return $this->sendMessage($user->no_telp, $message);
    }

    /**
     * Build order confirmation message
     *
     * @param \App\Models\Order $order
     * @return string
     */
    protected function buildOrderMessage($order)
    {
        $user = $order->user;
        $items = json_decode($order->items, true);
        
        $message = "*[SISTEM] Pesanan Pupuk & Bibit Bersubsidi*\n\n";
        $message .= "Halo *{$user->nama_lengkap}*,\n\n";
        $message .= "Terima kasih telah melakukan pemesanan!\n\n";
        $message .= "*Detail Pesanan:*\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━\n";
        $message .= "No. Pesanan: *{$order->order_number}*\n";
        $message .= "Tanggal: " . $order->created_at->format('d M Y, H:i') . "\n";
        $message .= "Balai Desa: {$order->village_office}\n\n";
        
        $message .= "*Produk yang Dipesan:*\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━\n";
        
        if (is_array($items)) {
            foreach ($items as $item) {
                $productName = $item['product_name'] ?? 'Produk';
                $quantity = $item['quantity'] ?? 0;
                $price = number_format($item['price'] ?? 0, 0, ',', '.');
                $subtotal = number_format($item['subtotal'] ?? 0, 0, ',', '.');
                
                $message .= "• {$productName}\n";
                $message .= "  Jumlah: {$quantity} unit\n";
                $message .= "  Harga: Rp {$price}\n";
                $message .= "  Subtotal: Rp {$subtotal}\n\n";
            }
        }
        
        $message .= "━━━━━━━━━━━━━━━━━━━━\n";
        $message .= "💰 *Total Pembayaran:* Rp " . number_format($order->total_amount, 0, ',', '.') . "\n\n";
        
        $message .= "📍 *Status:* " . $this->getStatusEmoji($order->status) . " *{$order->status}*\n\n";
        
        $message .= "ℹ️ *Informasi:*\n";
        $message .= "• Pesanan Anda sedang diproses oleh admin\n";
        $message .= "• Anda akan menerima notifikasi lebih lanjut\n";
        $message .= "• Cek status pesanan di dashboard\n\n";
        
        $message .= "📱 *Hubungi Kami:*\n";
        $message .= "Website: http://127.0.0.1:8000\n\n";
        
        $message .= "_Pesan otomatis dari Sistem Informasi Pupuk & Bibit Bersubsidi_";
        
        return $message;
    }

    /**
     * Send order status update notification
     *
     * @param \App\Models\Order $order
     * @param string $oldStatus
     * @return array
     */
    public function sendStatusUpdateNotification($order, $oldStatus)
    {
        $user = $order->user;
        
        if (!$user || !$user->no_telp) {
            return [
                'success' => false,
                'message' => 'User phone number not found'
            ];
        }

        $message = $this->buildStatusUpdateMessage($order, $oldStatus);
        
        return $this->sendMessage($user->no_telp, $message);
    }

    /**
     * Build status update message
     *
     * @param \App\Models\Order $order
     * @param string $oldStatus
     * @return string
     */
    protected function buildStatusUpdateMessage($order, $oldStatus)
    {
        $user = $order->user;
        
        $message = "*[UPDATE] Status Pesanan*\n\n";
        $message .= "Halo *{$user->nama_lengkap}*,\n\n";
        $message .= "Status pesanan Anda telah diperbarui!\n\n";
        $message .= "No. Pesanan: *{$order->order_number}*\n";
        $message .= "Tanggal Update: " . now()->format('d M Y, H:i') . "\n\n";
        $message .= "Status berubah dari:\n";
        $message .= "*{$oldStatus}* --> *{$order->status}*\n\n";
        
        // Custom message based on status
        switch ($order->status) {
            case 'Confirmed':
                $message .= "[OK] Pesanan Anda telah dikonfirmasi!\n";
                $message .= "Silakan ambil pesanan di balai desa sesuai jadwal.\n";
                break;
            case 'Completed':
                $message .= "[SELESAI] Terima kasih! Pesanan telah selesai.\n";
                $message .= "Semoga pupuk & bibit bermanfaat untuk pertanian Anda!\n";
                break;
            case 'Cancelled':
                $message .= "[BATAL] Pesanan dibatalkan.\n";
                if ($order->rejection_reason) {
                    $message .= "Alasan: {$order->rejection_reason}\n";
                }
                break;
            default:
                $message .= "Status pesanan: {$order->status}\n";
        }
        
        $message .= "\nCek detail lengkap di:\n";
        $message .= "http://127.0.0.1:8000/dashboard\n\n";
        
        $message .= "_Pesan otomatis dari Sistem Informasi Pupuk & Bibit Bersubsidi_";
        
        return $message;
    }

    /**
     * Format phone number to Fonnte format
     *
     * @param string $phoneNumber
     * @return string
     */
    protected function formatPhoneNumber($phoneNumber)
    {
        // Remove all non-numeric characters
        $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);
        
        // If starts with 0, replace with 62
        if (substr($phoneNumber, 0, 1) === '0') {
            $phoneNumber = '62' . substr($phoneNumber, 1);
        }
        
        // If doesn't start with 62, add it
        if (substr($phoneNumber, 0, 2) !== '62') {
            $phoneNumber = '62' . $phoneNumber;
        }
        
        return $phoneNumber;
    }

    /**
     * Test WhatsApp connection
     *
     * @param string $phoneNumber
     * @return array
     */
    public function testConnection($phoneNumber)
    {
        $message = "*[TEST] Koneksi WhatsApp*\n\n";
        $message .= "Halo! Ini adalah pesan test dari sistem.\n";
        $message .= "Jika Anda menerima pesan ini, berarti koneksi WhatsApp API berhasil!\n\n";
        $message .= "Timestamp: " . now()->format('d M Y, H:i:s');
        
        return $this->sendMessage($phoneNumber, $message);
    }
}

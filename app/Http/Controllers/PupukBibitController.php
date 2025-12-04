<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PupukBibitController extends Controller
{
    /**
     * Display listing of products
     */
    public function index()
    {
        $products = Product::with('primaryImage')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('user.pupukdanbibit', compact('products'));
    }

    /**
     * Show product detail
     */
    public function detail($id)
    {
        $product = Product::with('images')->findOrFail($id);
        
        return view('user.detail-produk', compact('product'));
    }

    /**
     * Confirm order (show confirmation page)
     */
    public function confirmOrder(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ], [
            'quantity.required' => 'Jumlah pemesanan wajib diisi',
            'quantity.integer' => 'Jumlah pemesanan harus berupa angka',
            'quantity.min' => 'Jumlah pemesanan minimal 1',
        ]);

        $quantity = $validated['quantity'];
        $subtotal = $product->harga_subsidi * $quantity;
        $tax = $subtotal * 0.1;
        $total = $subtotal + $tax;

        return view('user.konfirmasi-pesanan', compact('product', 'quantity', 'subtotal', 'tax', 'total'));
    }

    /**
     * Store order to database
     */
    public function storeOrder(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:produk,id_produk',
            'quantity' => 'required|integer|min:1',
            'delivery_address' => 'required|string|max:500',
            'payment_method' => 'required|in:transfer,cod,ewallet',
        ], [
            'product_id.required' => 'Produk tidak valid',
            'product_id.exists' => 'Produk tidak ditemukan',
            'quantity.required' => 'Jumlah pemesanan wajib diisi',
            'quantity.min' => 'Jumlah pemesanan minimal 1',
            'delivery_address.required' => 'Alamat pengiriman wajib diisi',
            'payment_method.required' => 'Metode pembayaran wajib dipilih',
        ]);

        DB::beginTransaction();
        
        try {
            $product = Product::findOrFail($validated['product_id']);

            $subtotal = $product->harga_subsidi * $validated['quantity'];
            $tax = $subtotal * 0.1;
            $total = $subtotal + $tax;

            $order = Order::create([
                'user_id' => Auth::id(),
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total_amount' => $total,
                'delivery_address' => $validated['delivery_address'],
                'payment_method' => $validated['payment_method'],
                'status' => 'Pending',
                'confirmed_by_user' => true,
            ]);

            DB::commit();

            return redirect()->route('user.pesan-berhasil')
                ->with('success', 'Pesanan berhasil dibuat!')
                ->with('order_id', $order->id);

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Terjadi kesalahan saat memproses pesanan'])->withInput();
        }
    }
}

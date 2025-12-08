<?php

namespace App\Http\Controllers\Api\Sales;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    /**
     * Create new order
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:produk,id_produk',
            'quantity' => 'required|integer|min:1',
            'delivery_address' => 'required|string',
            'phone' => 'required|string|max:20',
            'notes' => 'nullable|string'
        ], [
            'product_id.required' => 'ID produk wajib diisi',
            'product_id.exists' => 'Produk tidak ditemukan',
            'quantity.required' => 'Jumlah pesanan wajib diisi',
            'quantity.min' => 'Jumlah pesanan minimal 1',
            'delivery_address.required' => 'Alamat pengiriman wajib diisi',
            'phone.required' => 'Nomor telepon wajib diisi'
        ]);

        try {
            return DB::transaction(function () use ($request) {
                // Step 1: Ambil data produk dari Catalog API (Internal Call)
                $productData = $this->getProductFromCatalog($request->product_id);

                if (!$productData['success']) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Product not found in catalog'
                    ], 404);
                }

                $product = $productData['data'];

                // Step 2: Cek stok dari Catalog API
                if ($product['stock'] < $request->quantity) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Insufficient stock. Available: ' . $product['stock']
                    ], 400);
                }

                // Step 3: Hitung total harga
                $pricePerUnit = $product['harga_subsidi'];
                $totalPrice = $pricePerUnit * $request->quantity;

                // Step 4: Generate order number
                $orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(uniqid());

                // Step 5: Prepare items array
                $items = [[
                    'name' => $product['nama_produk'],
                    'qty' => $request->quantity,
                    'price' => $pricePerUnit
                ]];

                // Step 6: Buat order
                $order = Order::create([
                    'order_number' => $orderNumber,
                    'user_id' => $request->user()->id,
                    'product_id' => $request->product_id,
                    'quantity' => $request->quantity,
                    'items' => json_encode($items),
                    'price_per_unit' => $pricePerUnit,
                    'total_price' => $totalPrice,
                    'delivery_address' => $request->delivery_address,
                    'phone' => $request->phone,
                    'notes' => $request->notes,
                    'status' => 'pending'
                ]);

                // Step 7: Kurangi stok produk
                DB::table('produk')
                    ->where('id_produk', $request->product_id)
                    ->decrement('stok_produk', $request->quantity);

                // Load order dengan relasi product
                $order->load('product.images');

                return response()->json([
                    'success' => true,
                    'message' => 'Order created successfully',
                    'data' => [
                        'order' => $order,
                        'product_info' => [
                            'nama_produk' => $product['nama_produk'],
                            'harga_normal' => $product['harga_normal'],
                            'harga_subsidi' => $product['harga_subsidi'],
                            'penghematan' => ($product['harga_normal'] - $product['harga_subsidi']) * $request->quantity
                        ]
                    ]
                ], 201);
            });

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get order by ID
     * 
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $order = Order::with('product.images')
                        ->where('user_id', auth()->id())
                        ->where('id', $id)
                        ->first();

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Order retrieved successfully',
                'data' => $order
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Internal method: Get product data from Catalog
     * Instead of HTTP call, directly query Product model for better performance
     * 
     * @param int $productId
     * @return array
     */
    private function getProductFromCatalog($productId)
    {
        try {
            $product = \App\Models\Product::find($productId);

            if (!$product) {
                return ['success' => false];
            }

            return [
                'success' => true,
                'data' => [
                    'product_id' => $product->id_produk,
                    'nama_produk' => $product->nama_produk,
                    'stock' => $product->stok_produk,
                    'available' => $product->stok_produk > 0,
                    'harga_subsidi' => $product->harga_subsidi,
                    'harga_normal' => $product->harga_normal
                ]
            ];

        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}

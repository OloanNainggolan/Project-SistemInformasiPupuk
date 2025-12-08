<?php

namespace App\Http\Controllers\Api\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Get all products
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $query = Product::with(['images' => function($q) {
                $q->orderBy('order');
            }]);

            // Filter by type
            if ($request->has('tipe_produk')) {
                $query->where('tipe_produk', $request->tipe_produk);
            }

            // Search
            if ($request->has('search')) {
                $query->where(function($q) use ($request) {
                    $q->where('nama_produk', 'like', '%' . $request->search . '%')
                      ->orWhere('deskripsi', 'like', '%' . $request->search . '%');
                });
            }

            $products = $query->orderBy('created_at', 'desc')
                            ->paginate($request->per_page ?? 15);

            return response()->json([
                'success' => true,
                'message' => 'Products retrieved successfully',
                'data' => $products
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve products',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get single product by ID
     * 
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $product = Product::with(['images' => function($q) {
                $q->orderBy('order');
            }])->find($id);

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Product retrieved successfully',
                'data' => $product
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check product stock (Internal API untuk Sales)
     * 
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkStock($id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Stock checked successfully',
                'data' => [
                    'product_id' => $product->id_produk,
                    'nama_produk' => $product->nama_produk,
                    'stock' => $product->stok_produk,
                    'available' => $product->stok_produk > 0,
                    'harga_subsidi' => $product->harga_subsidi,
                    'harga_normal' => $product->harga_normal
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to check stock',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

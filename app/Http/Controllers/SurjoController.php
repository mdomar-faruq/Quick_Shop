<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SurjoController extends Controller
{
    public function surjo()
    {
        return view('frontend.surjo_final');
        // return view('frontend.surjo');
    }
    public function getCategoriesWithProduct()
    {
        $rows = DB::table('categories')
            ->join('products', 'categories.id', '=', 'products.category_id')
            ->select(
                'categories.slug as category_slug',   // use slug instead of numeric ID
                'categories.name as category_name',
                'categories.image as flag',
                'products.id as kit_id',
                'products.name as kit_name',
                'products.price',
                'products.image as img'
            )
            ->where('categories.status', 1)
            ->where('products.status', 1)
            ->get();

        $teams = [];

        foreach ($rows as $row) {
            $id = $row->category_slug; // short code like 'fr', 'br', 'jp'

            if (!isset($teams[$id])) {
                $teams[$id] = [
                    'id'   => $id,
                    'name' => $row->category_name,
                    'flag' => $row->flag,
                    'kits' => []
                ];
            }

            $teams[$id]['kits'][] = [
                'id'    => $row->kit_id,
                'name'  => $row->kit_name,
                'price' => $row->price,
                'img'   => $row->img,
            ];
        }

        return response()->json(array_values($teams));
    }
    public function apiBlogs()
    {
        $blogs = DB::table('blogs')
            ->leftJoin('categories', 'blogs.category_id', 'categories.id')
            ->select('blogs.*', 'categories.slug')
            ->where('blogs.status', 1)
            ->get();
        return response()->json($blogs);
    }

    public function apiProduct()
    {
        $products = DB::table('products')->where('status', 1)->get();
        return response()->json($products);
    }

    public function surjoOrderStore(Request $request)
    {
        try {
            // Validate input
            $request->validate([
                // 'customer_name' => 'required|string|max:255',
                'mobile'        => 'required|max:20',
                // 'address'       => 'required|string|max:500',
                'cart'          => 'required|array|min:1',
                'total'         => 'required|numeric|min:0'
            ]);

            // Insert into orders table
            DB::table('orders')->insert([
                'customer_name' => $request->customer_name,
                'mobile'        => $request->mobile,
                'address'       => $request->address,
                'cart_details'  => json_encode($request->cart), // store cart as JSON
                'total_amount'  => $request->total,
                'status'        => 'pending',
                'created_at'    => now(),
                'updated_at'    => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Order Received'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}

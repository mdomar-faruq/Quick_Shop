<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SurjoController extends Controller
{
    public function surjo(Request $request)
    {
        $products = DB::table('products')
            ->latest()
            ->paginate(12);

        // If it's an AJAX request, return only the product cards (not the whole page)
        if ($request->ajax()) {
            return view('partials.product_cards', compact('products'))->render();
        }
        return view('frontend.surjo_final', compact('products'));
        // return view('frontend.surjo');
    }
    public function getCategoriesWithProduct()
    {
        $rows = DB::table('categories')
            ->join('products', 'categories.id', '=', 'products.category_id')
            ->select(
                'categories.slug as category_slug',
                'categories.name as category_name',
                'categories.image as flag',
                'products.id as kit_id',
                'products.name as kit_name',
                'products.slug as kit_slug',   // CRITICAL: Added this
                'products.price',
                'products.old_price',          // Added for "Platinum" design
                'products.image as img',
                'products.description'         // Optional: if you want a quick preview
            )
            ->where('categories.status', 1)
            ->where('products.status', 1)
            ->orderBy('products.id', 'desc')   // Show newest kits first
            ->get();

        $teams = [];

        foreach ($rows as $row) {
            $slug = $row->category_slug;

            if (!isset($teams[$slug])) {
                $teams[$slug] = [
                    'id'   => $slug,
                    'name' => $row->category_name,
                    'flag' => $row->flag,
                    'kits' => []
                ];
            }

            $teams[$slug]['kits'][] = [
                'id'        => $row->kit_id,
                'name'      => $row->kit_name,
                'slug'      => $row->kit_slug,     // CRITICAL: Pass this to JS
                'price'     => $row->price,
                'old_price' => $row->old_price,    // Pass this to show discounts
                'img'       => $row->img,
            ];
        }

        return response()->json(array_values($teams));
    }

    public function getProductDetails($slug)
    {
        // Find product by slug
        $product = DB::table('products')
            ->where('slug', $slug)
            ->where('status', 1)
            ->first();

        if (!$product) abort(404);

        $similar = DB::table('products')
            // ->where('category_id', $product->category_id) // Un-comment for relevant matches
            ->where('id', '!=', $product->id)
            ->inRandomOrder() // This makes the selection random
            ->limit(4)
            ->get();

        return view('frontend.details', compact('product', 'similar'));
    }
    public function apiBlogs()
    {
        $blogs = DB::table('blogs')
            ->leftJoin('categories', 'blogs.category_id', 'categories.id')
            ->select('blogs.*', 'categories.slug')
            ->where('blogs.status', 1)
            ->get()
            ->map(function ($blog) {
                // Decode images if stored as JSON string
                $blog->images = $blog->images ? json_decode($blog->images, true) : [];
                return $blog;
            });

        return response()->json($blogs, 200, [], JSON_UNESCAPED_SLASHES);
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
                'delivery_charge' => $request->delivery_charge,
                'subtotal' => $request->subtotal,
                'total_amount'  => $request->total,
                'delivery_area'   => $request->delivery_type,
                'status'        => 'pending',
                'created_at'    => now(),
                'updated_at'    => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Order created'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error'   => $e->getMessage()
            ], 500);
        }
    }
    public function surjoOrderStore2(Request $request)
    {
        try {
            $request->validate([
                // 'name'       => 'required|max:255',
                'phone'      => 'required|max:20',
                // 'address'    => 'required|max:500',
                'product_id' => 'required',
                'price'      => 'required|numeric',
                'size'       => 'required'
            ]);

            $cartDetails = [
                [
                    'product_id' => $request->product_id,
                    'name'       => $request->product_name,
                    'price'      => $request->price,
                    'size'       => $request->size,
                    'qty'        => 1
                ]
            ];

            DB::table('orders')->insert([
                'customer_name'   => $request->name,
                'mobile'          => $request->phone,
                'address'         => $request->address,
                'cart_details'    => json_encode($cartDetails),
                'delivery_charge' => $request->delivery_charge ?? 0,
                'subtotal'        => $request->price,
                'total_amount'    => ($request->price + ($request->delivery_charge ?? 0)),
                'delivery_area'   => $request->delivery_type ?? 'not specified',
                'status'          => 'pending',
                'created_at'      => now(),
                'updated_at'      => now()
            ]);

            // সাকসেস মেসেজ সহ আগের পেজে ফেরত পাঠানো
            return redirect()->back()->with('success', 'ধন্যবাদ! আপনার অর্ডারটি সফলভাবে গৃহীত হয়েছে।');
        } catch (\Exception $e) {
            // এরর মেসেজ সহ ফেরত পাঠানো
            return redirect()->back()->with('error', 'অর্ডার সম্পন্ন করা সম্ভব হয়নি: ' . $e->getMessage());
        }
    }
}

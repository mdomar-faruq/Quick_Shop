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
    public function apiProduct()
    {
        $products = DB::table('products')->where('status', 1)->get();
        return response()->json($products);
    }

    public function surjoOrderStore(Request $request)
    {
        try {
            DB::table('orders')->insert([
                'customer_name' => $request->name,
                'mobile'        => $request->mobile,
                'address'       => $request->address,
                'cart_details'  => json_encode($request->cart),
                'total_amount'         => $request->total,
                'created_at'    => now(),
                'updated_at'    => now() // DB::insert requires you to manually add this
            ]);

            return response()->json(['status' => 'Order Received'], 200);
        } catch (\Exception $e) {
            // This will tell you exactly what is wrong in your browser's Network Tab
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminSurjoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function adminHome()
    {
        $orders = DB::table('orders')->orderBy('created_at', 'desc')->get();
        return view('backend.home', compact('orders'));
    }
    public function adminSetting() {}


    //Product
    public function adminProduct()
    {
        $products = DB::table('products')->get();
        return view('backend.products.index', compact('products'));
    }
    public function adminAddProduct()
    {
        return view('backend.products.add');
    }

    public function adminProductStore(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // 1. Store the file physically
            $path = $request->file('image')->store('products', 'public');

            // 2. Convert path to Full URL (e.g., http://yourdomain.com/storage/products/xyz.jpg)
            $fullUrl = asset('storage/' . $path);

            // 3. Save the full URL to the database

        } else {
            $fullUrl = '';
        }

        $path = $request->file('image')->store('products', 'public');

        DB::table('products')->insert([
            'name'       => $request->name,
            'price'      => $request->price,
            'image'      => $fullUrl,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('adminProduct')->with('success', 'Product added successfully!');
    }

    public function adminProductEdit($id)
    {
        $product = DB::table('products')->where('id', $id)->first();
        return view('backend.products.edit', compact('product'));
    }

    public function adminProductUpdate(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            // 'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'name'       => $request->name,
            'price'      => $request->price,
            'updated_at' => now(),
        ];

        $product = DB::table('products')->where('id', $id)->first();
        if ($request->hasFile('image')) {
            // DELETE PREVIOUS IMAGE Logic
            if ($product->image) {
                // Since we stored the full URL, we need to extract the path to delete it
                // This removes "http://domain.com/storage/" from the string
                $oldPath = str_replace(asset('storage/'), '', $product->image);
                Storage::disk('public')->delete($oldPath);
            }

            // Store new and generate Full URL
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = asset('storage/' . $path);
        }

        DB::table('products')->where('id', $id)->update($data);

        return redirect()->route('adminProduct')->with('success', 'Product updated successfully!');
    }

    public function adminProductEnableDisable(Request $request, $id)
    {
        try {
            DB::table('products')
                ->where('id', $id)
                ->update(['status' => $request->txt_status]); // ✅ use key => value

            return back()->with('success', 'Product updated successfully!');
        } catch (\Exception $e) {
            // This will tell you exactly what is wrong in your browser's Network Tab
            return back()->with('error', $e->getMessage());
        }
    }


    //
    public function recentOrder()
    {
        $orders = DB::table('orders')
            ->orderBy('id', 'desc')
            ->limit('50')
            ->get();
        return view('backend.orders.recent', compact('orders'));
    }
    public function pendingOrder()
    {
        $orders = DB::table('orders')
            ->where('status', "pending")
            ->orderBy('id', 'desc')
            ->get();
        return view('backend.orders.pending', compact('orders'));
    }
    public function cancelledOrder()
    {
        $orders = DB::table('orders')
            ->where('status', "cancelled")
            ->orderBy('id', 'desc')
            ->get();
        return view('backend.orders.cancelled', compact('orders'));
    }
    public function deliveredOrder()
    {
        $orders = DB::table('orders')
            ->where('status', "delivered")
            ->orderBy('id', 'desc')
            ->get();
        return view('backend.orders.delivered', compact('orders'));
    }

    public function adminOrderUpdateStatus(Request $request, $id)
    {
        try {
            DB::table('orders')
                ->where('id', $id)
                ->update(['status' => $request->status]); // ✅ use key => value

            return back()->with('success', "$request->status successfully!");
        } catch (\Exception $e) {
            // This will tell you exactly what is wrong in your browser's Network Tab
            return back()->with('error', $e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

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
    public function adminCategorie()
    {
        $categories = DB::table('categories')->get();
        return view('backend.categories.index', compact('categories'));
    }

    public function adminAddCategory()
    {
        return view('backend.categories.add');
    }

    public function adminCategoryStore(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            // 'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // 1. Store the file physically
            $path = $request->file('image')->store('categories', 'public');

            // 2. Convert path to Full URL (e.g., http://yourdomain.com/storage/categories/xyz.jpg)
            $fullUrl = asset('storage/' . $path);

            // 3. Save the full URL to the database

        } else {
            $fullUrl = '';
        }

        $path = $request->file('image')->store('products', 'public');

        DB::table('categories')->insert([
            'name'       => $request->name,
            'slug' => Str::slug($request->name),
            'image'      => $fullUrl,
            'user_id'       => Auth::user()->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('adminCategorie')->with('success', 'Category added successfully!');
    }

    public function adminCategoryEdit($id)
    {
        $categories = DB::table('categories')->where('id', $id)->first();
        return view('backend.categories.edit', compact('categories'));
    }

    public function adminCategoryUpdate(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            // 'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'name'       => $request->name,
            'slug' => Str::slug($request->name),
            'user_id'       => Auth::user()->id,
            'updated_at' => now(),
        ];

        $categories = DB::table('categories')->where('id', $id)->first();
        if ($request->hasFile('image')) {
            // DELETE PREVIOUS IMAGE Logic
            if ($categories->image) {
                // Since we stored the full URL, we need to extract the path to delete it
                // This removes "http://domain.com/storage/" from the string
                $oldPath = str_replace(asset('storage/'), '', $categories->image);
                Storage::disk('public')->delete($oldPath);
            }

            // Store new and generate Full URL
            $path = $request->file('image')->store('categories', 'public');
            $data['image'] = asset('storage/' . $path);
        }

        DB::table('categories')->where('id', $id)->update($data);

        return redirect()->route('adminCategorie')->with('success', 'Category updated successfully!');
    }

    public function adminCategoryEnableDisable(Request $request, $id)
    {
        try {
            DB::table('categories')
                ->where('id', $id)
                ->update(['status' => $request->txt_status]); // ✅ use key => value

            return back()->with('success', 'Category updated successfully!');
        } catch (\Exception $e) {
            // This will tell you exactly what is wrong in your browser's Network Tab
            return back()->with('error', $e->getMessage());
        }
    }


    //Product
    public function adminProduct()
    {
        $products = DB::table('products')
            ->leftJoin('categories', 'products.category_id', 'categories.id')
            ->select('products.*', 'categories.name as cat_name')
            ->latest('products.id') // Shows newest products at the top
            ->paginate(15); // Splits products into pages of 15

        return view('backend.products.index', compact('products'));
    }
    public function adminAddProduct()
    {
        $categories = DB::table('categories')->get();
        return view('backend.products.add', compact('categories'));
    }

    public function adminProductStore(Request $request)
    {
        // 1. Validation (Added new fields)
        $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'required|string|unique:products,slug',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric|min:0',
            'old_price'   => 'nullable|numeric|min:0',
            // 'image'       => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'image'       => 'required|image',
            // 'gallery.*'   => 'image|mimes:jpeg,png,jpg,webp|max:2048', // Validate each gallery image
            'description' => 'nullable|string',
        ]);

        // 2. Handle Main Image
        $fullUrl = '';
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $fullUrl = asset('storage/' . $path);
        }

        // 3. Handle Gallery Images (Multiple)
        $galleryUrls = [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $gPath = $file->store('products/gallery', 'public');
                $galleryUrls[] = asset('storage/' . $gPath);
            }
        }

        // 4. Insert into Database
        DB::table('products')->insert([
            'name'        => $request->name,
            'slug'        => \Illuminate\Support\Str::slug($request->slug), // Ensure slug format
            'price'       => $request->price,
            'old_price'   => $request->old_price,
            'image'       => $fullUrl,
            'gallery'     => json_encode($galleryUrls), // Save array as JSON string
            'description' => $request->description,
            'category_id' => $request->category_id,
            'user_id'     => Auth::id(),
            'status'      => 1,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        return redirect()->route('adminProduct')->with('success', 'Platinum Product added successfully!');
    }

    public function adminProductEdit($id)
    {
        $product = DB::table('products')->where('id', $id)->first();
        $categories = DB::table('categories')->get();
        $product->gallery = json_decode($product->gallery) ?? [];
        return view('backend.products.edit', compact('product', 'categories'));
    }

    public function adminProductUpdate(Request $request, $id)
    {
        // 1. Find existing product
        $product = DB::table('products')->where('id', $id)->first();
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        // 2. Validation
        $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'required|string|unique:products,slug,' . $id,
            'category_id' => 'required',
            'price'       => 'required|numeric',
            // 'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            // 'gallery.*'   => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = [
            'name'        => $request->name,
            'slug'        => \Illuminate\Support\Str::slug($request->slug),
            'price'       => $request->price,
            'old_price'   => $request->old_price,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'updated_at'  => now(),
        ];

        // 3. Handle Main Image (Delete Old if New Uploaded)
        if ($request->hasFile('image')) {
            // Delete old physical file
            if ($product->image) {
                $oldPath = public_path('storage/' . str_replace(asset('storage/'), '', $product->image));
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }
            // Upload new file
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = asset('storage/' . $path);
        }

        // 4. Handle Gallery (Delete All Old if New Gallery Uploaded)
        if ($request->hasFile('gallery')) {
            $oldGallery = json_decode($product->gallery) ?? [];
            foreach ($oldGallery as $oldImg) {
                $oldGPath = public_path('storage/' . str_replace(asset('storage/'), '', $oldImg));
                if (File::exists($oldGPath)) {
                    File::delete($oldGPath);
                }
            }

            $newGalleryUrls = [];
            foreach ($request->file('gallery') as $file) {
                $gPath = $file->store('products/gallery', 'public');
                $newGalleryUrls[] = asset('storage/' . $gPath);
            }
            $data['gallery'] = json_encode($newGalleryUrls);
        }

        // 5. Update Database
        DB::table('products')->where('id', $id)->update($data);

        return redirect()->route('adminProduct')->with('success', 'Product updated and old files cleaned!');
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

    //Blog
    public function adminBlog()
    {
        $blogs = DB::table('blogs')
            ->leftJoin('categories', 'blogs.category_id', 'categories.id')
            ->select('blogs.*', 'categories.name as cat_name')
            ->get();
        return view('backend.blogs.index', compact('blogs'));
    }
    public function adminAddBlog()
    {
        $categories = DB::table('categories')->get();
        return view('backend.blogs.add', compact('categories'));
    }

    public function adminBlogStore(Request $request)
    {
        // ✅ Validation
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'offer_price_text' => 'required|string|max:255',
            'offer_price' => 'required|numeric|min:0',
            'regular_price' => 'required|numeric|min:0',
            // 'images.*' => 'image',
            'short_description' => 'nullable|string',
        ]);

        // ✅ Handle multiple images
        $paths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('blogs', 'public'); // stored in storage/app/public/blogs
                $paths[] = asset('storage/' . $path);
            }
        }

        // ✅ Insert into blogs table using Query Builder
        DB::table('blogs')->insert([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'offer_price_text' => $request->offer_price_text,
            'offer_price' => $request->offer_price,
            'regular_price' => $request->regular_price,
            'images' => json_encode($paths), // store as JSON
            'short_description' => $request->short_description,
            'status' => 1,
            'user_id'       => Auth::user()->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect()->route('adminBlog')->with('success', 'Blog added successfully!');
    }

    public function adminBlogEdit($id)
    {
        $categories = DB::table('categories')->get();
        $blog = DB::table('blogs')->where('id', $id)->first();
        return view('backend.blogs.edit', compact('blog', 'categories'));
    }

    public function adminBlogUpdate(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'offer_price_text' => 'required|string|max:255',
            'offer_price' => 'required|numeric|min:0',
            'regular_price' => 'required|numeric|min:0',
            // 'images.*' => 'nullable|mimes:jpeg,png,jpg,gif,JPEG,JPG,PNG',
            'short_description' => 'nullable|string',
        ]);

        $blog = DB::table('blogs')->where('id', $id)->first();

        $paths = json_decode($blog->images, true) ?? [];

        if ($request->hasFile('images')) {
            $paths = []; // replace old images, or merge if you prefer
            foreach ($request->file('images') as $file) {
                $storedPath = $file->store('blogs', 'public');
                $paths[] = url('storage/' . $storedPath); // full URL
            }
        }

        DB::table('blogs')->where('id', $id)->update([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'offer_price_text' => $request->offer_price_text,
            'offer_price' => $request->offer_price,
            'regular_price' => $request->regular_price,
            'images' => json_encode($paths),
            'short_description' => $request->short_description,
            'updated_at' => now(),
        ]);

        return redirect()->route('adminBlog')->with('success', 'Blog updated successfully!');
    }



    public function adminBlogEnableDisable(Request $request, $id)
    {
        try {
            DB::table('blogs')
                ->where('id', $id)
                ->update(['status' => $request->txt_status]); // ✅ use key => value

            return back()->with('success', 'updated successfully!');
        } catch (\Exception $e) {
            // This will tell you exactly what is wrong in your browser's Network Tab
            return back()->with('error', $e->getMessage());
        }
    }
    //End Blog

    //
    public function orderView($id)
    {
        $order = DB::table('orders')
            ->where('id', $id)
            ->first();
        if ($order) {
            return view('backend.orders.view', compact('order'));
        } else {
            return back()->with('error', "Data Not Found");
        }
    }
    public function recentOrder()
    {
        $orders = DB::table('orders')
            ->orderBy('id', 'desc')
            ->limit('50')
            ->get();
        return view('backend.orders.recent', compact('orders'));
    }
    public function confirmOrder()
    {
        $orders = DB::table('orders')
            ->where('status', "confirm")
            ->orderBy('id', 'desc')
            ->get();
        return view('backend.orders.confirm', compact('orders'));
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

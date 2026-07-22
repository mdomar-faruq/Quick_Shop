<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
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

    private function uploadDisk(): string
    {
        $disk = env('FILESYSTEM_DISK', 'public');

        if (in_array($disk, ['local', 'private'], true)) {
            return 'public';
        }

        return $disk;
    }

    private function buildStorageUrl(string $disk, string $path): string
    {
        $diskConfig = config("filesystems.disks.{$disk}");

        if (!empty($diskConfig['url'])) {
            return rtrim($diskConfig['url'], '/') . '/' . ltrim($path, '/');
        }

        if ($disk === 'public') {
            return url('storage/' . ltrim($path, '/'));
        }

        return url(ltrim($path, '/'));
    }

    public function adminHome()
    {
        $orders = DB::table('orders')
            ->where('status', "pending")
            ->orderBy('created_at', 'desc')
            ->get();

        $orders_deliverd = DB::table('orders')
            ->where('status', "delivered")
            ->count();

        $orders_total = DB::table('orders')
            ->count();

        return view('backend.home', compact('orders', 'orders_deliverd', 'orders_total'));
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
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $disk = $this->uploadDisk();
        $fullUrl = '';

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('categories', $disk);
            $fullUrl = $this->buildStorageUrl($disk, $path);
        }

        DB::table('categories')->insert([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'image' => $fullUrl,
            'user_id' => Auth::user()->id,
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
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'name'       => $request->name,
            'slug' => Str::slug($request->name),
            'user_id'       => Auth::user()->id,
            'updated_at' => now(),
        ];

        $disk = $this->uploadDisk();
        $categories = DB::table('categories')->where('id', $id)->first();
        if ($request->hasFile('image')) {
            if ($categories->image) {
                $relativePath = str_replace(rtrim(config("filesystems.disks.{$disk}.url", url('/storage')), '/') . '/', '', $categories->image);
                Storage::disk($disk)->delete($relativePath);
            }

            $path = $request->file('image')->store('categories', $disk);
            $data['image'] = $this->buildStorageUrl($disk, $path);
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
            'image'       => 'required|image',
            'description' => 'nullable|string',
        ]);

        $disk = $this->uploadDisk();

        // 2. Handle Main Image
        $fullUrl = '';
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', $disk);
            $fullUrl = $this->buildStorageUrl($disk, $path);
        }

        // 3. Handle Gallery Images (Multiple)
        $galleryUrls = [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $gPath = $file->store('products/gallery', $disk);
                $galleryUrls[] = $this->buildStorageUrl($disk, $gPath);
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

        $disk = $this->uploadDisk();

        // 3. Handle Main Image (Delete Old if New Uploaded)
        if ($request->hasFile('image')) {
            if ($product->image) {
                $relativePath = str_replace(rtrim(config("filesystems.disks.{$disk}.url", url('/storage')), '/') . '/', '', $product->image);
                Storage::disk($disk)->delete($relativePath);
            }

            $path = $request->file('image')->store('products', $disk);
            $data['image'] = $this->buildStorageUrl($disk, $path);
        }

        // 4. Handle Gallery (Delete All Old if New Gallery Uploaded)
        if ($request->hasFile('gallery')) {
            $oldGallery = json_decode($product->gallery) ?? [];
            foreach ($oldGallery as $oldImg) {
                $relativePath = str_replace(rtrim(config("filesystems.disks.{$disk}.url", url('/storage')), '/') . '/', '', $oldImg);
                Storage::disk($disk)->delete($relativePath);
            }

            $newGalleryUrls = [];
            foreach ($request->file('gallery') as $file) {
                $gPath = $file->store('products/gallery', $disk);
                $newGalleryUrls[] = $this->buildStorageUrl($disk, $gPath);
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
            'short_description' => 'nullable|string',
        ]);

        $disk = $this->uploadDisk();

        // ✅ Handle multiple images
        $paths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('blogs', $disk);
                $paths[] = $this->buildStorageUrl($disk, $path);
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
        $disk = $this->uploadDisk();

        $paths = json_decode($blog->images, true) ?? [];

        if ($request->hasFile('images')) {
            $paths = [];
            foreach ($request->file('images') as $file) {
                $storedPath = $file->store('blogs', $disk);
                $paths[] = $this->buildStorageUrl($disk, $storedPath);
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

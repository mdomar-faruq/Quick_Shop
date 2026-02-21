<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SurjoController;
use App\Http\Controllers\AdminSurjoController;

Auth::routes();

//--------------------------Frontend------------------------------------------------
Route::get('/', [SurjoController::class, 'surjo'])->name('surjo');
Route::get('/api/categories/with_product', [SurjoController::class, 'getCategoriesWithProduct']);
Route::get('/api/blogs', [SurjoController::class, 'apiBlogs']);
Route::get('/api/products', [SurjoController::class, 'apiProduct']);
Route::post('/api/orders', [SurjoController::class, 'surjoOrderStore']);




//--------------------------backend------------------------------------------------
Route::middleware(['auth'])->prefix('admin')->group(function () {
 Route::get('/', [AdminSurjoController::class, 'adminHome'])->name('adminHome');
 Route::get('/setting', [AdminSurjoController::class, 'adminSetting'])->name('adminSetting');


 //categories
 Route::get('/categorie', [AdminSurjoController::class, 'adminCategorie'])->name('adminCategorie');
 Route::get('/add_categorie', [AdminSurjoController::class, 'adminAddCategory'])->name('adminAddCategory');
 Route::post('/categorie', [AdminSurjoController::class, 'adminCategoryStore'])->name('adminCategoryStore');
 Route::get('/categorie/{id}/edit', [AdminSurjoController::class, 'adminCategoryEdit'])->name('adminCategoryEdit');
 Route::post('/categorie/{id}/edit', [AdminSurjoController::class, 'adminCategoryUpdate'])->name('adminCategoryUpdate');
 //enable or disable
 Route::post('/categorie/enable_or_disable/{id}', [AdminSurjoController::class, 'adminCategoryEnableDisable'])->name('adminCategoryEnableDisable');
 //End categories

 //products
 Route::get('/product', [AdminSurjoController::class, 'adminProduct'])->name('adminProduct');
 Route::get('/add_product', [AdminSurjoController::class, 'adminAddProduct'])->name('adminAddProduct');
 Route::post('/product', [AdminSurjoController::class, 'adminProductStore'])->name('adminProductStore');
 Route::get('/product/{id}/edit', [AdminSurjoController::class, 'adminProductEdit'])->name('adminProductEdit');
 Route::post('/product/{id}/edit', [AdminSurjoController::class, 'adminProductUpdate'])->name('adminProductUpdate');
 //enable or disable
 Route::post('/product/enable_or_disable/{id}', [AdminSurjoController::class, 'adminProductEnableDisable'])->name('adminProductEnableDisable');
 //end products


 //Blog
 Route::get('/blog', [AdminSurjoController::class, 'adminBlog'])->name('adminBlog');
 Route::get('/add_blog', [AdminSurjoController::class, 'adminAddBlog'])->name('adminAddBlog');
 Route::post('/blog', [AdminSurjoController::class, 'adminBlogStore'])->name('adminBlogStore');
 Route::get('/blog/{id}/edit', [AdminSurjoController::class, 'adminBlogEdit'])->name('adminBlogEdit');
 Route::post('/blog/{id}/edit', [AdminSurjoController::class, 'adminBlogUpdate'])->name('adminBlogUpdate');
 //enable or disable
 Route::post('/blog/enable_or_disable/{id}', [AdminSurjoController::class, 'adminBlogEnableDisable'])->name('adminBlogEnableDisable');

 //orders
 Route::get('/recent_order', [AdminSurjoController::class, 'recentOrder'])->name('recentOrder');
 Route::get('/pending_order', [AdminSurjoController::class, 'pendingOrder'])->name('pendingOrder');
 Route::get('/cancelled_order', [AdminSurjoController::class, 'cancelledOrder'])->name('cancelledOrder');
 Route::get('/delivered_order', [AdminSurjoController::class, 'deliveredOrder'])->name('deliveredOrder');
 Route::post('/order_update_status/{id}', [AdminSurjoController::class, 'adminOrderUpdateStatus'])->name('adminOrderUpdateStatus');
});

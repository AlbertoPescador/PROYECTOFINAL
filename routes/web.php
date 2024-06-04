<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\UserPanel\UserController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin',[AdminController::class, 'index'])->name('admin.principal');
    
    Route::get('admin/gestproduct', [ProductController::class, 'gestProduct'])->name('admin.product.index');
    Route::get('admin/gestproduct/create', [ProductController::class, 'create'])->name('admin.product.create');
    Route::post('admin/gestproduct/create', [ProductController::class, 'store'])->name('admin.product.store');
    Route::get('admin/gestproduct/edit/{product_id}', [ProductController::class, 'edit'])->name('admin.product.edit');
    Route::put('admin/gestproduct/edit/{product_id}', [ProductController::class, 'update'])->name('admin.product.update');
    Route::delete('/admin/gestproduct/delete/{product_id}', [ProductController::class, 'destroy'])->name('admin.product.destroy');
    Route::get('/admin/gestproduct/searchAdmin', [ProductController::class, 'searchAdmin'])->name('product.searchAdmin');
    Route::post('/admin/gestproduct/searchAdmin', [ProductController::class, 'searchAdmin'])->name('product.searchAdmin.submit');

    Route::get('admin/gestcategory', [CategoryController::class, 'gestCategory'])->name('admin.category.index');
    Route::get('admin/gestcategory/create', [CategoryController::class, 'create'])->name('admin.category.create');
    Route::post('admin/gestcategory/create', [CategoryController::class, 'store'])->name('admin.category.store');
    Route::get('admin/gestcategory/edit/{category_id}', [CategoryController::class, 'edit'])->name('admin.category.edit');
    Route::put('admin/gestcategory/edit/{category_id}', [CategoryController::class, 'update'])->name('admin.category.update');
    Route::delete('/admin/gestcategory/delete/{category_id}', [CategoryController::class, 'destroy'])->name('admin.category.destroy');
    Route::get('/admin/gestcategory/searchAdmin', [CategoryController::class, 'search'])->name('category.searchAdmin');
    Route::post('/admin/gestcategory/searchAdmin', [CategoryController::class, 'search'])->name('category.searchAdmin.submit');
    
    Route::get('admin/gestorder', [InvoiceController::class, 'gestOrders'])->name('admin.order.index');
    Route::get('admin/gestorders/search', [InvoiceController::class, 'searchUsers'])->name('admin.order.searchUsers');
    Route::get('admin/gestorders/users/{id}/invoices', [InvoiceController::class, 'showUserInvoices'])->name('admin.order.userInvoices');    

    Route::get('/admin/users', [ProfileController::class, 'viewRole'])->name('admin.user.view');
    Route::put('/admin/users/{id}', [ProfileController::class, 'updateRole'])->name('admin.user.update');
    Route::delete('/admin/users/delete/{id}', [ProfileController::class, 'destroyAdmin'])->name('admin.user.destroy');
    Route::get('/admin/user/search', [ProfileController::class, 'search'])->name('user.search');
    Route::post('/admin/user/search', [ProfileController::class, 'search'])->name('user.search.submit');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/principal',[UserController::class, 'index'])->name('user.principal');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

    Route::get('/products', [ProductController::class, 'productListOrder'])->name('products.list');
    Route::get('/products/{product_id}', [ProductController::class, 'moreInformation'])->name('product.moreInformation');
    //Route::get('/products/{category_id}', [ProductController::class, 'productListByCategory'])->name('products.category');
    Route::get('/products/category/{category_id?}', [ProductController::class, 'productListByCategory'])->name('products.category');

    // Ruta para la búsqueda de productos (GET y POST)
    Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
    Route::post('/products/search', [ProductController::class, 'search'])->name('products.search.submit');
    Route::get('/ofertas', [ProductController::class, 'sales'])->name('product.sales');
    Route::post('/generar-factura', [InvoiceController::class, 'generateInvoices'])->name('invoice.generateInvoices');
    Route::get('/mis-pedidos', [InvoiceController::class, 'myInvoices'])->name('invoice.myinvoices');
    Route::get('/invoices/{id}', [InvoiceController::class, 'show'])->name('invoices.show');

    Route::get('/cart', [CartController::class, 'cartList'])->name('cart.list');
    Route::post('/cart', [CartController::class, 'addToCart'])->name('cart.store');
    Route::post('/update-cart', [CartController::class, 'updateCart'])->name('cart.update');
    Route::post('/remove', [CartController::class, 'removeCart'])->name('cart.remove');
    Route::post('/clear', [CartController::class, 'clearAllCart'])->name('cart.clear');

    Route::get('/cart', [CartController::class, 'cartList'])->name('cart.list');
    Route::post('/cart', [CartController::class, 'addToCart'])->name('cart.store');
    Route::post('/update-cart', [CartController::class, 'updateCart'])->name('cart.update');
    Route::post('/remove', [CartController::class, 'removeCart'])->name('cart.remove');
    Route::post('/clear', [CartController::class, 'clearAllCart'])->name('cart.clear');
    
    Route::get('/confirm', [CartController::class, 'cartConfirm'])->name('cart.confirm');
    Route::post('/confirm', [CartController::class, 'cartConfirm'])->name('cart.confirm');
    Route::get('/confirmcart', [CartController::class, 'confirmCart'])->name('cart.confirmcart');
    Route::get('/select', [CartController::class, 'cartSelect'])->name('cart.select');
    Route::post('order/confirm', [CartController::class, 'confirmOrder'])->name('order.confirm');

    Route::get('order/success', [CartController::class, 'finalConfirm'])->name('order.finalConfirm');


});

require __DIR__.'/auth.php';
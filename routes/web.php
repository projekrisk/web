<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use App\Models\Product;
use App\Models\Article;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function (Request $request) {$search = $request->query('search');$query = Product::where('status', 'active');
    
    if ($search) {$query->where(function($q) use ($search) {
            $q->where('name', 'like', "\%{$search}%")
              ->orWhere('category', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
        $products =$query->latest()->get(); 
    } else {
        $products =$query->latest()->take(6)->get(); 
    }
    
    $articles = Article::where('status', 'published')->latest()->take(3)->get();$reviews = \App\Models\Review::with(['user', 'product'])
                ->where('status', 'approved')
                ->latest()
                ->take(10)
                ->get();
    
    return view('welcome', compact('products', 'articles', 'reviews', 'search'));
});

Route::get('/produk', [FrontController::class, 'products'])->name('front.products'); 
Route::get('/produk/{slug}', [FrontController::class, 'showProduct'])->name('front.product'); 

Route::get('/blog', [FrontController::class, 'articles'])->name('front.articles'); 
Route::get('/blog/{slug}', [FrontController::class, 'showArticle'])->name('front.article');

Route::get('/docs/{slug}', [FrontController::class, 'showDocument'])->name('front.document');

Route::get('/syarat-ketentuan', [FrontController::class, 'terms'])->name('front.terms');
Route::get('/kebijakan-privasi', [FrontController::class, 'privacy'])->name('front.privacy');
Route::get('/kontak', [FrontController::class, 'contact'])->name('front.contact');

Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') { 
        return redirect()->route('admin.dashboard'); 
    }
    $orders = Order::where('user_id', auth()->id())->with('product')->latest()->get();
    return view('dashboard', compact('orders')); 
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/checkout/{slug}', [FrontController::class, 'checkout'])->name('front.checkout');
    Route::post('/checkout/{slug}/process', [FrontController::class, 'processCheckout'])->name('front.checkout.process');
    Route::get('/invoice/{order_number}', [FrontController::class, 'invoice'])->name('front.invoice');
    Route::post('/produk/{slug}/review', [ReviewController::class, 'store'])->name('front.review.store');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () { 
        $totalProducts = Product::count();
        $totalArticles = Article::count();$totalOrders = Order::count();
        $totalMembers = User::where('role', 'member')->count();$recentProducts = Product::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalProducts', 'totalArticles', 'totalOrders', 'totalMembers', 'recentProducts'
        )); 
    })->name('dashboard');

    Route::resource('categories', CategoryController::class)->except(['create', 'show', 'edit', 'update']);
    Route::resource('products', ProductController::class);
    Route::resource('articles', ArticleController::class);
    Route::resource('documents', DocumentController::class);
    Route::resource('payment', PaymentMethodController::class)
        ->except(['show'])
        ->parameters(['payment' => 'paymentMethod'])
        ->names('payment_methods');
    Route::post('/upload-image', [ImageUploadController::class, 'upload'])->name('upload_image');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update_status');
    Route::get('/reviews', [ReviewController::class, 'adminIndex'])->name('reviews.index');
    Route::patch('/reviews/{review}/toggle', [ReviewController::class, 'toggleStatus'])->name('reviews.toggle');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::resource('users', UserController::class)->except(['show']);
    Route::patch('/users/{user}/ban', [UserController::class, 'toggleBan'])->name('users.ban');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

use App\Http\Controllers\Auth\WaPasswordResetController;

Route::middleware('guest')->group(function () {
    Route::get('forgot-password', [WaPasswordResetController::class, 'showForm'])
                ->name('password.request');
                
    Route::post('forgot-password', [WaPasswordResetController::class, 'verify'])
                ->name('password.verify_wa');
});
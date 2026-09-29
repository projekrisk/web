<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Article;
use App\Models\Document;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FrontController extends Controller
{
    public function products(Request $request)
    {
        $search = $request->query('search');
        $category = $request->query('category'); 
        
        $productQuery = Product::query()->where('status', 'active');
        $isSimilarSearch = false; 

        if ($category) {
            $productQuery->where('category', $category);
        }

        if ($search) {
            $exactQuery = clone $productQuery;
            $exactQuery->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });

            if ($exactQuery->count() > 0) {
                $productQuery = $exactQuery;
            } else {
                $isSimilarSearch = true;
                
                $keywords = explode(' ', $search);
                
                $productQuery->where(function($q) use ($keywords) {
                    foreach ($keywords as $word) {
                        $cleanWord = trim($word);
                        if(strlen($cleanWord) > 2) { 
                            $q->orWhere('name', 'like', "%{$cleanWord}%")
                              ->orWhere('description', 'like', "%{$cleanWord}%");
                        }
                    }
                });

                if ($productQuery->count() == 0) {
                    $productQuery = Product::query()->where('status', 'active');
                    session()->flash('recommendation', true); 
                }
            }
        }

        $products = $productQuery->latest()->paginate(12)->withQueryString();
        
        $categories = Product::where('status', 'active')->select('category')->distinct()->pluck('category');
        
        return view('front.products', compact('products', 'search', 'category', 'categories', 'isSimilarSearch'));
    }

    public function showProduct($slug)
    {
        $product = Product::where('slug',$slug)
            ->where('status', 'active')
            ->with(['reviews' => function($q) {$q->where('status', 'approved')->with('user')->latest();
            }])
            ->firstOrFail();

        $canReview = false;
        $userReview = null;

        if (Auth::check()) {
            $hasPaid = Order::where('user_id', Auth::id())
                            ->where('product_id', $product->id)
                            ->where('status', 'paid')
                            ->exists();

            if ($hasPaid) {$canReview = true;
                $userReview = Review::where('user_id', Auth::id())
                                    ->where('product_id', $product->id)
                                    ->first();
            }
        }

        $isYoutube = false;
        if ($product->demo_url) {
            $urlLower = strtolower($product->demo_url);
            if (str_contains($urlLower, 'youtube.com') || str_contains($urlLower, 'youtu.be')) {$isYoutube = true;
            }
        }

        $relatedProducts = Product::where('category',$product->category)
                                  ->where('id', '!=', $product->id)
                                  ->where('status', 'active')
                                  ->latest()
                                  ->take(4)
                                  ->get();

        return view('front.product', compact('product', 'canReview', 'userReview', 'isYoutube', 'relatedProducts'));
    }

    public function articles(Request $request)
    {
        $search = $request->query('search');
        $category = $request->query('category');
        
        $articleQuery = Article::query()->where('status', 'published');
        $isSimilarSearch = false;

        if ($category) {
            $articleQuery->where('category', $category);
        }

        if ($search) {
            $exactQuery = clone $articleQuery;
            $exactQuery->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });

            if ($exactQuery->count() > 0) {
                $articleQuery = $exactQuery;
            } else {
                $isSimilarSearch = true;
                
                $keywords = explode(' ', $search);$articleQuery->where(function($q) use ($keywords) {
                    foreach ($keywords as$word) {
                        $cleanWord = trim($word);
                        if(strlen($cleanWord) > 2) { 
                            $q->orWhere('title', 'like', "%{$cleanWord}%")
                              ->orWhere('content', 'like', "%{$cleanWord}%");
                        }
                    }
                });

                if ($articleQuery->count() == 0) {$articleQuery = Article::query()->where('status', 'published');
                    session()->flash('recommendation', true); 
                }
            }
        }

        $articles = $articleQuery->latest()->paginate(9)->withQueryString();$categories = Article::where('status', 'published')->select('category')->distinct()->pluck('category');
        
        return view('front.articles', compact('articles', 'search', 'category', 'categories', 'isSimilarSearch'));
    }

    public function showArticle($slug)
    {
        $article = Article::where('slug', $slug)->where('status', 'published')->firstOrFail();$latest_articles = Article::where('status', 'published')
                                  ->where('id', '!=', $article->id)
                                  ->latest()
                                  ->take(4)
                                  ->get();
                                  
        return view('front.article', compact('article', 'latest_articles'));
    }

    public function showDocument($slug)
    {
        $document = Document::with('product')->where('slug',$slug)->firstOrFail();
        
        if ($document->status === 'draft') {
            if (!Auth::check() || Auth::user()->role !== 'admin') {
                abort(404); 
            }
        }

        $related_docs = Document::where('product_id',$document->product_id)
            ->when(!Auth::check() || Auth::user()->role !== 'admin', function($query) {
                return $query->where('status', 'published');
            })
            ->orderBy('title', 'asc')
            ->get();

        return view('front.document', compact('document', 'related_docs'));
    }

    public function checkout($slug)
    {
        $product = Product::where('slug',$slug)->where('status', 'active')->firstOrFail();
        return view('front.checkout', compact('product'));
    }

    public function processCheckout(Request $request,$slug)
    {
        $product = Product::where('slug', $slug)->where('status', 'active')->firstOrFail();$user = Auth::user();

        $existingOrder = Order::where('user_id',$user->id)
                              ->where('product_id', $product->id)
                              ->whereIn('status', ['pending', 'paid'])
                              ->first();

        if ($existingOrder) {
            return redirect()->route('front.invoice', $existingOrder->order_number)
                             ->with('info', 'Anda sudah memiliki tagihan atau sudah membeli produk ini.');
        }

        $orderNumber = 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(6));

        $kodeUnik =$product->price > 0 ? rand(111, 999) : 0;
        $totalHargaPlusKode = $product->price +$kodeUnik;

        $order = Order::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'order_number' => $orderNumber,
            'total_price' => $totalHargaPlusKode, 
            'status' => 'pending',
        ]);

        return redirect()->route('front.invoice', $order->order_number)
                         ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
    }

    public function invoice($order_number)
    {
        $order = Order::where('order_number',$order_number)
                      ->where('user_id', Auth::id())
                      ->with('product')
                      ->firstOrFail();

        $paymentMethods = PaymentMethod::where('status', 'active')->get();

        return view('front.invoice', compact('order', 'paymentMethods'));
    }

    public function terms()
    {
        return view('front.terms');
    }

    public function privacy()
    {
        return view('front.privacy');
    }

    public function contact()
    {
        return view('front.contact');
    }
}
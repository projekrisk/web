<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $userId = Auth::id();

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:5|max:1000',
        ]);

        $paidOrder = Order::where('user_id', $userId)
                          ->where('product_id', $product->id)
                          ->where('status', 'paid')
                          ->latest()
                          ->first();

        if (!$paidOrder) {
            return redirect()->back()->with('error', 'Anda hanya dapat memberikan ulasan pada produk yang telah Anda beli dan lunasi.');
        }

        $existingReview = Review::where('user_id', $userId)
                                ->where('product_id', $product->id)
                                ->first();

        if ($existingReview) {
            $existingReview->update([
                'rating' => $request->rating,
                'comment' => $request->comment,
                'status' => 'approved',
            ]);
            return redirect()->back()->with('success', 'Ulasan Anda berhasil diperbarui!');
        }

        Review::create([
            'user_id' => $userId,
            'product_id' => $product->id,
            'order_id' => $paidOrder->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => 'approved',
        ]);

        return redirect()->back()->with('success', 'Terima kasih atas ulasan yang Anda berikan!');
    }

    public function adminIndex(Request $request)
    {
        $query = Review::with(['user', 'product'])->latest();

        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $reviews = $query->paginate(10)->withQueryString();

        return view('admin.reviews.index', compact('reviews'));
    }

    public function toggleStatus(Review $review)
    {
        $newStatus = $review->status === 'approved' ? 'hidden' : 'approved';
        $review->update(['status' => $newStatus]);

        return redirect()->back()->with('success', 'Status ulasan berhasil diubah menjadi ' . $newStatus . '!');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->back()->with('success', 'Ulasan berhasil dihapus.');
    }
}
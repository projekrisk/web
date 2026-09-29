<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'product']);

        if ($request->filled('status')) {
            $query->where('status',$request->status);
        }

        $orders =$query->latest()->paginate(10)->withQueryString();

        $tahunIni = Carbon::now()->year;

        $totalKeseluruhan = Order::count();

        $pesananTahunIni = Order::whereYear('created_at',$tahunIni)->count();

        $penghasilanTahunIni = Order::whereYear('created_at',$tahunIni)
                                    ->where('status', 'paid')
                                    ->sum('total_price');

        return view('admin.orders.index', compact(
            'orders', 
            'totalKeseluruhan', 
            'pesananTahunIni', 
            'penghasilanTahunIni'
        ));
    }

    public function updateStatus(Request $request, Order$order)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,canceled',
        ]);

        $order->update(['status' =>$request->status]);

        return redirect()->route('admin.orders.index')->with('success', 'Status pesanan berhasil diperbarui!');
    }
}
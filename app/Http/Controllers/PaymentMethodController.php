<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $paymentMethods = PaymentMethod::latest()->get();
        return view('admin.payment_methods.index', compact('paymentMethods'));
    }

    public function create()
    {
        return view('admin.payment_methods.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'bank_name' => 'required|string|max:100',
            'account_number' => 'required|string|max:100',
            'account_owner' => 'required|string|max:100',
            'status' => 'required|in:active,inactive',
        ]);

        PaymentMethod::create($request->all());
        return redirect()->route('admin.payment_methods.index')->with('success', 'Metode pembayaran berhasil ditambahkan!');
    }

    public function edit(PaymentMethod $paymentMethod)
    {
        return view('admin.payment_methods.edit', compact('paymentMethod'));
    }

    public function update(Request $request, PaymentMethod$paymentMethod)
    {
        $request->validate([
            'bank_name' => 'required|string|max:100',
            'account_number' => 'required|string|max:100',
            'account_owner' => 'required|string|max:100',
            'status' => 'required|in:active,inactive',
        ]);

        $paymentMethod->update($request->all());
        return redirect()->route('admin.payment_methods.index')->with('success', 'Metode pembayaran berhasil diperbarui!');
    }

    public function destroy(PaymentMethod $paymentMethod)
    {
        $paymentMethod->delete();
        return redirect()->route('admin.payment_methods.index')->with('success', 'Metode pembayaran berhasil dihapus!');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', '!=', 'admin');

        if ($request->filled('search')) {
            $search =$request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('whatsapp_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'banned') {$query->where('is_banned', true);
            } elseif ($request->status === 'active') {$query->where('is_banned', false);
            }
        }

        $users =$query->latest()->paginate(10)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'whatsapp_number' => ['nullable', 'string', 'max:20'],
            'password' => ['required', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'whatsapp_number' => $request->whatsapp_number,
            'password' => Hash::make($request->password),
            'role' => 'member',
            'is_banned' => false,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna baru berhasil ditambahkan!');
    }

    public function edit(User $user)
    {
        if ($user->role === 'admin') {
            abort(403, 'Aksi tidak diizinkan.');
        }
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User$user)
    {
        if ($user->role === 'admin') abort(403);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'whatsapp_number' => ['nullable', 'string', 'max:20'],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'whatsapp_number' => $request->whatsapp_number,
        ]);

        if ($request->filled('password')) {$request->validate(['password' => ['required', Rules\Password::defaults()]]);
            $user->update(['password' => Hash::make($request->password)]);
            return redirect()->route('admin.users.index')->with('success', 'Data & Password pengguna berhasil diperbarui!');
        }

        return redirect()->route('admin.users.index')->with('success', 'Data pengguna berhasil diperbarui!');
    }

    public function toggleBan(User $user)
    {
        if ($user->role === 'admin') abort(403);

        $user->update(['is_banned' => !$user->is_banned]);
        
        $message =$user->is_banned ? 'Pengguna berhasil di-banned.' : 'Banned pengguna berhasil dicabut.';
        return redirect()->back()->with('success', $message);
    }

    public function destroy(User $user)
    {
        if ($user->role === 'admin') abort(403);$user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus!');
    }
}
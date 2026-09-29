<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class WaPasswordResetController extends Controller
{
    public function showForm()
    {
        return view('auth.custom-forgot-password');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'whatsapp_number' => 'required|string',
        ]);

        $user = User::where('email',$request->email)
                    ->where('whatsapp_number', $request->whatsapp_number)
                    ->first();

        if (!$user) {
            return back()->with('error', 'Data tidak ditemukan! Pastikan Email dan Nomor WhatsApp sesuai dengan yang pernah Anda daftarkan.');
        }

        $waNumber = env('WHATSAPP_ADMIN_NUMBER', '6281234567890');
        
        $waktuSekarang = \Carbon\Carbon::now('Asia/Jakarta');
        $jam = (int)$waktuSekarang->format('H');
        
        if ($jam >= 4 && $jam < 11) {$waktu = 'pagi'; 
        } elseif ($jam >= 11 && $jam < 15) {$waktu = 'siang'; 
        } elseif ($jam >= 15 && $jam < 18) {$waktu = 'sore'; 
        } else { 
            $waktu = 'malam'; 
        }

        $pesan = "Halo Admin Projekrisk. Selamat {$waktu},\n\nSaya *{$user->name}* (Email: {$user->email}).\nSaya tidak bisa login karena lupa kata sandi akun saya. Mohon bantuannya untuk mereset kata sandi saya.\n\nTerima kasih.";
        
        $waLink = "https://wa.me/" . $waNumber . "?text=" . urlencode($pesan);

        return back()->with([
            'verified_user_name' => $user->name,
            'verified_user_email' => $user->email,
            'wa_link' => $waLink
        ]);
    }
}
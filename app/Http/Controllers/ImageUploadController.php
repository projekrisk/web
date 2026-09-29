<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageUploadController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            
            $filename = time() . '_' . $file->getClientOriginalName();
            
            $path = $file->storeAs('editor', $filename, 'public_uploads');
            
            $url = asset('uploads/' . $path);
            
            return response()->json([
                'url' => $url
            ]);
        }

        return response()->json([
            'error' => [
                'message' => 'Gagal mengupload gambar.'
            ]
        ]);
    }
}
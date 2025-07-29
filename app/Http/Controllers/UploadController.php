<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        // Validate đầu vào
        $request->validate([
            'file' => 'required|file|max:2048'
        ]);

        // Upload lên S3
        Storage::disk('s3')->put(
            'images/test.jpg',
            file_get_contents($request->file('file'))
        );

        return response()->json(['message' => 'Upload thành công']);
    }
}

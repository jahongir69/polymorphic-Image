<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AbstractController extends Controller
{
    public function uploadFile($file, $path = 'uploads')
    {
        return $file->store($path, 'public');
    }

    public function deleteFile($path)
    {
        Storage::disk('public')->delete($path);
    }
}

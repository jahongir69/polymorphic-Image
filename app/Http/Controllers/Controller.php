<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

abstract class Controller
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

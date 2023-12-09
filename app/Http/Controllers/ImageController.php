<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function show($filename)
    {
        $path = 'app/public/customers/' . $filename;
        return response()->file(storage_path($path));
    }
}

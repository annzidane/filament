<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index()
    {
        $barangs = Barang::with('gambar')->get();
        return view('welcome', compact('barangs'));
    }
}

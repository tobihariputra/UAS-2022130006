<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function privacyPolicy()
    {
        return view('pages.privacy-policy'); // Akan mengarah ke view resources/views/privacy-policy.blade.php
    }

    public function panduanPemesanan()
    {
        return view('pages.panduan-pemesanan'); // Akan mengarah ke view resources/views/panduan-pemesanan.blade.php
    }
}

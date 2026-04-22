<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Memanggil file resources/views/pages_admin/beranda.blade.php
        return view('pages_admin.beranda');
    }
}
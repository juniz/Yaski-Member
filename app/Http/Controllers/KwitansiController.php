<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;

class KwitansiController extends Controller
{
    public function index()
    {
        return view('prints.kwitansi.peserta');
    }
}

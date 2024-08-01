<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Workshop;
use App\Models\Province;
use Illuminate\Support\Facades\Crypt;

class PendaftaranManual extends Controller
{
    public function index($id)
    {
        $workshop = Workshop::find(Crypt::decrypt($id));
        $provinces = Province::all();
        return view('pendaftaran.manual', compact('workshop', 'provinces'));
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\App;

class PaklaringController extends Controller
{
    public function cekPic()
    {
        $id = auth()->user()->id;
        $pic = User::find($id)->hasTeams->count();
        if ($pic > 0) {
            return response()->json(['status' => true, 'message' => 'PIC ditemukan']);
        } else {
            return response()->json(['status' => false, 'message' => 'PIC tidak ditemukan, silahkan tambahkan PIC terlebih dahulu']);
        }
    }
}

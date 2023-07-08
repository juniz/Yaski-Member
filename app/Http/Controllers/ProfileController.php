<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Province;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $subUsers = $user->hasTeams;
        $provinces = Province::all();
        return view('profile.index', compact('user', 'subUsers', 'provinces'));
    }

    public function getKabupaten($id)
    {
        $kabupaten = Province::find($id)->regencies;
        return response()->json($kabupaten);
    }
}

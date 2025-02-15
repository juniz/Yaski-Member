<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;

class KwitansiController extends Controller
{
    public function index()
    {
        $imagePath = public_path('assets/images/logo.png');
        $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
        $imageData = file_get_contents($imagePath);
        $template = view('prints.kwitansi.peserta', ['logo' => 'data:image/' . $imageType . ';base64,' . base64_encode($imageData)])->render();
        Browsershot::html($template)
            ->showBackground()
            ->format('A5')
            ->pages('1')
            ->landscape()
            ->save(storage_path('app/public/kwitansi.pdf'));
        return response()->file(storage_path('app/public/kwitansi.pdf'));
        // return view('kwitansi.index');
    }
}

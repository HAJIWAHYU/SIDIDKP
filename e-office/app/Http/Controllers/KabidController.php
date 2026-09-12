<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KabidController extends Controller
{
    public function index()
    {
        $userId = \Illuminate\Support\Facades\Auth::id();

        $totalSuratMasuk = \App\Models\Surat::where('penerima_id', $userId)->count();
        $totalSuratKeluar = \App\Models\Surat::where('pengirim_id', $userId)->count();

        return view('kabid.dashboard', compact('totalSuratMasuk', 'totalSuratKeluar'));
    }
}

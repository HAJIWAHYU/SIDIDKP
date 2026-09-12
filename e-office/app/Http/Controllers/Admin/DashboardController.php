<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Bidang;
use App\Models\Surat;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role == 'admin') {
            $totalUser = User::count();
            $totalBidang = Bidang::count();
            return view('admin.dashboard', compact('totalUser', 'totalBidang'));
        }

        if ($user->role == 'kabid' || $user->role == 'kasi') {
            return redirect()->route('kabid.dashboard');
        }

        if ($user->role == 'staff') {
            $totalSuratMasuk = Surat::where('penerima_id', $user->id)->count();
            $suratMasukBelumDibaca = Surat::where('penerima_id', $user->id)->where('is_read', false)->count();
            $recentSurats = Surat::where('penerima_id', $user->id)->with('pengirim.bidang')->latest()->take(5)->get();
            return view('dashboard.staff', compact('totalSuratMasuk', 'suratMasukBelumDibaca', 'recentSurats'));
        }

        return view('dashboard.staff');
    }
}

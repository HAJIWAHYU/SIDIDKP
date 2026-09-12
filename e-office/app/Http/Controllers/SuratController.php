<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Mail\SuratMasukNotification;
use Illuminate\Support\Facades\Mail;

class SuratController extends Controller
{
    /**
     * Display a listing of letters (incoming and outgoing).
     */
    public function index(Request $request)
    {
        $userId = Auth::id();
        $search = $request->input('search');

        // Ambil surat masuk (surat yang dikirim ke user ini) - 10 per halaman
        $incomingLetters = Surat::where('penerima_id', $userId)
            ->with('pengirim.bidang')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('perihal', 'like', '%' . $search . '%')
                      ->orWhereHas('pengirim', function ($qg) use ($search) {
                          $qg->where('name', 'like', '%' . $search . '%')
                             ->orWhereHas('bidang', function ($qb) use ($search) {
                                 $qb->where('nama_bidang', 'like', '%' . $search . '%');
                             });
                      });
                });
            })
            ->latest()
            ->paginate(10, ['*'], 'incoming')
            ->withQueryString();

        // Ambil surat keluar (surat yang dikirim oleh user ini) - 10 per halaman
        $outgoingLetters = Surat::where('pengirim_id', $userId)
            ->with('penerima.bidang')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('perihal', 'like', '%' . $search . '%')
                      ->orWhereHas('penerima', function ($qp) use ($search) {
                          $qp->where('name', 'like', '%' . $search . '%')
                             ->orWhereHas('bidang', function ($qb) use ($search) {
                                 $qb->where('nama_bidang', 'like', '%' . $search . '%');
                             });
                      });
                });
            })
            ->latest()
            ->paginate(10, ['*'], 'outgoing')
            ->withQueryString();

        return view('surat.index', compact('incomingLetters', 'outgoingLetters'));
    }

    public function create()
    {
        if (Auth::user()->role === 'staff') {
            abort(403, 'Staff tidak memiliki akses untuk menulis/mengirim surat.');
        }

        $userRole = Auth::user()->role;
        if ($userRole === 'kabid') {
            $recipientsQuery = User::whereIn('role', ['kabid', 'kasi', 'staff']);
        } elseif ($userRole === 'kasi') {
            $recipientsQuery = User::whereIn('role', ['staff']);
        } else {
            $recipientsQuery = User::whereIn('role', ['kabid', 'kasi', 'staff']);
        }

        $recipients = $recipientsQuery->where('id', '!=', Auth::id())
            ->with('bidang')
            ->get()
            ->sortBy(function($user) {
                return $user->bidang->nama_bidang ?? 'Tanpa Bidang';
            });

        $bidangs = \App\Models\Bidang::all();

        return view('surat.create', compact('recipients', 'bidangs'));
    }

    /**
     * Store a newly created letter in storage.
     */
    public function store(Request $request)
    {
        if (Auth::user()->role === 'staff') {
            abort(403, 'Staff tidak memiliki akses untuk menulis/mengirim surat.');
        }

        $request->validate([
            'penerima_id' => 'required|exists:users,id',
            'nomor_surat' => 'nullable|string|max:255',
            'perihal' => 'required|string|max:255',
            'isi' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240', // max 10MB
            'surat_dari' => 'nullable|string|max:255',
            'tanggal_surat' => 'required|date',
            'no_agenda' => 'nullable|string|max:255',
            'sifat' => 'nullable|string|max:255',
        ]);

        if (Auth::user()->role === 'kasi') {
            $penerima = User::find($request->penerima_id);
            if (!$penerima || $penerima->role !== 'staff') {
                return back()->withErrors(['penerima_id' => 'KASI hanya dapat mengirim disposisi kepada Staff.'])->withInput();
            }
        }

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('surat_attachments', 'public');
        }

        $perihal = $request->perihal;
        if ($request->filled('nomor_surat')) {
            $perihal = '[' . $request->nomor_surat . '] ' . $perihal;
        }

        $surat = Surat::create([
            'pengirim_id' => Auth::id(),
            'penerima_id' => $request->penerima_id,
            'perihal' => $perihal,
            'isi' => $request->isi,
            'file' => $filePath,
            'is_read' => false,
            'surat_dari' => $request->surat_dari,
            'tanggal_surat' => $request->tanggal_surat,
            'no_agenda' => $request->no_agenda,
            'sifat' => $request->sifat,
        ]);

        // Load relations needed for email template
        $surat->load(['pengirim.bidang', 'penerima']);

        // Send email notification
        try {
            Mail::to($surat->penerima->email)->send(new SuratMasukNotification($surat));
        } catch (\Exception $e) {
            // Log warning but don't crash if SMTP is misconfigured or fails
            \Illuminate\Support\Facades\Log::warning('Gagal mengirim email notifikasi: ' . $e->getMessage());
        }

        return redirect()->route('surat.index')->with('success', 'Surat berhasil dikirim.');
    }

    /**
     * Display the specified letter and update read status if the viewer is the recipient.
     */
    public function show($id)
    {
        $surat = Surat::with(['pengirim.bidang', 'penerima.bidang'])->findOrFail($id);

        // Keamanan: pastikan pengirim atau penerima yang bisa melihat surat
        if (Auth::id() !== $surat->pengirim_id && Auth::id() !== $surat->penerima_id) {
            abort(403, 'Anda tidak memiliki hak untuk melihat surat ini.');
        }

        // Jika pembaca adalah penerima surat dan statusnya belum dibaca, ubah jadi sudah dibaca
        if (Auth::id() === $surat->penerima_id && !$surat->is_read) {
            $surat->update(['is_read' => true]);
        }

        return view('surat.show', compact('surat'));
    }

    /**
     * Remove the specified letter from storage.
     */
    public function destroy($id)
    {
        $surat = Surat::findOrFail($id);

        // Hanya pengirim surat atau Admin yang dapat menghapus surat keluar
        if (Auth::user()->role !== 'admin' && (int) Auth::id() !== (int) $surat->pengirim_id) {
            abort(403, 'Anda tidak memiliki hak untuk menghapus surat ini.');
        }

        // Hapus file lampiran jika ada
        if ($surat->file) {
            Storage::disk('public')->delete($surat->file);
        }

        $surat->delete();

        return redirect()->route('surat.index')->with('success', 'Surat berhasil dihapus.');
    }

    /**
     * Download the attachment file of the specified letter.
     */
    public function download($id)
    {
        $surat = Surat::findOrFail($id);

        // Security check: ensure user is sender or recipient
        if (Auth::id() !== $surat->pengirim_id && Auth::id() !== $surat->penerima_id) {
            abort(403, 'Anda tidak memiliki hak untuk mengunduh surat ini.');
        }

        if (!$surat->file || !Storage::disk('public')->exists($surat->file)) {
            abort(404, 'Berkas tidak ditemukan.');
        }

        $filePath = Storage::disk('public')->path($surat->file);
        $cleanPerihal = \Illuminate\Support\Str::slug(preg_replace('/^\[.*?\]\s*/', '', $surat->perihal));
        $extension = pathinfo($surat->file, PATHINFO_EXTENSION) ?: 'pdf';
        $downloadFileName = 'Surat_' . ($cleanPerihal ?: 'lampiran') . '.' . $extension;

        return response()->download($filePath, $downloadFileName);
    }
}

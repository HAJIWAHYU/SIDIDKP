<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bidang;

class BidangController extends Controller
{
    public function index()
    {
        $bidangs = Bidang::all();
        return view('bidang.index', compact('bidangs'));
    }

    public function create()
    {
        return view('bidang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_bidang' => 'required'
        ]);

        Bidang::create($request->all());

        return redirect()->route('bidang.index')->with('success','Data berhasil ditambah');
    }

    public function edit($id)
    {
        $bidang = Bidang::findOrFail($id);
        return view('bidang.edit', compact('bidang'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_bidang' => 'required'
        ]);

        $bidang = Bidang::findOrFail($id);
        $bidang->update($request->all());

        return redirect()->route('bidang.index')->with('success','Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $bidang = Bidang::findOrFail($id);
        $bidang->delete();

        return redirect()->route('bidang.index')->with('success','Data berhasil dihapus');
    }
}

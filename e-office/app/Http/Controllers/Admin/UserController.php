<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Bidang;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::with('bidang')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%')
                      ->orWhere('role', 'like', '%' . $search . '%')
                      ->orWhereHas('bidang', function ($qb) use ($search) {
                          $qb->where('nama_bidang', 'like', '%' . $search . '%');
                      });
                });
            })
            ->orderByRaw("CASE 
                WHEN role = 'admin' THEN 1 
                WHEN role = 'kabid' THEN 2 
                WHEN role = 'kasi' THEN 3
                WHEN role = 'staff' THEN 4 
                ELSE 5 
            END ASC")
            ->orderBy('name', 'asc')
            ->paginate(10)
            ->withQueryString(); // Keep search query in pagination links

        return view('user.index', compact('users'));
    }

public function create()
{
    $bidangs = Bidang::all();
    return view('user.create', compact('bidangs'));
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
        'role' => 'required|in:admin,kabid,kasi,staff',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
        'bidang_id' => $request->bidang_id,
    ]);

    return redirect()->route('user.index')->with('success','User berhasil ditambah');
}

public function edit($id)
{
    $user = User::findOrFail($id);
    $bidangs = Bidang::all();

    return view('user.edit', compact('user','bidangs'));
}

public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email,' . $id,
        'password' => 'nullable|min:6|confirmed',
        'role' => 'required|in:admin,kabid,kasi,staff',
    ]);

    $data = [
        'name' => $request->name,
        'email' => $request->email,
        'role' => $request->role,
        'bidang_id' => $request->bidang_id,
    ];

    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }

    $user->update($data);

    return redirect()->route('user.index')->with('success','User berhasil diupdate');
}

public function destroy($id)
{
    User::findOrFail($id)->delete();

    return redirect()->route('user.index')->with('success','User berhasil dihapus');
}
}

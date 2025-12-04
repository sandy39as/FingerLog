<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use Illuminate\Http\Request;

class DepartemenController extends Controller
{
    public function index()
    {
        $departemen = Departemen::orderBy('nama')->get();

        return view('departemen.index', compact('departemen'));
    }

    public function create()
    {
        return view('departemen.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'kode' => 'nullable|string|max:20',
        ]);

        Departemen::create([
            'nama' => $request->nama,
            'kode' => $request->kode,
        ]);

        return redirect()->route('departemen.index')
            ->with('success', 'Departemen berhasil ditambahkan.');
    }

    public function edit(Departemen $departemen)
    {
        return view('departemen.edit', compact('departemen'));
    }

    public function update(Request $request, Departemen $departemen)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'kode' => 'nullable|string|max:20',
        ]);

        $departemen->update([
            'nama' => $request->nama,
            'kode' => $request->kode,
        ]);

        return redirect()->route('departemen.index')
            ->with('success', 'Departemen berhasil diperbarui.');
    }

    public function destroy(Departemen $departemen)
    {
        $departemen->delete();

        return redirect()->route('departemen.index')
            ->with('success', 'Departemen berhasil dihapus.');
    }
}

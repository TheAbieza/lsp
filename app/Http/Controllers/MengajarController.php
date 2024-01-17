<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Mengajar;

class MengajarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('mengajar.index', [
            'mengajar' => Mengajar::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mengajar.create', [
            'guru' => Guru::all(),
            'mapel' => Mapel::all(),
            'kelas' => Kelas::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data_mengajar = $request->validate([
            'guru_id' => ['required'],
            'mapel_id' => ['required'],
            'kelas_id' => ['required']
        ]);

        $mengajar = Mengajar::firstOrNew($data_mengajar);
        
        if ($mengajar->exists) {
            return back()->with('error', 'data mengajar yang ditambah sudah ada');
        } else {
            $mengajar->save();
            return redirect('/mengajar/index')->with('success', 'data mengajar berhasil ditambah');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mengajar $mengajar)
    {
        return view ('mengajar.edit', [
            'mengajar' => $mengajar,
            'guru' => Guru::all(),
            'mapel' => Mapel::all(),
            'kelas' => Kelas::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mengajar $mengajar)
    {
        $data_mengajar = $request->validate([
            'guru_id' => ['required'],
            'mapel_id' => ['required'],
            'kelas_id' => ['required']
        ]);

        if ($request->mapel_id != $mengajar->mapel_id || $request->kelas_id != $mengajar->kelas_id) {
            $cek_mengajar = Mengajar::where('mapel_id', $request->mapel_id)->where('kelas_id', $request->kelas_id)->first();
        
            if ($cek_mengajar) {
                return back()->with('error', 'data kelas yang di tambah sudah ada');
            }
        } 
        $mengajar->update($data_mengajar);
        return redirect('/mengajar/index')->with('success', 'data mengajar berhasil di ubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mengajar ->delete();
        return back()->with('success', 'data mengajar berhasil di tambah'); 
    }
}

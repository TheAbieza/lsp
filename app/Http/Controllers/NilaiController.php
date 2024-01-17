<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\Mengajar;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class NilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (session('role') == 'guru') {
            $kelasIds = Mengajar::where('guru_id', session('id'))->pluck('kelas_id')->toArray();
            $kelas = Kelas::whereIn('id', $kelasIds)->get();

            return view('nilai.menu', [
                'kelas' => $kelas
            ]);
        } else {
            $nilai = Nilai::where('siswa_id', session('id'))->get();
            return view ('nilai.index', [
                'nilai' => $nilai
            ]);
        }
    }

    public function kelas(Kelas $kelas) {
        $idGuru = session('id');
        $idKelas = $kelas->id;

        $dataNilai = Nilai::whereHas('mengajar', function ($query) use ($idGuru, $idKelas) {
            $query->where('guru_id', $idGuru)->where('kelas_id', $idKelas);
        })->get();

        return view('nilai.index', [
            'nilai' => $dataNilai,
            'idKelas' => $idKelas
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Kelas $kelas)
    {
        $mengajar = Mengajar::where('guru_id', session('id'))->where('kelas_id', $kelas->id);
        return view('nilai.create', [
            'mengajar' => $mengajar->get(),
            'siswa' => Siswa::where('kelas_id', $kelas->id)->get(),
            'idKelas' => $kelas->id
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Kelas $kelas)
    {
        $data_nilai = $request->validate([
            'mengajar_id' => ['required'],
            'siswa_id' => ['required'],
            'uh' => ['required'],
            'uts' => ['required'],
            'uas' => ['required']
        ]);

        $data_nilai['na'] = round(($request->uh + $request->uts + $request->uas) / 3);

        $cek_nilai = Nilai::where('mengajar_id', $request->mengajar_id)->where('siswa_id', $request->siswa_id)->first();

        if ($cek_nilai){
            return back()->with('error', 'data nilai yang ditambah sudah ada');
        } else {
            Nilai::Create($data_nilai);
            return redirect("/nilai/kelas/$kelas->id")->with('success', 'data nilai berhasil di tambah');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kelas $kelas, Nilai $nilai)
    {
        $mengajar = Mengajar::where('guru_id', session('id'))->where('kelas_id', $kelas->id);
        return view ('nilai.edit', [
            'nilai' => $nilai,
            'mengajar' => $mengajar->get(),
            'siswa' => Siswa::where('kelas_id', $kelas->id)->get(),
            'idKelas' => $kelas->id
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kelas $kelas, Nilai $nilai)
    {
        $data_nilai = $request->validate([
            'mengajar_id' => ['required'],
            'siswa_id' => ['required'],
            'uh' => ['required', 'numeric'],    
            'uts' => ['required', 'numeric'],
            'uas' => ['required', 'numeric']
        ]);

        $data_nilai['na'] = round(($request->uh + $request->uts + $request->uas) / 3);

        if ($request->mengajar_id != $nilai->mengajar_id || $request->siswa_id != $nilai->siswa_id) {
            $cek_nilai = Nilai::where('mengajar_id', $request->mengajar_id)->where('siswa_id', $request->siswa_id)->first();
            if ($cek_nilai) {
                return back()->with('error', 'data nilai yang ditambah sudah ada');
            }
        } else {
            $nilai->update($data_nilai);
            return redirect("/nilai/kelas/$kelas->id")->with('success', 'data nilai berhasil di ubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Nilai $nilai)
    {
        $nilai->detele();
        return back()->with('success', 'data nilai berhasil di hapus');
    }
}

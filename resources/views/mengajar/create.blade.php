@extends('layout.main')
@section('content')
    <div class="container-form">
        <h2 align="center">Tambah Data Mengajar</h2>

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <p class="alert">{{ $error }}</p>
            @endforeach
        @endif

        <form action="/mengajar/store" method="POST">
            @csrf
            <label for="guru_id">Guru</label>
            <select name="guru_id" id="guru_id">
                <option></option>
                @foreach ($guru as $g)
                    <option value="{{ $g->id }}">{{ $g->nama_guru }}</option>
                @endforeach
            </select>

            <label for="mapel_id">Mata Pelajaran</label>
            <select name="mapel_id" id="mapel_id">
                <option></option>
                @foreach ($mapel as $m)
                    <option value="{{ $m->id }}">{{ $m->nama_mapel }}</option>
                @endforeach
            </select>

            <label for="kelas_id">Kelas</label>
            <select name="kelas_id" id="kelas_id">
                <option></option>
                @foreach ($kelas as $k)
                    <option value="{{ $k->id }}">{{ $k->kelas }} {{ $k->jurusan }} {{ $k->rombel }}</option>
                @endforeach
            </select>

            <button class="button-submit" type="submit" name="button">SIMPAN</button>
        </form>
    </div>
@endsection
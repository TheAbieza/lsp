@extends('layout.main')
@section('content')
    <div class="container-form">
        <h2>Edit Data Mapel</h2>

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <p class="text-danger">{{ $error }}</p>
            @endforeach
        @endif

        <form action="/mapel/update/{{ $mapel->id }}" method="POST">
            @csrf
            <label for="nama_mapel">Mata Pelajaran</label>
            <input type="text" name="nama_mapel" id="nama_mapel" value="{{ $mapel->nama_mapel }}">
            <button class="button-submit" type="submit">Ubah</button>
        </form>
    </div>
@endsection
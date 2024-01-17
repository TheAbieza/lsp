@extends('layout.main')
@section('content')
    <div class="content-menu">
        @forelse ($kelas as $k)
            <div class="menu-kelas">
                <div class="kelas-list">
                    <a href="/nilai/kelas/{{ $k->id }}">{{ $k->nama_kelas }} {{ $k->nama_jurusan }} {{ $k->rombel }}</a>
                </div>
            </div>
        @empty
            <div class="menu-kelas">
                <div class="kelas-list">
                    anda belum mendapatkan kelas dan mapel
                </div>
            </div>
        @endforelse
    </div>
@endsection
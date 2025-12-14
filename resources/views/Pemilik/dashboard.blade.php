@extends('layouts.app')
@section('title', 'Beranda Pemilik')
@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8">
            <h2 class="fw-bold mb-4">Halo, {{ Auth::user()->nama }}! 👋</h2>
            
            {{-- STATUS ANTRIAN (Hanya muncul jika sedang daftar) --}}
            @if($antrianAktif)
            <div class="card border-0 shadow-sm bg-primary text-white mb-4 overflow-hidden position-relative">
                <div class="card-body p-4 position-relative" style="z-index: 2;">
                    <div class="d-flex align-items-center mb-3">
                        <div class="spinner-grow text-light me-2" role="status" style="width: 1rem; height: 1rem;"></div>
                        <h5 class="mb-0 fw-bold">Sedang Dalam Antrian</h5>
                    </div>
                    
                    <div class="row align-items-end">
                        <div class="col-8">
                            <p class="mb-0 opacity-75">Pasien</p>
                            <h3 class="fw-bold">{{ $antrianAktif->pet->nama }}</h3>
                            <p class="mb-0 mt-2">
                                <i class="bi bi-person-user me-1"></i> Dokter Tujuan: <br> 
                                <strong>Dr. {{ $antrianAktif->dokter->user->nama ?? '-' }}</strong>
                            </p>
                        </div>
                        <div class="col-4 text-end">
                            <p class="mb-0 opacity-75">No. Urut</p>
                            <h1 class="display-1 fw-bold mb-0">{{ $antrianAktif->no_urut }}</h1>
                        </div>
                    </div>
                </div>
                {{-- Dekorasi background --}}
                <i class="bi bi-clipboard-pulse position-absolute text-white opacity-25" style="font-size: 10rem; right: -20px; bottom: -40px;"></i>
            </div>
            @else
            <div class="card border-0 shadow-sm bg-light mb-4">
                <div class="card-body p-4 text-center text-muted">
                    <i class="bi bi-emoji-smile fs-1 mb-2"></i>
                    <p class="mb-0">Tidak ada jadwal pemeriksaan hari ini.</p>
                </div>
            </div>
            @endif
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center d-flex flex-column justify-content-center">
                    <div class="bg-success bg-opacity-10 p-3 rounded-circle d-inline-block mx-auto mb-3 text-success">
                        <i class="bi bi-github fs-1"></i>
                    </div>
                    <h1 class="fw-bold">{{ $totalHewan }}</h1>
                    <p class="text-muted">Hewan Peliharaan Terdaftar</p>
                    <a href="{{ route('Pemilik.Hewan.index') }}" class="btn btn-outline-success rounded-pill mt-2">Lihat Semua</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
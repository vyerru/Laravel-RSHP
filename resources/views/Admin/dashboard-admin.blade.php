@extends('layouts.app') {{-- opsional, kalau kamu pakai layout global --}}

@section('content')
<div class="dashboard-container">
    <div class="welcome-section mb-4">
        <h2>Selamat Datang, {{ $user->nama }}</h2>
        <p class="text-light mb-0">Administrator Dashboard RSHP Unair</p>
    </div>

    <div class="quick-actions">
        <h4 class="mb-4">Menu Utama</h4>
        <div class="row g-4">
            <div class="col-md-4">
                <a href="{{ route('admin/data-master') }}" class="menu-card">
                    <div class="card h-100 text-center">
                        <i class="bi bi-folder-fill mb-3"></i>
                        <h5 class="card-title">Data Master</h5>
                        <p class="card-text">Kelola data jenis dan ras hewan</p>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="#" class="menu-card">
                    <div class="card h-100 text-center">
                        <i class="bi bi-person-fill mb-3"></i>
                        <h5 class="card-title">Data Pasien</h5>
                        <p class="card-text">Kelola data pasien dan pemilik</p>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="#" class="menu-card">
                    <div class="card h-100 text-center">
                        <i class="bi bi-file-earmark-text-fill mb-3"></i>
                        <h5 class="card-title">Laporan</h5>
                        <p class="card-text">Lihat dan cetak laporan</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Dashboard Dokter')

@section('content')
<div class="container py-4">
    
    {{-- Section Welcome --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white shadow border-0 rounded-3">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h2 class="fw-bold mb-1">Halo, Dr. {{ Auth::user()->nama }}!</h2>
                        <p class="mb-0 opacity-75">Selamat bertugas. Ada <strong class="text-warning">{{ $stats['pasien_hari_ini'] }} pasien</strong> menunggu pemeriksaan hari ini.</p>
                    </div>
                    <div class="d-none d-md-block">
                        <i class="bi bi-heart-pulse-fill" style="font-size: 3rem; opacity: 0.8;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Section Statistik Ringkas --}}
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 rounded-3 border-start border-4 border-info">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-info bg-opacity-10 p-3 rounded-circle text-info">
                            <i class="bi bi-people-fill fs-4"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-muted mb-0 small text-uppercase fw-bold">Pasien Hari Ini</h6>
                            <h3 class="fw-bold mb-0">{{ $stats['pasien_hari_ini'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 rounded-3 border-start border-4 border-success">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-success bg-opacity-10 p-3 rounded-circle text-success">
                            <i class="bi bi-journal-medical fs-4"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-muted mb-0 small text-uppercase fw-bold">Total Rekam Medis</h6>
                            <h3 class="fw-bold mb-0">{{ $stats['total_rekam_medis'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 rounded-3 border-start border-4 border-warning">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-warning bg-opacity-10 p-3 rounded-circle text-warning">
                            <i class="bi bi-calendar-check-fill fs-4"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-muted mb-0 small text-uppercase fw-bold">Jadwal Aktif</h6>
                            <h3 class="fw-bold mb-0">{{ $stats['jadwal_aktif'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Section Jadwal & Shortcut --}}
    <div class="row g-4">
        
        {{-- Tabel Antrian Pasien --}}
        <div class="col-lg-8">
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-white py-3 border-bottom-0">
            <h5 class="card-title fw-bold mb-0 text-primary">
                <i class="bi bi-clock-history me-2"></i>Antrian Pemeriksaan Hari Ini
            </h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Jam</th> {{-- Bisa juga No. Urut --}}
                        <th>Pasien (Hewan)</th>
                        <th>Pemilik</th>
                        <th>Ras / Jenis</th> {{-- Ganti Keluhan jadi Ras --}}
                        <th>Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pasienHariIni as $pasien)
                    <tr>
                        {{-- Jam Kedatangan --}}
                        <td class="ps-4 fw-bold text-muted">
                            {{ \Carbon\Carbon::parse($pasien->waktu_daftar)->format('H:i') }}
                            <br>
                            <span class="badge bg-light text-secondary border">No. {{ $pasien->no_urut }}</span>
                        </td>
                        
                        {{-- Nama Hewan --}}
                        <td>
                            <span class="fw-bold text-dark">{{ $pasien->pet->nama ?? '-' }}</span>
                        </td>
                        
                        {{-- Nama Pemilik --}}
                        <td>{{ $pasien->pet->pemilik->user->nama ?? 'Tanpa Pemilik' }}</td>
                        
                        {{-- Ras Hewan (Pengganti Keluhan) --}}
                        <td>
                            <small class="text-muted">
                                {{ $pasien->pet->rasHewan->nama_ras ?? '-' }}
                            </small>
                        </td>
                        
                        {{-- Status --}}
                        <td>
                            @if($pasien->status == '0')
                                <span class="badge bg-warning text-dark">Menunggu</span>
                            @elseif($pasien->status == '1')
                                <span class="badge bg-info text-dark">Sedang Diperiksa</span>
                            @elseif($pasien->status == '2')
                                <span class="badge bg-success">Selesai</span>
                            @else
                                <span class="badge bg-danger">Batal</span>
                            @endif
                        </td>
                        
                        {{-- Tombol Aksi --}}
                        <td class="text-end pe-4">
                            @if($pasien->status == '0' || $pasien->status == '1')
                                {{-- Tombol ini nanti mengarah ke form input rekam medis --}}
                                <a href="{{ route('Dokter.RekamMedis.edit') }}" class="btn btn-sm btn-primary rounded-pill px-3">
                                    Periksa <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            @else
                                <button class="btn btn-sm btn-secondary rounded-pill px-3" disabled>
                                    <i class="bi bi-check-lg"></i> Done
                                </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-calendar-x fs-1 d-block mb-2 opacity-50"></i>
                            Belum ada jadwal pasien hari ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white text-center py-3 border-top-0">
            <a href="{{ route('Dokter.Pasien.index') }}" class="text-decoration-none fw-bold small">Lihat Semua Riwayat Pasien</a>
        </div>
    </div>
</div>

        {{-- Shortcut Menu --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h5 class="card-title fw-bold mb-0">Aksi Cepat</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        {{-- <a href="{{ route('Dokter.RekamMedis.index') }}" class="btn btn-outline-primary py-3 text-start shadow-sm border-2"></a>- --}}
                            <div class="d-flex align-items-center">
                                <div class="bg-primary text-white rounded-circle p-2 me-3">
                                    <i class="bi bi-plus-lg"></i>
                                </div>
                                <div>
                                    <span class="fw-bold d-block">Buat Rekam Medis Baru</span>
                                    <small class="text-muted">Input hasil pemeriksaan pasien</small>
                                </div>
                            </div>
                        </a>

                        {{-- -<a href="{{ route('Dokter.Pasien.index') }}" class="btn btn-outline-success py-3 text-start shadow-sm border-2"></a> --}}
                            <div class="d-flex align-items-center">
                                <div class="bg-success text-white rounded-circle p-2 me-3">
                                    <i class="bi bi-search"></i>
                                </div>
                                <div>
                                    <span class="fw-bold d-block">Cari Riwayat Pasien</span>
                                    <small class="text-muted">Lihat histori penyakit hewan</small>
                                </div>
                            </div>
                        </a>
                        
                        {{-- <a href="{{ route('Dokter.Profil.index') }}" class="btn btn-outline-secondary py-3 text-start shadow-sm border-2"></a>- --}}
                            <div class="d-flex align-items-center">
                                <div class="bg-secondary text-white rounded-circle p-2 me-3">
                                    <i class="bi bi-person-gear"></i>
                                </div>
                                <div>
                                    <span class="fw-bold d-block">Update Profil & Jadwal</span>
                                    <small class="text-muted">Atur ketersediaan praktek</small>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
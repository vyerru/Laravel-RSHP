@extends('layouts.app')

@section('title', 'Detail Pasien - ' . $pet->nama)

@section('content')
<div class="container py-4">
    {{-- Tombol Kembali --}}
    <div class="mb-4">
        <a href="{{ route('Dokter.Pasien.index') }}" class="text-decoration-none text-muted">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Pasien
        </a>
    </div>

    <div class="row g-4">
        
        {{-- KOLOM KIRI: INFO PASIEN & PEMILIK --}}
        <div class="col-lg-4">
            {{-- Card Profil Hewan --}}
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-body text-center p-4">
                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-4 mb-3 text-primary">
                        <i class="bi bi-github" style="font-size: 4rem;"></i>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $pet->nama }}</h3>
                    <p class="text-muted mb-3">{{ $pet->rasHewan->nama_ras ?? '-' }}</p>
                    
                    <div class="d-flex justify-content-center gap-2 mb-4">
                        @if($pet->jenis_kelamin == 'Jantan')
                            <span class="badge bg-primary"><i class="bi bi-gender-male"></i> Jantan</span>
                        @else
                            <span class="badge bg-danger"><i class="bi bi-gender-female"></i> Betina</span>
                        @endif
                        <span class="badge bg-secondary">{{ \Carbon\Carbon::parse($pet->tanggal_lahir)->age }} Tahun</span>
                    </div>

                    <hr class="my-3">

                    <div class="text-start">
                        <small class="text-muted text-uppercase fw-bold d-block mb-2">Detail Fisik</small>
                        <ul class="list-unstyled small mb-0">
                            <li class="mb-2 d-flex justify-content-between">
                                <span>Warna / Tanda:</span>
                                <span class="fw-bold">{{ $pet->warna_tanda ?? '-' }}</span>
                            </li>
                            <li class="mb-2 d-flex justify-content-between">
                                <span>Tanggal Lahir:</span>
                                <span class="fw-bold">{{ \Carbon\Carbon::parse($pet->tanggal_lahir)->format('d M Y') }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Card Info Pemilik --}}
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3">
                    <h6 class="card-title fw-bold mb-0"><i class="bi bi-person me-2"></i>Informasi Pemilik</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-secondary bg-opacity-10 p-2 rounded-circle me-3">
                            <i class="bi bi-person-fill fs-5 text-secondary"></i>
                        </div>
                        <div>
                            <span class="d-block fw-bold">{{ $pet->pemilik->user->nama ?? '-' }}</span>
                            <small class="text-muted">ID Pemilik: #{{ $pet->idpemilik }}</small>
                        </div>
                    </div>
                    
                    <ul class="list-group list-group-flush small">
                        <li class="list-group-item px-0 d-flex align-items-center">
                            <i class="bi bi-whatsapp text-success me-3"></i>
                            {{ $pet->pemilik->no_wa ?? '-' }}
                        </li>
                        <li class="list-group-item px-0 d-flex align-items-center">
                            <i class="bi bi-geo-alt text-danger me-3"></i>
                            {{ $pet->pemilik->alamat ?? '-' }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: RIWAYAT MEDIS (TIMELINE) --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title fw-bold mb-0 text-primary">
                        <i class="bi bi-journal-medical me-2"></i>Riwayat Rekam Medis
                    </h5>
                    {{-- Tombol ini nanti mengarah ke Create Rekam Medis dengan pre-filled ID Pet --}}
                    {{-- <a href="#" class="btn btn-sm btn-primary">+ Periksa Sekarang</a> --}}
                </div>
                <div class="card-body bg-light">
                    
                    @forelse($pet->rekamMedis as $rm)
                        <div class="card border-0 shadow-sm mb-3">
                            <div class="card-body position-relative">
                                {{-- Tanggal di pojok kanan atas --}}
                                <div class="position-absolute top-0 end-0 mt-3 me-3 text-end">
                                    <small class="text-muted d-block fw-bold">{{ $rm->created_at->format('d M Y') }}</small>
                                    <small class="text-muted">{{ $rm->created_at->format('H:i') }} WIB</small>
                                </div>

                                <h6 class="fw-bold text-primary mb-1">
                                    Kunjungan #{{ $loop->iteration }}
                                </h6>
                                <p class="small text-muted mb-3">
                                    Diperiksa oleh: <span class="fw-bold text-dark">Dr. {{ $rm->dokter->user->nama ?? '-' }}</span>
                                </p>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="p-3 bg-warning bg-opacity-10 rounded-3 h-100">
                                            <small class="text-muted text-uppercase fw-bold d-block mb-1">Anamnesa (Keluhan)</small>
                                            <p class="mb-0 small text-dark">{{ $rm->anamnesa }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-3 bg-info bg-opacity-10 rounded-3 h-100">
                                            <small class="text-muted text-uppercase fw-bold d-block mb-1">Diagnosa</small>
                                            <p class="mb-0 fw-bold text-dark">{{ $rm->diagnosa }}</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Jika ada temuan klinis --}}
                                @if($rm->temuan_klinis)
                                <div class="mt-3">
                                    <small class="text-muted text-uppercase fw-bold d-block mb-1">Temuan Klinis</small>
                                    <p class="mb-0 small border-start border-3 border-secondary ps-3 text-muted">
                                        {{ $rm->temuan_klinis }}
                                    </p>
                                </div>
                                @endif
                                
                                {{-- Tombol Detail Tindakan (Nanti diarahkan ke fitur Detail Rekam Medis) --}}
                                <div class="mt-3 text-end">
                                    <a href="{{ route('Dokter.Pemeriksaan.edit', $rm->idreservasi_dokter) }}"></a><button class="btn btn-sm btn-outline-secondary">Lihat Resep & Tindakan</button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="bi bi-journal-x text-muted" style="font-size: 3rem;"></i>
                            </div>
                            <h6 class="fw-bold text-muted">Belum ada riwayat medis</h6>
                            <p class="small text-muted">Pasien ini belum pernah diperiksa sebelumnya.</p>
                        </div>
                    @endforelse

                </div>
            </div>
        </div>

    </div>
</div>
@endsection
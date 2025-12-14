@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="container py-4">
    <div class="row g-4 justify-content-center">
        
        {{-- KOLOM KIRI: KARTU IDENTITAS --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                <div class="card-body p-0 text-center">
                    {{-- Background Header --}}
                    <div class="bg-primary pt-5 pb-5 text-white" style="background: linear-gradient(180deg, #0d6efd 0%, #6610f2 100%);">
                        <div class="mb-3">
                            <div class="bg-white p-1 rounded-circle d-inline-block">
                                {{-- Avatar Otomatis --}}
                                <img src="https://ui-avatars.com/api/?name={{ $user->nama }}&background=random&size=128&bold=true" 
                                     class="rounded-circle" alt="Profile">
                            </div>
                        </div>
                        <h4 class="fw-bold mb-1">{{ $user->nama }}</h4>
                        <p class="mb-2 opacity-75">{{ $dokter->bidang_dokter }}</p>
                        <span class="badge bg-white text-primary rounded-pill px-3">
                            ID: #{{ $user->iduser }}
                        </span>
                    </div>

                    {{-- Statistik Mini --}}
                    <div class="row g-0 border-top">
                        <div class="col-6 border-end p-3">
                            <h4 class="fw-bold mb-0 text-primary">{{ $totalPasien }}</h4>
                            <small class="text-muted text-uppercase" style="font-size: 0.7rem;">Total Pasien</small>
                        </div>
                        <div class="col-6 p-3">
                            <h4 class="fw-bold mb-0 text-success">{{ $pasienHariIni }}</h4>
                            <small class="text-muted text-uppercase" style="font-size: 0.7rem;">Pasien Hari Ini</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: DETAIL INFORMASI --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h5 class="fw-bold text-dark mb-0"><i class="bi bi-person-lines-fill me-2 text-primary"></i>Informasi Pribadi</h5>
                </div>
                <div class="card-body p-4">
                    
                    <div class="row g-4">
                        {{-- Email --}}
                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 bg-light rounded-3 h-100">
                                <div class="fs-3 text-primary me-3"><i class="bi bi-envelope"></i></div>
                                <div>
                                    <small class="text-muted d-block fw-bold text-uppercase">Email</small>
                                    <span class="fw-bold text-dark">{{ $user->email }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- No HP --}}
                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 bg-light rounded-3 h-100">
                                <div class="fs-3 text-success me-3"><i class="bi bi-whatsapp"></i></div>
                                <div>
                                    <small class="text-muted d-block fw-bold text-uppercase">No. Telepon / WA</small>
                                    <span class="fw-bold text-dark">{{ $dokter->no_hp }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Jenis Kelamin --}}
                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 bg-light rounded-3 h-100">
                                <div class="fs-3 text-info me-3"><i class="bi bi-gender-ambiguous"></i></div>
                                <div>
                                    <small class="text-muted d-block fw-bold text-uppercase">Jenis Kelamin</small>
                                    <span class="fw-bold text-dark">
                                        {{ $dokter->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Bidang --}}
                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 bg-light rounded-3 h-100">
                                <div class="fs-3 text-warning me-3"><i class="bi bi-award"></i></div>
                                <div>
                                    <small class="text-muted d-block fw-bold text-uppercase">Spesialisasi</small>
                                    <span class="fw-bold text-dark">{{ $dokter->bidang_dokter }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Alamat --}}
                        <div class="col-12">
                            <div class="d-flex p-3 bg-light rounded-3">
                                <div class="fs-3 text-danger me-3"><i class="bi bi-geo-alt"></i></div>
                                <div>
                                    <small class="text-muted d-block fw-bold text-uppercase mb-1">Alamat Domisili</small>
                                    <span class="text-dark">{{ $dokter->alamat }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Alert Info --}}
                    <div class="alert alert-info mt-4 mb-0 border-0 bg-info bg-opacity-10 text-info d-flex align-items-center">
                        <i class="bi bi-info-circle-fill me-2 fs-5"></i>
                        <small>Jika terdapat kesalahan data profil, silakan hubungi <strong>Administrator</strong> untuk melakukan pembaruan data.</small>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection
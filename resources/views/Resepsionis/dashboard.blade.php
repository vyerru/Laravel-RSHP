@extends('layouts.app')
@section('title', 'Dashboard Resepsionis')
@section('content')
<div class="container py-4">
    {{-- Header --}}
    <div class="alert alert-primary border-0 shadow-sm d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">Dashboard Resepsionis</h4>
            <small>Selamat datang, {{ Auth::user()->nama }}</small>
        </div>
        <div>
            <a href="{{ route('Resepsionis.Pemilik.index') }}" class="btn btn-light fw-bold text-primary">
                <i class="bi bi-person-plus-fill me-1"></i> Registrasi Pasien Baru
            </a>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm border-start border-4 border-primary">
                <div class="card-body">
                    <h5 class="text-muted small text-uppercase">Antrian Hari Ini</h5>
                    <h2 class="fw-bold text-primary">{{ $stats['antrian_hari_ini'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm border-start border-4 border-success">
                <div class="card-body">
                    <h5 class="text-muted small text-uppercase">Pasien Baru (Hewan)</h5>
                    <h2 class="fw-bold text-success">{{ $stats['pasien_baru'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm border-start border-4 border-warning">
                <div class="card-body">
                    <h5 class="text-muted small text-uppercase">Total Database Pemilik</h5>
                    <h2 class="fw-bold text-warning">{{ $stats['total_pemilik'] }}</h2>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Antrian --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white fw-bold">Jadwal Praktek Hari Ini</div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">No</th>
                        <th>Pasien</th>
                        <th>Pemilik</th>
                        <th>Dokter Tujuan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($antrian as $a)
                    <tr>
                        <td class="ps-4 fw-bold">{{ $a->no_urut }}</td>
                        <td>{{ $a->pet->nama }}</td>
                        <td>{{ $a->pet->pemilik->user->nama }}</td>
                        <td>{{ $a->dokter->user->nama ?? '-' }}</td>
                        <td>
                            <span class="badge bg-{{ $a->status_badge }}">{{ $a->status_label }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-4">Belum ada pendaftaran hari ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
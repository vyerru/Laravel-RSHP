@extends('layouts.app')

@section('title', 'Detail Pemeriksaan')

@section('content')
<div class="container py-4">
    {{-- Tombol Kembali --}}
    <div class="mb-4">
        <a href="{{ route('Perawat.Dashboard.index') }}" class="text-decoration-none text-muted">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
        </a>
    </div>

    <div class="row g-4">
        
        {{-- KOLOM KIRI: INFO PASIEN --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-body text-center p-4">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3 text-success">
                        <i class="bi bi-github" style="font-size: 3rem;"></i>
                    </div>
                    <h4 class="fw-bold mb-1">{{ $reservasi->pet->nama }}</h4>
                    <p class="text-muted mb-2">{{ $reservasi->pet->rasHewan->nama_ras ?? '-' }}</p>
                    
                    <span class="badge bg-{{ $reservasi->status == '2' ? 'success' : ($reservasi->status == '1' ? 'info' : 'warning') }} mb-3">
                        {{ $reservasi->status == '2' ? 'Selesai' : ($reservasi->status == '1' ? 'Sedang Diperiksa' : 'Menunggu Dokter') }}
                    </span>

                    <ul class="list-group list-group-flush text-start small mt-3">
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Pemilik</span>
                            <span class="fw-bold">{{ $reservasi->pet->pemilik->user->nama ?? '-' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">No. Urut</span>
                            <span class="fw-bold fs-5">#{{ $reservasi->no_urut }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: DATA MEDIS --}}
        <div class="col-lg-8">
            
            {{-- 1. DATA PERAWAT (TRIAGE) --}}
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-success text-white py-3">
                    <h6 class="fw-bold mb-0"><i class="bi bi-clipboard-pulse me-2"></i>Pemeriksaan Awal (Perawat)</h6>
                </div>
                <div class="card-body bg-light">
                    @if($reservasi->rekamMedis)
                        <div class="mb-3">
                            <label class="small text-muted fw-bold text-uppercase">Anamnesa / Keluhan</label>
                            <p class="mb-0 fw-bold">{{ $reservasi->rekamMedis->anamnesa }}</p>
                        </div>
                        <div class="mb-0">
                            <label class="small text-muted fw-bold text-uppercase">Tanda Vital / Temuan Klinis</label>
                            <p class="mb-0 border-start border-3 border-success ps-3 bg-white p-2 rounded">
                                {{ $reservasi->rekamMedis->temuan_klinis }}
                            </p>
                        </div>
                    @else
                        <div class="text-center py-3 text-muted">
                            <i class="bi bi-exclamation-circle me-1"></i> Belum ada data triage.
                        </div>
                    @endif
                </div>
            </div>

            {{-- 2. DATA DOKTER (DIAGNOSA & RESEP) --}}
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold mb-0 text-primary"><i class="bi bi-person-check-fill me-2"></i>Hasil Pemeriksaan Dokter</h6>
                </div>
                <div class="card-body">
                    @if($reservasi->rekamMedis && $reservasi->status == '2')
                        {{-- Diagnosa --}}
                        <div class="mb-4">
                            <label class="small text-muted fw-bold text-uppercase">Diagnosa Medis</label>
                            <p class="fs-5 text-dark fw-bold mb-1">{{ $reservasi->rekamMedis->diagnosa }}</p>
                            <small class="text-muted">Dr. {{ $reservasi->rekamMedis->dokter->user->nama ?? '-' }}</small>
                        </div>

                        {{-- Tabel Tindakan/Resep --}}
                        <div class="table-responsive">
                            <label class="small text-muted fw-bold text-uppercase mb-2">Tindakan & Obat</label>
                            <table class="table table-sm table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama Tindakan / Obat</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($reservasi->rekamMedis->detailTindakan as $dt)
                                    <tr>
                                        <td>{{ $dt->tindakan->deskripsi_tindakan_terapi ?? '-' }}</td>
                                        <td>{{ $dt->detail ?? '-' }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-muted">Tidak ada tindakan tambahan.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3 text-muted opacity-50">
                                <i class="bi bi-hourglass-split fs-1"></i>
                            </div>
                            <h6 class="fw-bold text-muted">Menunggu Pemeriksaan Dokter</h6>
                            <p class="small text-muted">Dokter belum menyelesaikan diagnosa untuk pasien ini.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
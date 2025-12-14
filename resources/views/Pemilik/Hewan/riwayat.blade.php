@extends('layouts.app')
@section('title', 'Riwayat Medis - ' . $pet->nama)
@section('content')
<div class="container py-4">
    <div class="mb-4">
        <a href="{{ route('Pemilik.Hewan.index') }}" class="text-decoration-none text-muted">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="d-flex align-items-center mb-4">
        <div class="bg-primary text-white rounded-circle p-3 me-3">
            <i class="bi bi-journal-medical fs-3"></i>
        </div>
        <div>
            <h3 class="fw-bold mb-0">Riwayat Medis: {{ $pet->nama }}</h3>
            <p class="text-muted mb-0">Catatan kesehatan dari dokter.</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="list-group list-group-flush">
            @forelse($pet->rekamMedis as $rm)
                <div class="list-group-item p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="fw-bold text-dark mb-1">{{ $rm->diagnosa }}</h5>
                            <p class="text-muted small mb-2">
                                <i class="bi bi-person-check me-1"></i> Dr. {{ $rm->dokter->user->nama ?? '-' }}
                                <span class="mx-2">•</span>
                                <i class="bi bi-calendar-event me-1"></i> {{ \Carbon\Carbon::parse($rm->created_at)->translatedFormat('d F Y') }}
                            </p>
                            
                            {{-- Badge Tindakan --}}
                            @foreach($rm->detailTindakan as $dt)
                                <span class="badge bg-light text-secondary border me-1">
                                    {{ $dt->tindakan->deskripsi_tindakan_terapi }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <p class="text-muted">Belum ada riwayat pemeriksaan untuk hewan ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
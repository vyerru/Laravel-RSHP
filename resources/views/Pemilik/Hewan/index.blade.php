@extends('layouts.app')
@section('title', 'Hewan Saya')
@section('content')
<div class="container py-4">
    <h3 class="fw-bold mb-4"><i class="bi bi-github me-2 text-primary"></i>Hewan Peliharaan Saya</h3>

    <div class="row g-4">
        @forelse($pets as $pet)
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100 hover-shadow transition-all">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="bg-info bg-opacity-10 text-info rounded-circle p-3">
                            <i class="bi bi-heart-pulse-fill fs-3"></i>
                        </div>
                        @if($pet->jenis_kelamin == 'J')
                            <span class="badge bg-primary rounded-pill">Jantan</span>
                        @else
                            <span class="badge bg-danger rounded-pill">Betina</span>
                        @endif
                    </div>
                    
                    <h4 class="fw-bold mb-1">{{ $pet->nama }}</h4>
                    <p class="text-muted mb-3">
                        {{ $pet->rasHewan->nama_ras }} <small>({{ $pet->rasHewan->jenisHewan->nama_jenis_hewan }})</small>
                    </p>

                    <ul class="list-unstyled text-muted small mb-4">
                        <li class="mb-1"><i class="bi bi-cake2 me-2"></i> {{ $pet->tanggal_lahir }}</li>
                        <li><i class="bi bi-palette me-2"></i> {{ $pet->warna_tanda }}</li>
                    </ul>

                    <div class="d-grid">
                        <a href="{{ route('Pemilik.Hewan.riwayat', $pet->idpet) }}" class="btn btn-light text-primary fw-bold">
                            <i class="bi bi-clock-history me-1"></i> Lihat Riwayat Medis
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <img src="https://cdni.iconscout.com/illustration/premium/thumb/empty-state-2130362-1800926.png" style="width: 200px; opacity: 0.5;">
            <p class="text-muted mt-3">Belum ada hewan yang terdaftar.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
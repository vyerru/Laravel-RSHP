@extends('layouts.app')

@section('title', 'Data Pasien')

@section('content')
<div class="container py-4">
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h2 class="fw-bold text-primary mb-0"><i class="bi bi-heart-pulse me-2"></i>Data Pasien</h2>
            <p class="text-muted mb-0">Cari data hewan dan riwayat medisnya.</p>
        </div>
        <div class="col-md-6 text-end">
            <form action="{{ route('Dokter.Pasien.index') }}" method="GET" class="d-flex justify-content-md-end">
                <div class="input-group" style="max-width: 300px;">
                    <input type="text" name="search" class="form-control" placeholder="Cari Hewan / Pemilik..." value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Nama Hewan</th>
                            <th>Ras / Jenis</th>
                            <th>Jns. Kelamin</th>
                            <th>Pemilik</th>
                            <th>Umur</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pets as $pet)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded-circle p-2 text-primary me-3">
                                        <i class="bi bi-github fs-4"></i> {{-- Icon Hewan Default --}}
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold text-dark">{{ $pet->nama }}</h6>
                                        <small class="text-muted">ID: #{{ $pet->idpet }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                {{ $pet->rasHewan->nama_ras ?? '-' }} <br>
                                <small class="text-muted">{{ $pet->rasHewan->jenisHewan->nama_jenis_hewan ?? '-' }}</small>
                            </td>
                            <td>
                                @if($pet->jenis_kelamin == 'Jantan')
                                    <span class="badge bg-primary bg-opacity-10 text-primary"><i class="bi bi-gender-male"></i> Jantan</span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger"><i class="bi bi-gender-female"></i> Betina</span>
                                @endif
                            </td>
                            <td>
                                {{ $pet->pemilik->user->nama ?? '-' }} <br>
                                <small class="text-muted"><i class="bi bi-whatsapp me-1"></i> {{ $pet->pemilik->no_wa ?? '-' }}</small>
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($pet->tanggal_lahir)->age }} Tahun
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('Dokter.Pasien.show', $pet->idpet) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                    <i class="bi bi-file-medical me-1"></i> Detail & Riwayat
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-search fs-1 d-block mb-2 opacity-50"></i>
                                Data pasien tidak ditemukan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        {{-- Pagination --}}
        <div class="card-footer bg-white py-3">
            {{ $pets->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
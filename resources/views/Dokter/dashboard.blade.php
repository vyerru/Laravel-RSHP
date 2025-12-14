@extends('layouts.app')
@section('title', 'Dashboard Dokter')
@section('content')
<div class="container py-4">
    {{-- Welcome Card --}}
    <div class="card bg-primary text-white shadow border-0 rounded-3 mb-4">
        <div class="card-body p-4">
            <h2 class="fw-bold mb-1">Halo, Dr. {{ Auth::user()->nama }}! </h2>
            <p class="mb-0 opacity-75">Ada <strong class="text-warning">{{ $stats['pasien_hari_ini'] }} pasien</strong> hari ini.</p>
        </div>
    </div>

    {{-- Tabel Antrian --}}
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-white py-3">
            <h5 class="card-title fw-bold mb-0 text-primary">Antrian Pemeriksaan</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Jam</th>
                        <th>Pasien</th>
                        <th>Pemilik</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pasienHariIni as $p)
                    <tr>
                        <td class="ps-4 fw-bold">{{ \Carbon\Carbon::parse($p->waktu_daftar)->format('H:i') }}</td>
                        <td>{{ $p->pet->nama }} <br> <small class="text-muted">{{ $p->pet->rasHewan->nama_ras }}</small></td>
                        <td>{{ $p->pet->pemilik->user->nama }}</td>
                        <td>
                            <span class="badge bg-{{ $p->status == '0' ? 'warning' : ($p->status == '1' ? 'info' : 'success') }}">
                                {{ $p->status_label }}
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            @if($p->status != '2')
                                <a href="{{ route('Dokter.Pemeriksaan.edit', $p->idreservasi_dokter) }}" class="btn btn-sm btn-primary rounded-pill px-3">Periksa</a>
                            @else
                                <button class="btn btn-sm btn-secondary rounded-pill" disabled>Selesai</button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-4">Tidak ada jadwal hari ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
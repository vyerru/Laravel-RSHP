@extends('layouts.app')
@section('title', 'Dashboard Perawat')
@section('content')
<div class="container py-4">
    <div class="alert alert-success text-white border-0 shadow-sm mb-4" style="background: linear-gradient(to right, #198754, #20c997);">
        <h4 class="fw-bold">Halo, Perawat {{ Auth::user()->nama }}! 👋</h4>
        <p class="mb-0">Selamat bertugas. Total antrian hari ini: <strong>{{ $stats['total_antrian'] }} Pasien</strong>.</p>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100 border-start border-4 border-warning">
                <div class="card-body">
                    <h5 class="text-muted small fw-bold text-uppercase">Menunggu Dokter</h5>
                    <h2 class="fw-bold text-warning">{{ $stats['menunggu_dokter'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100 border-start border-4 border-success">
                <div class="card-body">
                    <h5 class="text-muted small fw-bold text-uppercase">Selesai</h5>
                    <h2 class="fw-bold text-success">{{ $stats['selesai'] }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white fw-bold">Antrian Pasien Hari Ini</div>
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">No</th>
                        <th>Pasien</th>
                        <th>Pemilik</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pasienHariIni as $p)
                    <tr>
                        <td class="ps-4 fw-bold">{{ $p->no_urut }}</td>
                        <td>{{ $p->pet->nama }} <br> <small class="text-muted">{{ $p->pet->rasHewan->nama_ras }}</small></td>
                        <td>{{ $p->pet->pemilik->user->nama }}</td>
                        <td>
                            @if($p->status == '0') <span class="badge bg-warning text-dark">Menunggu</span>
                            @elseif($p->status == '1') <span class="badge bg-info">Diperiksa</span>
                            @else <span class="badge bg-success">Selesai</span> @endif
                        </td>
                        <td class="text-end pe-4">
                            @if($p->status == '0')
                                <a href="{{ route('Perawat.Pemeriksaan.create', $p->idreservasi_dokter) }}" class="btn btn-sm btn-primary">Input Tanda Vital</a>
                            @else
                                <a href="{{ route('Perawat.Pemeriksaan.show', $p->idreservasi_dokter) }}" class="btn btn-sm btn-outline-secondary">Lihat Detail</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')
@section('title', 'Riwayat Pemeriksaan Saya')
@section('content')
<div class="container py-4">
    <h2 class="fw-bold text-primary mb-4">Riwayat Pemeriksaan Saya</h2>
    <div class="card border-0 shadow-sm">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr><th class="ps-4">Tanggal</th><th>Pasien</th><th>Diagnosa</th><th class="text-end pe-4">Aksi</th></tr>
            </thead>
            <tbody>
                @foreach($rekamMedis as $rm)
                <tr>
                    <td class="ps-4">{{ $rm->created_at->format('d M Y') }}</td>
                    <td>{{ $rm->reservasi->pet->nama }}</td>
                    <td>{{ Str::limit($rm->diagnosa, 30) }}</td>
                    <td class="text-end pe-4">
                        <a href="{{ route('Dokter.Pemeriksaan.edit', $rm->idreservasi_dokter) }}" class="btn btn-sm btn-outline-secondary">Detail</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-3">{{ $rekamMedis->links() }}</div>
    </div>
</div>
@endsection
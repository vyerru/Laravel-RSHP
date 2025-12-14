@extends('layouts.app')

@section('title', 'Detail Pemeriksaan')

@section('content')
<div class="container py-4">
     <div class="mb-4">
        <a href="{{ route('Dokter.RekamMedis.index') }}" class="text-decoration-none text-muted">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    {{-- Banner Status --}}
    @if($reservasi->status == '2')
        <div class="alert alert-success d-flex align-items-center">
            <i class="bi bi-check-circle-fill fs-4 me-2"></i>
            <div>
                <strong>Pemeriksaan Selesai</strong>
                <span class="d-block small">Data ini telah dikunci dan tidak dapat diubah.</span>
            </div>
        </div>
    @else
        <div class="alert alert-primary">
            Sedang Memeriksa: <strong>{{ $reservasi->pet->nama }}</strong>
        </div>
    @endif

    <div class="row g-4">
        {{-- KOLOM KIRI: DIAGNOSA --}}
        <div class="col-lg-5">
            {{-- Data Perawat (Read Only) --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light fw-bold text-muted">Data Perawat</div>
                <div class="card-body bg-light">
                    <small class="fw-bold d-block">Keluhan</small> <p>{{ $rekamMedis->anamnesa ?? '-' }}</p>
                    <small class="fw-bold d-block">Tanda Vital</small> <p>{{ $rekamMedis->temuan_klinis ?? '-' }}</p>
                </div>
            </div>

            {{-- Form Diagnosa --}}
            <div class="card border-0 shadow-sm border-start border-4 border-primary">
                <div class="card-body">
                    <h6 class="fw-bold text-primary mb-3">Diagnosa Dokter</h6>
                    
                    <form action="{{ route('Dokter.Pemeriksaan.updateDiagnosa', $rekamMedis->idrekam_medis) }}" method="POST">
                        @csrf @method('PUT')
                        
                        {{-- Logika Read Only --}}
                        <textarea name="diagnosa" class="form-control mb-3" rows="4" required 
                            {{ $reservasi->status == '2' ? 'disabled' : '' }}>{{ $rekamMedis->diagnosa }}</textarea>
                        
                        @if($reservasi->status != '2')
                            <button type="submit" class="btn btn-primary w-100" onclick="return confirm('Selesai?')">
                                Simpan & Selesai
                            </button>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: TINDAKAN --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white fw-bold text-success">Tindakan & Obat</div>
                <div class="card-body">
                    
                    {{-- Form Tambah Tindakan (Hanya muncul jika BELUM selesai) --}}
                    @if($reservasi->status != '2')
                        <form action="{{ route('Dokter.Pemeriksaan.storeDetail') }}" method="POST" class="row g-2 mb-4">
                            @csrf
                            <input type="hidden" name="idrekam_medis" value="{{ $rekamMedis->idrekam_medis }}">
                            <div class="col-6">
                                <select name="idkode_tindakan_terapi" class="form-select form-select-sm" required>
                                    <option value="">-- Pilih --</option>
                                    @foreach($tindakanList as $t) 
                                        <option value="{{ $t->idkode_tindakan_terapi }}">{{ $t->deskripsi_tindakan_terapi }}</option> 
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-4">
                                <input type="text" name="detail" class="form-control form-select-sm" placeholder="Catatan">
                            </div>
                            <div class="col-2">
                                <button class="btn btn-sm btn-success w-100">Add</button>
                            </div>
                        </form>
                    @endif

                    {{-- Tabel List Tindakan --}}
                    <table class="table table-sm align-middle">
                        <thead class="table-light">
                            <tr><th>Tindakan</th><th>Catatan</th><th class="text-end"></th></tr>
                        </thead>
                        <tbody>
                            @foreach($detailTindakan as $dt)
                            <tr>
                                <td>{{ $dt->tindakan->deskripsi_tindakan_terapi ?? '-' }}</td>
                                <td>{{ $dt->detail }}</td>
                                <td class="text-end">
                                    {{-- Tombol Hapus (Hanya jika BELUM selesai) --}}
                                    @if($reservasi->status != '2')
                                        <form action="{{ route('Dokter.Pemeriksaan.destroyDetail', $dt->iddetail_rekam_medis) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm text-danger p-0 border-0" onclick="return confirm('Hapus?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
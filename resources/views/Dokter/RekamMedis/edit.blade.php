@extends('layouts.app')

@section('title', 'Pemeriksaan & Tindakan')

@section('content')
<div class="container py-4">
    
    {{-- Header Info Pasien (Singkat) --}}
    <div class="alert alert-primary d-flex justify-content-between align-items-center">
        <div>
            <i class="bi bi-github me-2"></i>
            Pasien: <strong>{{ $reservasi->pet->nama }}</strong> ({{ $reservasi->pet->rasHewan->nama_ras }})
        </div>
        <div>
            Pemilik: {{ $reservasi->pet->pemilik->user->nama }}
        </div>
    </div>

    <div class="row g-4">
        
        {{-- KOLOM KIRI: DATA PERAWAT & DIAGNOSA DOKTER --}}
        <div class="col-lg-5">
            
            {{-- 1. DATA DARI PERAWAT (Read Only) --}}
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-light py-3">
                    <h6 class="fw-bold mb-0 text-muted"><i class="bi bi-clipboard-data me-2"></i>Data Awal (Perawat)</h6>
                </div>
                <div class="card-body bg-light">
                    <div class="mb-3">
                        <label class="small text-muted fw-bold">Anamnesa / Keluhan</label>
                        <p class="mb-0 fw-bold">{{ $rekamMedis->anamnesa ?? '(Belum diisi perawat)' }}</p>
                    </div>
                    <div class="mb-0">
                        <label class="small text-muted fw-bold">Temuan Klinis / Tanda Vital</label>
                        <p class="mb-0">{{ $rekamMedis->temuan_klinis ?? '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- 2. DIAGNOSA DOKTER (Form Utama) --}}
            <div class="card border-0 shadow-sm rounded-3 border-start border-4 border-primary">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold mb-0 text-primary"><i class="bi bi-person-check me-2"></i>Diagnosa Dokter</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('Dokter.RekamMedis.updateDiagnosa', $rekamMedis->idrekam_medis) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Diagnosa Medis</label>
                            <textarea name="diagnosa" class="form-control" rows="4" placeholder="Tuliskan diagnosa akhir..." required>{{ $rekamMedis->diagnosa }}</textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary" onclick="return confirm('Selesaikan pemeriksaan? Status pasien akan menjadi SELESAI.')">
                                <i class="bi bi-check-circle-fill me-2"></i>Simpan Diagnosa & Selesai
                            </button>
                            <small class="text-muted text-center mt-2">*Pastikan Tindakan/Terapi sudah diinput sebelum klik Selesai.</small>
                        </div>
                    </form>
                </div>
            </div>

        </div>

        {{-- KOLOM KANAN: CRUD DETAIL TINDAKAN (Child Table) --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0 text-success"><i class="bi bi-capsule me-2"></i>Tindakan & Terapi</h6>
                    <span class="badge bg-success bg-opacity-10 text-success">{{ $detailTindakan->count() }} Item</span>
                </div>
                <div class="card-body">
                    
                    {{-- FORM TAMBAH DETAIL (CREATE) --}}
                    <form action="{{ route('Dokter.RekamMedis.storeDetail') }}" method="POST" class="mb-4 p-3 bg-light rounded-3">
                        @csrf
                        <input type="hidden" name="idrekam_medis" value="{{ $rekamMedis->idrekam_medis }}">
                        
                        <div class="row g-2">
                            <div class="col-md-5">
                                <label class="small fw-bold mb-1">Pilih Tindakan/Obat</label>
                                <select name="idkode_tindakan_terapi" class="form-select form-select-sm" required>
                                    <option value="">-- Pilih --</option>
                                    @foreach($tindakanList as $t)
                                        <option value="{{ $t->idkode_tindakan_terapi }}">
                                            {{ $t->nama_tindakan }} ({{ $t->kategori->nama_kategori ?? '-' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label class="small fw-bold mb-1">Catatan Tambahan (Opsional)</label>
                                <input type="text" name="detail" class="form-control form-select-sm" placeholder="Cth: 2x1 hari, 5ml...">
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-sm btn-success w-100">
                                    <i class="bi bi-plus-lg"></i> Add
                                </button>
                            </div>
                        </div>
                    </form>

                    {{-- TABEL LIST DETAIL (READ & DELETE) --}}
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light text-secondary">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Tindakan / Terapi</th>
                                    <th>Catatan</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($detailTindakan as $dt)
                                <tr>
                                    <td width="5%">{{ $loop->iteration }}</td>
                                    <td>
                                        <span class="fw-bold text-dark">{{ $dt->tindakan->nama_tindakan ?? '-' }}</span>
                                        <br>
                                        <small class="text-muted">{{ $dt->tindakan->kategori->nama_kategori ?? '' }}</small>
                                    </td>
                                    <td>{{ $dt->detail ?? '-' }}</td>
                                    <td class="text-end">
                                        {{-- FORM DELETE DETAIL --}}
                                        <form action="{{ route('Dokter.RekamMedis.destroyDetail', $dt->iddetail_rekam_medis) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm text-danger border-0 bg-transparent p-0" onclick="return confirm('Hapus tindakan ini?')">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted border-bottom-0">
                                        <i class="bi bi-basket opacity-50 d-block fs-3 mb-2"></i>
                                        Belum ada tindakan yang ditambahkan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection
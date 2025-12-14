@extends('layouts.app')

@section('title', 'Pemeriksaan Awal (Triage)')

@section('content')
<div class="container py-4">
    <h3 class="fw-bold text-success mb-4"><i class="bi bi-clipboard2-pulse me-2"></i>Pemeriksaan Awal (Triage)</h3>

    {{-- Alert Success --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Error Validation (Agar modal muncul lagi jika error) --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-white py-3">
            <h6 class="mb-0 fw-bold">Daftar Antrian Pasien (Menunggu)</h6>
        </div>
        <div class="table-responsive">
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
                    @forelse($antrian as $row)
                    <tr>
                        <td class="ps-4 fw-bold">{{ $row->no_urut }}</td>
                        <td>
                            <span class="fw-bold">{{ $row->pet->nama }}</span>
                            <br>
                            <small class="text-muted">{{ $row->pet->rasHewan->nama_ras }}</small>
                        </td>
                        <td>{{ $row->pet->pemilik->user->nama }}</td>
                        <td><span class="badge bg-warning text-dark">Menunggu Triage</span></td>
                        <td class="text-end pe-4">
                            {{-- TOMBOL TRIGGER MODAL --}}
                            {{-- Kita kirim data ke function JS lewat parameter --}}
                            <button type="button" 
                                class="btn btn-sm btn-primary px-3 rounded-pill"
                                onclick="bukaModalTriage(
                                    '{{ $row->idreservasi_dokter }}',
                                    '{{ $row->pet->nama }}',
                                    '{{ $row->pet->rasHewan->nama_ras }}',
                                    '{{ $row->idrole_user }}',
                                    '{{ $row->rekamMedis->anamnesa ?? '' }}', 
                                    '{{ $row->rekamMedis->temuan_klinis ?? '' }}'
                                )">
                                <i class="bi bi-pencil-square me-1"></i> Input Vital
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">Belum ada antrian pasien.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ================= MODAL FORM INPUT ================= --}}
<div class="modal fade" id="modalTriage" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-bold"><i class="bi bi-clipboard-plus me-2"></i>Input Tanda Vital Pasien</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('Perawat.Pemeriksaan.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    {{-- Hidden Inputs --}}
                    <input type="hidden" name="idreservasi_dokter" id="input_idreservasi">
                    <input type="hidden" name="dokter_pemeriksa_dummy" id="input_iddokter">

                    {{-- Info Pasien (Read Only) --}}
                    <div class="alert alert-light border d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <small class="text-muted d-block text-uppercase fw-bold">Nama Pasien</small>
                            <span class="fs-5 fw-bold text-success" id="label_nama_pasien">-</span>
                        </div>
                        <div class="text-end">
                            <small class="text-muted d-block text-uppercase fw-bold">Ras Hewan</small>
                            <span class="fw-bold" id="label_ras">-</span>
                        </div>
                    </div>

                    {{-- Form Inputs --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Anamnesa (Keluhan)</label>
                        <textarea name="anamnesa" id="input_anamnesa" class="form-control" rows="3" placeholder="Contoh: Muntah 3x, lemas..." required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Temuan Klinis (Tanda Vital)</label>
                        <textarea name="temuan_klinis" id="input_vital" class="form-control" rows="3" placeholder="Berat badan, Suhu tubuh, Detak jantung..." required></textarea>
                        <div class="form-text">Masukkan parameter vital sign dengan jelas.</div>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success fw-bold"><i class="bi bi-save me-1"></i> Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ================= JAVASCRIPT ================= --}}
<script>
    function bukaModalTriage(idRes, namaPet, rasPet, idDokter, anamnesaLama, vitalLama) {
        // 1. Isi nilai ke dalam Input Form
        document.getElementById('input_idreservasi').value = idRes;
        document.getElementById('input_iddokter').value = idDokter;
        
        // 2. Update Label Info Pasien
        document.getElementById('label_nama_pasien').innerText = namaPet;
        document.getElementById('label_ras').innerText = rasPet;

        // 3. Isi Textarea (jika data lama ada/edit mode)
        document.getElementById('input_anamnesa').value = anamnesaLama;
        document.getElementById('input_vital').value = vitalLama;

        // 4. Tampilkan Modal
        var myModal = new bootstrap.Modal(document.getElementById('modalTriage'));
        myModal.show();
    }
</script>
@endsection
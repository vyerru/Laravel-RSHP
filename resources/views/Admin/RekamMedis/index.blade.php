@extends('layouts.app')

@section('title', 'Data Rekam Medis')

@section('content')
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="text-info fw-bold"><i class="bi bi-activity me-2"></i>Rekam Medis Pasien</h2>
            <p class="text-muted">Riwayat pemeriksaan dan diagnosa dokter.</p>
        </div>
        <div class="col-md-4 text-end align-self-center">
            <button type="button" class="btn btn-info text-white" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="bi bi-plus-lg me-2"></i>Buat Rekam Medis
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Tgl Periksa</th>
                            <th>Pasien / Hewan</th>
                            <th>Dokter</th>
                            <th>Diagnosa Utama</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rekamMedis as $rm)
                        <tr>
                            <td>
                                {{ $rm->created_at ? $rm->created_at->format('d M Y') : '-' }} <br>
                                <small class="text-muted">{{ $rm->created_at ? $rm->created_at->format('H:i') : '' }}</small>
                            </td>
                            <td>
                                <strong>{{ $rm->reservasi?->pet?->nama ?? 'Invalid' }}</strong>
                                <span class="badge bg-light text-dark border ms-1">
                                    {{ $rm->reservasi?->pet?->rasHewan?->nama_ras ?? '-' }}
                                </span>
                                <br>
                                <small class="text-muted">Pemilik: {{ $rm->reservasi?->pet?->pemilik?->user?->nama ?? '-' }}</small>
                            </td>
                            <td>
                                {{ $rm->dokter?->user?->nama ?? 'Dokter Tidak Ditemukan' }}
                            </td>
                            <td>
                                <span class="text-danger fw-bold">{{ Str::limit($rm->diagnosa, 30) }}</span>
                                <br>
                                <small class="text-muted">Keluhan: {{ Str::limit($rm->anamnesa, 30) }}</small>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-warning me-1" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editModal"
                                    data-id="{{ $rm->idrekam_medis }}"
                                    data-dokter="{{ $rm->dokter_pemeriksa }}"
                                    data-anamnesa="{{ $rm->anamnesa }}"
                                    data-temuan="{{ $rm->temuan_klinis }}"
                                    data-diagnosa="{{ $rm->diagnosa }}"
                                    data-url="{{ route('Admin.RekamMedis.update', $rm->idrekam_medis) }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                <form action="{{ route('Admin.RekamMedis.destroy', $rm->idrekam_medis) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus rekam medis ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada data rekam medis.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- MODAL CREATE --}}
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title fw-bold">Input Hasil Pemeriksaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('Admin.RekamMedis.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-light border mb-3">
                        <small><i class="bi bi-info-circle me-1"></i> Pilih pasien dari daftar antrian yang sedang/sudah diperiksa.</small>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pilih Pasien (Antrian)</label>
                            <select class="form-select" name="idreservasi_dokter" required>
                                <option value="">-- Pilih Pasien --</option>
                                @foreach($reservasiTersedia as $res)
                                    <option value="{{ $res->idreservasi_dokter }}">
                                        No. {{ $res->no_urut }} - {{ $res->pet?->nama }} ({{ $res->pet?->pemilik?->user?->nama }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Dokter Pemeriksa</label>
                            <select class="form-select" name="dokter_pemeriksa" required>
                                <option value="">-- Pilih Dokter --</option>
                                @foreach($dokter as $d)
                                    <option value="{{ $d->idrole_user }}">{{ $d->user->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Anamnesa (Keluhan Awal)</label>
                        <textarea class="form-control" name="anamnesa" rows="2" placeholder="Contoh: Muntah, tidak mau makan..." required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Temuan Klinis (Hasil Periksa)</label>
                        <textarea class="form-control" name="temuan_klinis" rows="2" placeholder="Contoh: Suhu 39C, dehidrasi ringan..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Diagnosa (Kesimpulan)</label>
                        <textarea class="form-control" name="diagnosa" rows="2" placeholder="Contoh: Panleukopenia, Flu Kucing..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Rekam Medis</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL EDIT --}}
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Edit Rekam Medis</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Dokter Pemeriksa</label>
                        <select class="form-select" id="edit_dokter" name="dokter_pemeriksa" required>
                            @foreach($dokter as $d)
                                <option value="{{ $d->idrole_user }}">{{ $d->user->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Anamnesa</label>
                        <textarea class="form-control" id="edit_anamnesa" name="anamnesa" rows="2" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Temuan Klinis</label>
                        <textarea class="form-control" id="edit_temuan" name="temuan_klinis" rows="2"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Diagnosa</label>
                        <textarea class="form-control" id="edit_diagnosa" name="diagnosa" rows="2" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var editModal = document.getElementById('editModal');
        editModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            
            var dokter = button.getAttribute('data-dokter');
            var anamnesa = button.getAttribute('data-anamnesa');
            var temuan = button.getAttribute('data-temuan');
            var diagnosa = button.getAttribute('data-diagnosa');
            var url = button.getAttribute('data-url');
            
            editModal.querySelector('#edit_dokter').value = dokter;
            editModal.querySelector('#edit_anamnesa').value = anamnesa;
            editModal.querySelector('#edit_temuan').value = temuan;
            editModal.querySelector('#edit_diagnosa').value = diagnosa;
            
            document.getElementById('editForm').action = url;
        });
    });
</script>
@endpush
@endsection
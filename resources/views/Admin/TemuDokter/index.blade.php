@extends('layouts.app')

@section('title', 'Pendaftaran & Reservasi')

@section('content')
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="text-warning fw-bold"><i class="bi bi-calendar-check me-2"></i>Pendaftaran & Reservasi</h2>
            <p class="text-muted">Kelola jadwal temu dokter dan antrian pasien.</p>
        </div>
        <div class="col-md-4 text-end align-self-center">
            <button type="button" class="btn btn-warning text-white" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="bi bi-plus-lg me-2"></i>Daftar Baru
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No Urut</th>
                            <th>Waktu / Tanggal</th>
                            <th>Pasien (Pet)</th>
                            <th>Dokter</th>
                            <th>Status</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reservasi as $data)
                        <tr>
                            <td>
                                <span class="badge rounded-pill bg-secondary fs-6">{{ $data->no_urut }}</span>
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($data->waktu_daftar)->format('d M Y, H:i') }}
                            </td>
                            <td>
                                {{-- Gunakan tanda tanya (?) untuk mencegah error jika data kosong --}}
                                <strong>{{ $data->pet?->nama ?? 'Data Invalid' }}</strong> <br>
                                <small class="text-muted">{{ $data->pet?->pemilik?->user?->nama ?? 'Tanpa Pemilik' }}</small>
                            </td>
                            <td>
                                {{-- Gunakan tanda tanya (?) --}}
                                {{ $data->dokter?->user?->nama ?? 'Dokter Tidak Ditemukan' }}
                            </td>
                            <td>
                                <span class="badge bg-{{ $data->status_badge }}">
                                    {{ $data->status_label }}
                                </span>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-warning me-1" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editModal"
                                    data-id="{{ $data->idreservasi_dokter }}"
                                    data-waktu="{{ \Carbon\Carbon::parse($data->waktu_daftar)->format('Y-m-d\TH:i') }}"
                                    {{-- Gunakan tanda tanya di sini juga --}}
                                    data-dokter="{{ $data->idrole_user }}"
                                    data-status="{{ $data->status }}"
                                    data-url="{{ route('Admin.TemuDokter.update', $data->idreservasi_dokter) }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                <form action="{{ route('Admin.TemuDokter.destroy', $data->idreservasi_dokter) }}" method="POST" class="d-inline" onsubmit="return confirm('Batalkan reservasi ini?');">
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
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada antrian reservasi.</td>
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title fw-bold">Pendaftaran Pasien Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('Admin.TemuDokter.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Waktu Rencana Datang</label>
                        <input type="datetime-local" class="form-control" name="waktu_daftar" 
                               value="{{ now()->format('Y-m-d\TH:i') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pilih Pasien (Hewan)</label>
                        <select class="form-select" name="idpet" required>
                            <option value="">-- Cari Pasien --</option>
                            @foreach($pets as $pet)
                                <option value="{{ $pet->idpet }}">
                                    {{-- PERBAIKAN DI SINI: Gunakan ?-> --}}
                                    {{ $pet->nama }} (Pemilik: {{ $pet->pemilik?->user?->nama ?? 'Tanpa Pemilik' }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pilih Dokter</label>
                        <select class="form-select" name="idrole_user" required>
                            <option value="">-- Pilih Dokter --</option>
                            @foreach($dokter as $d)
                                <option value="{{ $d->idrole_user }}">
                                    {{-- PERBAIKAN DI SINI: Gunakan ?-> --}}
                                    {{ $d->user?->nama ?? 'Nama Tidak Ditemukan' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Daftarkan & Ambil Antrian</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL EDIT --}}
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Update Status / Jadwal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Waktu Daftar</label>
                        <input type="datetime-local" class="form-control" id="edit_waktu" name="waktu_daftar" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Dokter Pemeriksa</label>
                        <select class="form-select" id="edit_dokter" name="idrole_user" required>
                            @foreach($dokter as $d)
                                <option value="{{ $d->idrole_user }}">
                                    {{-- PERBAIKAN DI SINI: Gunakan ?-> --}}
                                    {{ $d->user?->nama ?? 'Nama Tidak Ditemukan' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status Kunjungan</label>
                        <select class="form-select" id="edit_status" name="status" required>
                            <option value="0">Menunggu</option>
                            <option value="1">Sedang Diperiksa</option>
                            <option value="2">Selesai</option>
                            <option value="9">Batal</option>
                        </select>
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
            
            var waktu = button.getAttribute('data-waktu');
            var dokter = button.getAttribute('data-dokter');
            var status = button.getAttribute('data-status');
            var url = button.getAttribute('data-url');
            
            editModal.querySelector('#edit_waktu').value = waktu;
            editModal.querySelector('#edit_dokter').value = dokter;
            editModal.querySelector('#edit_status').value = status;
            
            document.getElementById('editForm').action = url;
        });
    });
</script>
@endpush
@endsection
@extends('layouts.app')

@section('title', 'Data Jenis Hewan')

@section('content')
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="text-primary fw-bold">Data Jenis Hewan</h2>
            <p class="text-muted">Kelola kategori jenis hewan yang tersedia di klinik.</p>
        </div>
        <div class="col-md-4 text-end align-self-center">
            {{-- Tombol Tambah memicu Modal --}}
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="bi bi-plus-circle me-2"></i>Tambah Data
            </button>
        </div>
    </div>

    {{-- Alert Sukses --}}
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
                            <th width="10%">No</th>
                            <th>Nama Jenis Hewan</th>
                            <th width="20%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($jenisHewan as $index => $hewan)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $hewan->nama_jenis_hewan }}</td>
                            <td class="text-center">
                                {{-- Tombol Edit memicu Modal Edit --}}
                                <button type="button" class="btn btn-sm btn-warning me-1" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editModal"
                                    data-id="{{ $hewan->idjenis_hewan }}"
                                    data-nama="{{ $hewan->nama_jenis_hewan }}"
                                    data-url="{{ route('Admin.jenis-hewan.update', $hewan->idjenis_hewan) }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                {{-- Form Delete --}}
                                <form action="{{ route('Admin.jenis-hewan.destroy', $hewan->idjenis_hewan) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini? (Soft Delete)');">
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
                            <td colspan="3" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                Belum ada data jenis hewan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- MODAL CREATE --}}
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="createModalLabel">Tambah Jenis Hewan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('Admin.jenis-hewan.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_jenis_hewan" class="form-label">Nama Jenis Hewan</label>
                        <input type="text" class="form-control" id="nama_jenis_hewan" name="nama_jenis_hewan" placeholder="Contoh: Kucing, Anjing" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL EDIT --}}
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="editModalLabel">Edit Jenis Hewan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_nama_jenis_hewan" class="form-label">Nama Jenis Hewan</label>
                        <input type="text" class="form-control" id="edit_nama_jenis_hewan" name="nama_jenis_hewan" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
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
            // Tombol yang memicu modal
            var button = event.relatedTarget;
            
            // Ambil data dari atribut data-*
            var nama = button.getAttribute('data-nama');
            var url = button.getAttribute('data-url');
            
            // Isi nilai input dalam modal
            var modalBodyInput = editModal.querySelector('.modal-body input[name="nama_jenis_hewan"]');
            modalBodyInput.value = nama;
            
            // Update action form agar mengarah ke URL update yang benar
            var form = document.getElementById('editForm');
            form.action = url;
        });
    });
</script>
@endpush
@endsection
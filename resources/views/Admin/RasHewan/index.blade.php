@extends('layouts.app')

@section('title', 'Data Ras Hewan')

@section('content')
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="text-primary fw-bold">Data Ras Hewan</h2>
            <p class="text-muted">Kelola data ras hewan dan kategorinya.</p>
        </div>
        <div class="col-md-4 text-end align-self-center">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="bi bi-plus-circle me-2"></i>Tambah Data
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
                            <th width="5%">No</th>
                            <th>Nama Ras</th>
                            <th>Jenis Hewan</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rasHewan as $index => $ras)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $ras->nama_ras }}</td>
                            <td>
                                <span class="badge bg-info text-dark">
                                    {{ $ras->jenisHewan->nama_jenis_hewan ?? 'Tidak Diketahui' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-warning me-1" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editModal"
                                    data-id="{{ $ras->idras_hewan }}"
                                    data-nama="{{ $ras->nama_ras }}"
                                    data-jenis="{{ $ras->idjenis_hewan }}" 
                                    data-url="{{ route('Admin.RasHewan.update', $ras->idras_hewan) }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                <form action="{{ route('Admin.RasHewan.destroy', $ras->idras_hewan) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus ras ini?');">
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
                            <td colspan="4" class="text-center py-4 text-muted">Belum ada data ras hewan.</td>
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
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Tambah Ras Hewan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('Admin.RasHewan.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Jenis Hewan</label>
                        <select class="form-select" name="idjenis_hewan" required>
                            <option value="">-- Pilih Jenis Hewan --</option>
                            @foreach($jenisHewan as $jenis)
                                <option value="{{ $jenis->idjenis_hewan }}">{{ $jenis->nama_jenis_hewan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Ras</label>
                        <input type="text" class="form-control" name="nama_ras" placeholder="Contoh: Persia, Anggora" required>
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
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Edit Ras Hewan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Jenis Hewan</label>
                        <select class="form-select" id="edit_idjenis_hewan" name="idjenis_hewan" required>
                            <option value="">-- Pilih Jenis Hewan --</option>
                            @foreach($jenisHewan as $jenis)
                                <option value="{{ $jenis->idjenis_hewan }}">{{ $jenis->nama_jenis_hewan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Ras</label>
                        <input type="text" class="form-control" id="edit_nama_ras" name="nama_ras" required>
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
            var button = event.relatedTarget;
            
            // Ambil data
            var nama = button.getAttribute('data-nama');
            var jenisId = button.getAttribute('data-jenis');
            var url = button.getAttribute('data-url');
            
            // Isi form
            editModal.querySelector('#edit_nama_ras').value = nama;
            editModal.querySelector('#edit_idjenis_hewan').value = jenisId;
            document.getElementById('editForm').action = url;
        });
    });
</script>
@endpush
@endsection
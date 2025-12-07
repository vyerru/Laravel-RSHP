@extends('layouts.app')

@section('title', 'Data Kode Tindakan')

@section('content')
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="text-primary fw-bold">Data Kode Tindakan / Terapi</h2>
            <p class="text-muted">Kelola daftar layanan medis, kode, dan kategorinya.</p>
        </div>
        <div class="col-md-4 text-end align-self-center">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="bi bi-file-earmark-plus me-2"></i>Tambah Kode
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
                            <th width="5%">No</th>
                            <th width="10%">Kode</th>
                            <th>Deskripsi Tindakan</th>
                            <th>Kategori</th>
                            <th>Kat. Klinis</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kodeTindakan as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><span class="badge bg-secondary font-monospace">{{ $item->kode }}</span></td>
                            <td>{{ $item->deskripsi_tindakan_terapi }}</td>
                            <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                            <td>
                                @if($item->kategoriKlinis)
                                    <span class="badge bg-info text-dark">{{ $item->kategoriKlinis->nama_kategori_klinis }}</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-warning me-1" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editModal"
                                    data-id="{{ $item->idkode_tindakan_terapi }}"
                                    data-kode="{{ $item->kode }}"
                                    data-deskripsi="{{ $item->deskripsi_tindakan_terapi }}"
                                    data-kategori="{{ $item->idkategori }}"
                                    data-klinis="{{ $item->idkategori_klinis }}"
                                    data-url="{{ route('Admin.KodeTindakan.update', $item->idkode_tindakan_terapi) }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                <form action="{{ route('Admin.KodeTindakan.destroy', $item->idkode_tindakan_terapi) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kode tindakan ini?');">
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
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada data kode tindakan.</td>
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
                <h5 class="modal-title fw-bold">Tambah Kode Tindakan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('Admin.KodeTindakan.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Kode (Singkat)</label>
                            <input type="text" class="form-control" name="kode" placeholder="Misal: T01" required>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Deskripsi Layanan</label>
                            <input type="text" class="form-control" name="deskripsi_tindakan_terapi" placeholder="Contoh: Vaksinasi Rabies" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori (Jenis)</label>
                        <select class="form-select" name="idkategori" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategori as $kat)
                                <option value="{{ $kat->idkategori }}">{{ $kat->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori Klinis</label>
                        <select class="form-select" name="idkategori_klinis" required>
                            <option value="">-- Pilih Kategori Klinis --</option>
                            @foreach($kategoriKlinis as $klinis)
                                <option value="{{ $klinis->idkategori_klinis }}">{{ $klinis->nama_kategori_klinis }}</option>
                            @endforeach
                        </select>
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
                <h5 class="modal-title fw-bold">Edit Kode Tindakan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Kode</label>
                            <input type="text" class="form-control" id="edit_kode" name="kode" required>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Deskripsi Layanan</label>
                            <input type="text" class="form-control" id="edit_deskripsi" name="deskripsi_tindakan_terapi" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select class="form-select" id="edit_kategori" name="idkategori" required>
                            @foreach($kategori as $kat)
                                <option value="{{ $kat->idkategori }}">{{ $kat->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori Klinis</label>
                        <select class="form-select" id="edit_klinis" name="idkategori_klinis" required>
                            @foreach($kategoriKlinis as $klinis)
                                <option value="{{ $klinis->idkategori_klinis }}">{{ $klinis->nama_kategori_klinis }}</option>
                            @endforeach
                        </select>
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
            var kode = button.getAttribute('data-kode');
            var deskripsi = button.getAttribute('data-deskripsi');
            var kategori = button.getAttribute('data-kategori');
            var klinis = button.getAttribute('data-klinis');
            var url = button.getAttribute('data-url');
            
            // Isi form
            editModal.querySelector('#edit_kode').value = kode;
            editModal.querySelector('#edit_deskripsi').value = deskripsi;
            editModal.querySelector('#edit_kategori').value = kategori;
            editModal.querySelector('#edit_klinis').value = klinis;
            
            document.getElementById('editForm').action = url;
        });
    });
</script>
@endpush
@endsection
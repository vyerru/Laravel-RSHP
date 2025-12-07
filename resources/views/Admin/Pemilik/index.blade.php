@extends('layouts.app')

@section('title', 'Data Pemilik Hewan')

@section('content')
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="text-primary fw-bold">Data Pemilik</h2>
            <p class="text-muted">Kelola data pemilik hewan (akun & profil).</p>
        </div>
        <div class="col-md-4 text-end align-self-center">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="bi bi-person-vcard me-2"></i>Tambah Pemilik
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
                            <th>Nama Pemilik</th>
                            <th>Email</th>
                            <th>No WA</th>
                            <th>Alamat</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pemilik as $index => $data)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <span class="fw-bold">{{ $data->user->nama ?? '-' }}</span>
                            </td>
                            <td>{{ $data->user->email ?? '-' }}</td>
                            <td>{{ $data->no_wa }}</td>
                            <td>{{Str::limit($data->alamat, 30)}}</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-warning me-1" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editModal"
                                    data-id="{{ $data->idpemilik }}"
                                    data-nama="{{ $data->user->nama ?? '' }}"
                                    data-email="{{ $data->user->email ?? '' }}"
                                    data-wa="{{ $data->no_wa }}"
                                    data-alamat="{{ $data->alamat }}"
                                    data-url="{{ route('Admin.Pemilik.update', $data->idpemilik) }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                <form action="{{ route('Admin.Pemilik.destroy', $data->idpemilik) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pemilik ini? Akun user juga akan dihapus.');">
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
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada data pemilik.</td>
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
                <h5 class="modal-title fw-bold">Tambah Pemilik Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('Admin.Pemilik.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <h6 class="text-primary mb-3"><i class="bi bi-person me-2"></i>Data Akun</h6>
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    
                    <hr>
                    
                    <h6 class="text-primary mb-3"><i class="bi bi-card-text me-2"></i>Data Profil</h6>
                    <div class="mb-3">
                        <label class="form-label">Nomor WhatsApp (HP)</label>
                        <input type="text" class="form-control" name="no_wa" placeholder="08xxx" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat Lengkap</label>
                        <textarea class="form-control" name="alamat" rows="2" required></textarea>
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
                <h5 class="modal-title fw-bold">Edit Data Pemilik</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <h6 class="text-primary mb-3">Data Akun</h6>
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="edit_nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" id="edit_email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password (Opsional)</label>
                        <input type="password" class="form-control" name="password" placeholder="Isi jika ingin ganti password">
                    </div>
                    
                    <hr>
                    
                    <h6 class="text-primary mb-3">Data Profil</h6>
                    <div class="mb-3">
                        <label class="form-label">Nomor WhatsApp</label>
                        <input type="text" class="form-control" id="edit_wa" name="no_wa" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea class="form-control" id="edit_alamat" name="alamat" rows="2" required></textarea>
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
            
            var nama = button.getAttribute('data-nama');
            var email = button.getAttribute('data-email');
            var wa = button.getAttribute('data-wa');
            var alamat = button.getAttribute('data-alamat');
            var url = button.getAttribute('data-url');
            
            editModal.querySelector('#edit_nama').value = nama;
            editModal.querySelector('#edit_email').value = email;
            editModal.querySelector('#edit_wa').value = wa;
            editModal.querySelector('#edit_alamat').value = alamat;
            editModal.querySelector('input[name="password"]').value = ''; // Reset password
            
            document.getElementById('editForm').action = url;
        });
    });
</script>
@endpush
@endsection
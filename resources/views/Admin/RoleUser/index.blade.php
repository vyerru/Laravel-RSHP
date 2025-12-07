@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="text-primary fw-bold">Manajemen User</h2>
            <p class="text-muted">Kelola akun pengguna dan hak akses (Role).</p>
        </div>
        <div class="col-md-4 text-end align-self-center">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="bi bi-person-plus-fill me-2"></i>Tambah User
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Tampilkan Error Validasi jika ada --}}
    @if ($errors->any())
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
                            <th>Nama User</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($roleUser as $index => $data)
                        {{-- Cek apakah user sudah di soft-delete atau belum (jika query default menampilkan deleted) --}}
                        @if($data->user) 
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <span class="fw-bold">{{ $data->user->nama }}</span>
                            </td>
                            <td>{{ $data->user->email }}</td>
                            <td>
                                <span class="badge bg-primary">{{ $data->role->nama_role ?? 'Tidak ada role' }}</span>
                            </td>
                            <td>
                                @if($data->status == 1)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-warning me-1" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editModal"
                                    data-id="{{ $data->idrole_user }}"
                                    data-nama="{{ $data->user->nama }}"
                                    data-email="{{ $data->user->email }}"
                                    data-role="{{ $data->idrole }}"
                                    data-status="{{ $data->status }}"
                                    data-url="{{ route('Admin.RoleUser.update', $data->idrole_user) }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                <form action="{{ route('Admin.RoleUser.destroy', $data->idrole_user) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endif
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada data user.</td>
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
                <h5 class="modal-title fw-bold">Tambah User Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('Admin.RoleUser.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" name="nama" required placeholder="Nama User">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required placeholder="email@contoh.com">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required placeholder="Minimal 6 karakter">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role (Hak Akses)</label>
                        <select class="form-select" name="idrole" required>
                            <option value="">-- Pilih Role --</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->idrole }}">{{ $role->nama_role }}</option>
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
                <h5 class="modal-title fw-bold">Edit Data User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
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
                        <input type="password" class="form-control" name="password" placeholder="Isi hanya jika ingin mengganti password">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah password.</small>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Role</label>
                            <select class="form-select" id="edit_role" name="idrole" required>
                                @foreach($roles as $role)
                                    <option value="{{ $role->idrole }}">{{ $role->nama_role }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status Akun</label>
                            <select class="form-select" id="edit_status" name="status" required>
                                <option value="1">Aktif</option>
                                <option value="0">Nonaktif</option>
                            </select>
                        </div>
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
            var email = button.getAttribute('data-email');
            var roleId = button.getAttribute('data-role');
            var status = button.getAttribute('data-status');
            var url = button.getAttribute('data-url');
            
            // Isi form
            editModal.querySelector('#edit_nama').value = nama;
            editModal.querySelector('#edit_email').value = email;
            editModal.querySelector('#edit_role').value = roleId;
            editModal.querySelector('#edit_status').value = status;
            
            // Reset password field
            editModal.querySelector('input[name="password"]').value = '';

            document.getElementById('editForm').action = url;
        });
    });
</script>
@endpush
@endsection
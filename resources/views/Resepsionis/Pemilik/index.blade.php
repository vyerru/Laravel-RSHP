@extends('layouts.app')
@section('title', 'Data Pemilik')
@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary">Data Pemilik (Klien)</h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddPemilik">
            <i class="bi bi-plus-lg me-1"></i> Pemilik Baru
        </button>
    </div>

    {{-- Search --}}
    <form action="{{ route('Resepsionis.Pemilik.index') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Cari Nama / No WA..." value="{{ request('search') }}">
            <button class="btn btn-outline-secondary" type="submit">Cari</button>
        </div>
    </form>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Tabel --}}
    <div class="card border-0 shadow-sm">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">Nama Pemilik</th>
                    <th>No. WhatsApp</th>
                    <th>Alamat</th>
                    <th class="text-end pe-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pemilik as $p)
                <tr>
                    <td class="ps-4 fw-bold">{{ $p->user->nama ?? '-' }}</td>
                    <td>{{ $p->no_wa }}</td>
                    <td>{{ Str::limit($p->alamat, 40) }}</td>
                    <td class="text-end pe-4">
                        {{-- Tombol Detail untuk mengelola Hewan milik orang ini --}}
                        <a href="{{ route('Resepsionis.Pemilik.show', $p->idpemilik) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-github me-1"></i> Kelola Hewan
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-3">{{ $pemilik->links() }}</div>
    </div>
</div>

{{-- MODAL TAMBAH PEMILIK --}}
<div class="modal fade" id="modalAddPemilik" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold">Registrasi Pemilik Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('Resepsionis.Pemilik.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email (Untuk Login)</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No. WhatsApp</label>
                        <input type="text" name="no_wa" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="2" required></textarea>
                    </div>
                    <div class="alert alert-info small mb-0">
                        <i class="bi bi-info-circle me-1"></i> Password default akun baru adalah: <strong>123456</strong>
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
@endsection
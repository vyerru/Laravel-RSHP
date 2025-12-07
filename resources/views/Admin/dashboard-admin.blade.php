@extends('layouts.app')

@section('title', 'Dashboard Admin - RSHP')

{{-- Push CSS khusus ke stack 'styles' di layout utama --}}
@push('styles')
    <link href="{{ asset('css/admin/menu.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/data-master/data-master.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="container mt-2">
        
        {{-- BAGIAN BARU: Ucapan Selamat Datang & Deskripsi Fitur --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="card bg-primary text-white shadow-sm border-0">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="bi bi-person-circle display-4"></i>
                            </div>
                            <div>
                                {{-- Mengambil nama user yang sedang login --}}
                                <h2 class="fw-bold mb-1">Selamat Datang, {{ Auth::user()->nama }}!</h2>
                                <p class="mb-0 opacity-75">
                                    Anda login sebagai <strong>Administrator</strong>.
                                </p>
                            </div>
                        </div>
                        <hr class="border-white opacity-25 my-3">
                        <p class="mb-0">
                            Sebagai pengelola data master, Anda memiliki akses penuh untuk melakukan operasi 
                            <strong>CRUD (Create, Read, Update, Delete)</strong> pada seluruh data master. 
                            <br>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        {{-- AKHIR BAGIAN BARU --}}

        <div class="row mb-4">
            <div class="col">
                <h2 class="page-title text-primary"><i class="bi bi-database-gear me-2"></i>Data Master</h2>
                <p class="text-muted">Kelola semua data referensi utama sistem di bawah ini.</p>
            </div>
        </div>

        <div class="row g-4">
            {{-- Kartu Data Hewan --}}
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm border-0 hover-card">
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                        <h5 class="card-title mb-0 d-flex align-items-center text-primary">
                            <i class="bi bi-github fs-4 me-2"></i> Data Hewan
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text text-muted small mb-3">Manajemen jenis dan ras hewan peliharaan.</p>
                        <div class="list-group list-group-flush border rounded-3">
                            <a href="{{ route('Admin.jenis-hewan.index') }}" class="list-group-item list-group-item-action py-3 d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-tags me-2 text-secondary"></i> Jenis Hewan</span>
                                <i class="bi bi-chevron-right small text-muted"></i>
                            </a>
                            <a href="{{ route('Admin.RasHewan.index') }}" class="list-group-item list-group-item-action py-3 d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-tag me-2 text-secondary"></i> Ras Hewan</span>
                                <i class="bi bi-chevron-right small text-muted"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kartu Data Pengguna --}}
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm border-0 hover-card">
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                        <h5 class="card-title mb-0 d-flex align-items-center text-success">
                            <i class="bi bi-people fs-4 me-2"></i> Data Pengguna
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text text-muted small mb-3">Manajemen akun user, role, dan data pemilik.</p>
                        <div class="list-group list-group-flush border rounded-3">
                            <a href="{{ route('Admin.RoleUser.index') }}" class="list-group-item list-group-item-action py-3 d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-person me-2 text-secondary"></i> Data User</span>
                                <i class="bi bi-chevron-right small text-muted"></i>
                            </a>
                            <a href="{{ route('Admin.Role.index') }}" class="list-group-item list-group-item-action py-3 d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-person-badge me-2 text-secondary"></i> Manajemen Role</span>
                                <i class="bi bi-chevron-right small text-muted"></i>
                            </a>
                            <a href="{{ route('Admin.Pemilik.index') }}" class="list-group-item list-group-item-action py-3 d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-person-vcard me-2 text-secondary"></i> Data Pemilik</span>
                                <i class="bi bi-chevron-right small text-muted"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kartu Data Medis --}}
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm border-0 hover-card">
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                        <h5 class="card-title mb-0 d-flex align-items-center text-danger">
                            <i class="bi bi-hospital fs-4 me-2"></i> Data Medis
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text text-muted small mb-3">Manajemen kategori dan kode tindakan medis.</p>
                        <div class="list-group list-group-flush border rounded-3">
                            <a href="{{ route('Admin.Kategori.index') }}" class="list-group-item list-group-item-action py-3 d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-bookmark me-2 text-secondary"></i> Data Kategori</span>
                                <i class="bi bi-chevron-right small text-muted"></i>
                            </a>
                            <a href="{{ route('Admin.KategoriKlinis.index') }}" class="list-group-item list-group-item-action py-3 d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-clipboard2-pulse me-2 text-secondary"></i> Data Kat. Klinis</span>
                                <i class="bi bi-chevron-right small text-muted"></i>
                            </a>
                            <a href="{{ route('Admin.KodeTindakan.index') }}" class="list-group-item list-group-item-action py-3 d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-bandaid me-2 text-secondary"></i> Data Kode Terapi</span>
                                <i class="bi bi-chevron-right small text-muted"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
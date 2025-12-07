@extends('layouts.app')



@section('title', 'Data Master - RSHP Admin')

{{-- Push CSS khusus ke stack 'styles' di layout utama --}}
@push('styles')
    <link href="{{ asset('css/admin/menu.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/data-master/data-master.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="container mt-2">
        <div class="row mb-4">
            <div class="col">
                <h2 class="page-title">Data Master</h2>
                <p class="text-muted">Kelola semua data master sistem</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0"><i class="bi bi-github text-primary me-2"></i> Data Hewan</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            {{-- Pastikan route ini ada di web.php --}}
                            <a href="{{ route('Admin.jenis-hewan.index') }}" class="list-group-item list-group-item-action py-3">
                                <i class="bi bi-tags me-2"></i> Jenis Hewan
                            </a>
                            <a href="{{ route('Admin.RasHewan.index') }}" class="list-group-item list-group-item-action py-3">
                                <i class="bi bi-tag me-2"></i> Ras Hewan
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0"><i class="bi bi-people text-success me-2"></i> Data Pengguna</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            {{-- Saya asumsikan nama route untuk data user --}}
                            <a href="{{ route('Admin.RoleUser.index') }}" class="list-group-item list-group-item-action py-3">
                                <i class="bi bi-person me-2"></i> Data User
                            </a>
                            <a href="{{ route('Admin.Role.index') }}" class="list-group-item list-group-item-action py-3">
                                <i class="bi bi-person-badge me-2"></i> Manajemen Role
                            </a>
                            <a href="{{ route('Admin.Pemilik.index') }}" class="list-group-item list-group-item-action py-3">
                                <i class="bi bi-person-vcard me-2"></i> Data Pemilik
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0"><i class="bi bi-hospital text-danger me-2"></i> Data Medis</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            <a href="{{ route('Admin.Kategori.index') }}" class="list-group-item list-group-item-action py-3">
                                <i class="bi bi-bookmark me-2"></i> Data Kategori
                            </a>
                            <a href="{{ route('Admin.KategoriKlinis.index') }}" class="list-group-item list-group-item-action py-3">
                                <i class="bi bi-clipboard2-pulse me-2"></i> Data Kategori Klinis
                            </a>
                            <a href="{{ route('Admin.KodeTindakan.index') }}" class="list-group-item list-group-item-action py-3">
                                <i class="bi bi-bandaid me-2"></i> Data Kode Terapi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
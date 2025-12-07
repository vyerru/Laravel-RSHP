@extends('layouts.app')

@section('title', 'Dashboard Resepsionis - RSHP')

{{-- Menyisipkan stylesheet khusus untuk halaman ini --}}
@push('styles')
    {{-- Pastikan file ini ada di public/css/resepsionis/style.css --}}
    <link href="{{ asset('css/resepsionis/style.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="container mt-2">
        <div class="welcome-card mb-4">
            <h1 class="display-4 mb-3">
                {{-- Mengambil nama user yang sedang login --}}
                <i class="bi bi-person-circle me-3"></i>Selamat Datang, {{ Auth::user()->nama }}!
            </h1>
            <p class="lead mb-0">Kelola registrasi pemilik, pet, dan temu dokter dengan mudah</p>
        </div>

        <div class="row mb-4">
            <div class="col">
                <h3 class="mb-4">Menu Utama</h3>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                {{-- Menggunakan route() helper yang didefinisikan di menu Anda --}}
                <a href="{{ route('resepsionis.registrasi.pemilik') }}" class="text-decoration-none">
                    <div class="card menu-card primary shadow-sm h-100">
                        <div class="card-body">
                            <i class="bi bi-person-plus-fill"></i>
                            <h5>Registrasi Pemilik</h5>
                            <p class="mb-0">Kelola data registrasi pemilik hewan</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="{{ route('resepsionis.registrasi.pet') }}" class="text-decoration-none">
                    <div class="card menu-card success shadow-sm h-100">
                        <div class="card-body">
                            <i class="bi bi-heart-fill"></i>
                            <h5>Registrasi Pet</h5>
                            <p class="mb-0">Kelola data registrasi hewan peliharaan</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="{{ route('resepsionis.temu-dokter.index') }}" class="text-decoration-none">
                    <div class="card menu-card info shadow-sm h-100">
                        <div class="card-body">
                            <i class="bi bi-calendar-check-fill"></i>
                            <h5>Temu Dokter</h5>
                            <p class="mb-0">Kelola jadwal pertemuan dengan dokter</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-3">
                            <i class="bi bi-info-circle-fill text-primary me-2"></i>Informasi
                        </h5>
                        <p class="text-muted mb-0">
                            Sebagai resepsionis, Anda bertanggung jawab untuk mengelola registrasi pemilik hewan,
                            registrasi hewan peliharaan, dan mengatur jadwal pertemuan dengan dokter.
                            Pastikan semua data diinput dengan benar dan lengkap.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
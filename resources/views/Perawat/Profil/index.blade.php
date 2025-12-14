@extends('layouts.app')
@section('title', 'Profil Perawat')
@section('content')
<div class="container py-4">
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="max-width: 800px; margin: 0 auto;">
        <div class="bg-success pt-5 pb-5 text-white text-center" style="background: linear-gradient(135deg, #198754, #20c997);">
            <div class="bg-white p-1 rounded-circle d-inline-block mb-3">
                <img src="https://ui-avatars.com/api/?name={{ $user->nama }}&background=random&size=100" class="rounded-circle">
            </div>
            <h3 class="fw-bold">{{ $user->nama }}</h3>
            <p class="opacity-75">{{ $perawat->pendidikan }}</p>
        </div>
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-md-6">
                    <label class="small text-muted fw-bold">EMAIL</label>
                    <p class="fw-bold">{{ $user->email }}</p>
                </div>
                <div class="col-md-6">
                    <label class="small text-muted fw-bold">NO HP</label>
                    <p class="fw-bold">{{ $perawat->no_hp }}</p>
                </div>
                <div class="col-12">
                    <label class="small text-muted fw-bold">ALAMAT</label>
                    <p class="fw-bold">{{ $perawat->alamat }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
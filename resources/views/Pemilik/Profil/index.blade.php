@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                {{-- Header Profil --}}
                <div class="card-header bg-primary text-white py-4 text-center border-bottom-0">
                    <div class="bg-white p-1 rounded-circle d-inline-block mb-3">
                        <div class="bg-light rounded-circle p-3 text-primary">
                            <i class="bi bi-person-circle" style="font-size: 4rem;"></i>
                        </div>
                    </div>
                    <h4 class="fw-bold mb-1">{{ $user->nama }}</h4>
                    <p class="mb-0 text-white-50">Pemilik Hewan (Klien)</p>
                </div>
                
                {{-- Detail Informasi --}}
                <div class="card-body p-4">
                    <h6 class="fw-bold text-primary mb-3 text-uppercase small ls-1">Informasi Kontak</h6>
                    
                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                            <span class="text-muted"><i class="bi bi-envelope me-2"></i>Email</span>
                            <span class="fw-bold text-dark">{{ $user->email }}</span>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                            <span class="text-muted"><i class="bi bi-whatsapp me-2"></i>No. WhatsApp</span>
                            <span class="fw-bold text-dark">{{ $pemilik->no_wa }}</span>
                        </li>
                    </ul>

                    <h6 class="fw-bold text-primary mb-3 text-uppercase small ls-1">Alamat Domisili</h6>
                    <div class="bg-light p-3 rounded border">
                        <p class="mb-0 text-muted">
                            <i class="bi bi-geo-alt-fill me-2 text-danger"></i>
                            {{ $pemilik->alamat }}
                        </p>
                    </div>
                </div>

                {{-- Footer (Tombol Logout Opsional) --}}
                <div class="card-footer bg-white p-4 text-center">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="bi bi-box-arrow-right me-1"></i> Keluar Aplikasi
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
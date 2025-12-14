<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('Perawat.Dashboard.index') ? 'active' : '' }}" 
       href="{{ route('Perawat.Dashboard.index') }}">
        <i class="bi bi-speedometer2 me-1"></i> Dashboard
    </a>
</li>

<li class="nav-item">
    {{-- Menggunakan wildcard (*) agar menu tetap aktif saat membuka form input atau detail --}}
    <a class="nav-link {{ request()->routeIs('Perawat.Pemeriksaan.*') ? 'active' : '' }}" 
       href="{{ route('Perawat.Pemeriksaan.index') }}">
        <i class="bi bi-clipboard2-pulse me-1"></i> Pemeriksaan Awal
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('Perawat.Pasien.*') ? 'active' : '' }}" 
       href="{{ route('Perawat.Pasien.index') }}">
        <i class="bi bi-heart-pulse me-1"></i> Data Pasien
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('Perawat.Profil.index') ? 'active' : '' }}" 
       href="{{ route('Perawat.Profil.index') }}">
        <i class="bi bi-person-circle me-1"></i> Profil Saya
    </a>
</li>
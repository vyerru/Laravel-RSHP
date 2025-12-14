<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('Resepsionis.Dashboard.index') ? 'active' : '' }}" 
       href="{{ route('Resepsionis.Dashboard.index') }}">
        <i class="bi bi-speedometer2 me-1"></i> Dashboard
    </a>
</li>

<li class="nav-item">
    {{-- Menggunakan wildcard (*) agar menu tetap aktif saat membuka halaman Detail Pemilik --}}
    <a class="nav-link {{ request()->routeIs('Resepsionis.Pemilik.*') ? 'active' : '' }}" 
       href="{{ route('Resepsionis.Pemilik.index') }}">
        <i class="bi bi-people-fill me-1"></i> Pasien & Pemilik
    </a>
</li>
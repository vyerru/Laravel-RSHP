<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('Pemilik.Dashboard.index') ? 'active' : '' }}" 
       href="{{ route('Pemilik.Dashboard.index') }}">
        <i class="bi bi-house-door me-1"></i> Beranda
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('Pemilik.Hewan.*') ? 'active' : '' }}" 
       href="{{ route('Pemilik.Hewan.index') }}">
        <i class="bi bi-github me-1"></i> Hewan Saya
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('Pemilik.Profil.*') ? 'active' : '' }}" 
       href="{{ route('Pemilik.Profil.index') }}">
        <i class="bi bi-person-circle me-1"></i> Profil
    </a>
</li>
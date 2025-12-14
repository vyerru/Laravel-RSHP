<li class="nav-item">
    <a class="nav-link {{ Route::is('Dokter.Dashboard.index') ? 'active fw-bold text-primary' : '' }}" href="{{ route('Dokter.Dashboard.index') }}">
        <i class="bi bi-grid-fill me-1"></i> Dashboard
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ Route::is('Dokter.Pasien.#') ? 'active fw-bold text-primary' : '' }}" href="{{ route('Dokter.Pasien.index') }}"></a>
        <i class="bi bi-heart-pulse me-1"></i> Data Pasien
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ Route::is('Dokter.RekamMedis.*') ? 'active fw-bold text-primary' : '' }}" href="{{ route('Dokter.RekamMedis.index') }}"></a>
        <i class="bi bi-file-medical me-1"></i> Rekam Medis
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ Route::is('Dokter.Profil.*') ? 'active fw-bold text-primary' : '' }}" href="{{ route('Dokter.Profil.index') }}"></a>
        <i class="bi bi-person-badge me-1"></i> Profil Saya
    </a>
</li>
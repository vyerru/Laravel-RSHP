<!-- Menu Khusus Admin -->
<li class="nav-item">
    <a class="nav-link" href="{{ route('Admin.dashboard') }}">
        <i class="bi bi-house-door"></i> Dashboard
    </a>
</li>

<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
        <i class="bi bi-database-gear"></i> Data Master
    </a>
    <ul class="dropdown-menu">
        <!-- Group: Master Hewan -->
        <li><h6 class="dropdown-header">Master Hewan</h6></li>
        <li><a class="dropdown-item" href="{{ route('Admin.jenis-hewan.index') }}">Jenis Hewan</a></li>
        <li><a class="dropdown-item" href="{{ route('Admin.RasHewan.index') }}">Ras Hewan</a></li>
        <li><a class="dropdown-item" href="{{ route('Admin.Pet.index') }}">Data Pet</a></li>
        
        <li><hr class="dropdown-divider"></li>
        
        <!-- Group: Data Pengguna -->
        <li><h6 class="dropdown-header">Data Pengguna</h6></li>
        <li><a class="dropdown-item" href="{{ route('Admin.RoleUser.index') }}">Data User</a></li>
        <li><a class="dropdown-item" href="{{ route('Admin.Role.index') }}">Manajemen Role</a></li>
        <li><a class="dropdown-item" href="{{ route('Admin.Pemilik.index') }}">Data Pemilik</a></li>
        
        <li><hr class="dropdown-divider"></li>
        
        <!-- Group: Master Medis -->
        <li><h6 class="dropdown-header">Master Medis</h6></li>
        <li><a class="dropdown-item" href="{{ route('Admin.Kategori.index') }}">Kategori</a></li>
        <li><a class="dropdown-item" href="{{ route('Admin.KategoriKlinis.index') }}">Kategori Klinis</a></li>
        <li><a class="dropdown-item" href="{{ route('Admin.KodeTindakan.index') }}">Kode Terapi</a></li>
    </ul>
</li>

<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
        <i class="bi bi-clipboard-data"></i> Data Transaksional
    </a>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="{{ route('Admin.TemuDokter.index') }}">Pendaftaran / Reservasi</a></li>
        <li><a class="dropdown-item" href="{{ route('Admin.RekamMedis.index') }}">Rekam Medis</a></li>
    </ul>
</li>
<!-- Menu Khusus Admin -->
<li class="nav-item">
    <a class="nav-link" href="{{ route('Admin.dashboard') }}">
        <i class="bi bi-house-door"></i> Dashboard
    </a>
</li>
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
        <i class="bi bi-folder"></i> Data Master
    </a>
    <!-- Pastikan <ul> ini ditutup dengan </ul> -->
    <ul class="dropdown-menu"> 
        <li><a class="dropdown-item" href="{{ route('Admin.data-user.index') }}">Data User</a></li>
        <li><a class="dropdown-item" href="{{ route('Admin.manajemen-role.index') }}">Manajemen Role</a></li>
        <li><a class="dropdown-item" href="{{ route('Admin.jenis-hewan.index') }}">Jenis Hewan</a></li>
        <li><a class="dropdown-item" href="{{ route('Admin.ras-hewan.index') }}">Ras Hewan</a></li>
    </ul>
</li>
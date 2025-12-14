@extends('layouts.app')

@section('title', 'Data Hewan Peliharaan')

@section('content')
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="text-primary fw-bold">Data Hewan Peliharaan</h2>
            <p class="text-muted">Kelola data pasien hewan yang terdaftar.</p>
        </div>
        <div class="col-md-4 text-end align-self-center">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="bi bi-github me-2"></i>Tambah Hewan
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Hewan</th>
                            <th>Warna Tanda</th>
                            <th>Jenis</th>
                            <th>Ras Hewan</th>
                            <th>Pemilik</th>
                            <th>Umur / Lahir</th>
                            <th>Kelamin</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pets as $index => $pet)
                        <tr>
                            <td class="fw-bold">{{ $index + 1 }}</td>
                            <td>
                                <span>{{ $pet->nama }}</span><br>
                            </td>
                            <td>
                                <span>{{ $pet->warna_tanda }}</span>
                            </td>
                            <td>
                                {{ $pet->rasHewan->nama_ras ?? '-' }} <br>
                            </td>
                            <td>
                                <span>
                                    {{ $pet->rasHewan->jenisHewan->nama_jenis_hewan ?? '-' }}
                                </span>
                            </td>
                            <td>
                                <i class="bi bi-person-circle me-1 text-secondary"></i>
                                {{ $pet->pemilik->user->nama ?? 'Tanpa Pemilik' }}
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($pet->tanggal_lahir)->format('d M Y') }}
                                <br><small class="text-muted">({{ \Carbon\Carbon::parse($pet->tanggal_lahir)->age }} thn)</small>
                            </td>
                            <td>
                                @if(strtolower($pet->jenis_kelamin) == 'j')
                                    <span class="badge bg-primary">Jantan</span>
                                @else
                                    <span class="badge bg-danger">Betina</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-warning me-1" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editModal"
                                    data-id="{{ $pet->idpet }}"
                                    data-nama="{{ $pet->nama }}"
                                    data-lahir="{{ $pet->tanggal_lahir }}"
                                    data-warna="{{ $pet->warna_tanda }}"
                                    data-kelamin="{{ strtolower($pet->jenis_kelamin) }}"
                                    data-pemilik="{{ $pet->idpemilik }}"
                                    data-ras="{{ $pet->idras_hewan }}"
                                    data-url="{{ route('Admin.Pet.update', $pet->idpet) }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                <form action="{{ route('Admin.Pet.destroy', $pet->idpet) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data hewan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Belum ada data hewan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- MODAL CREATE --}}
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Tambah Hewan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('Admin.Pet.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Hewan</label>
                            <input type="text" class="form-control" name="nama" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Warna / Tanda Khusus</label>
                            <input type="text" class="form-control" name="warna_tanda" placeholder="Contoh: Belang tiga, putih polos" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" name="tanggal_lahir" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <select class="form-select" name="jenis_kelamin" required>
                                <option value="j">Jantan</option>
                                <option value="b">Betina</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pemilik</label>
                        <select class="form-select" name="idpemilik" required>
                            <option value="">-- Pilih Pemilik --</option>
                            @foreach($pemilik as $p)
                                <option value="{{ $p->idpemilik }}">{{ $p->user->nama ?? '-' }} ({{ $p->no_wa }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ras Hewan</label>
                        <select class="form-select" name="idras_hewan" required>
                            <option value="">-- Pilih Ras --</option>
                            @foreach($rasHewan as $ras)
                                <option value="{{ $ras->idras_hewan }}">
                                    {{ $ras->jenisHewan->nama_jenis_hewan ?? '' }} - {{ $ras->nama_ras }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL EDIT --}}
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Edit Data Hewan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Hewan</label>
                            <input type="text" class="form-control" id="edit_nama" name="nama" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Warna / Tanda</label>
                            <input type="text" class="form-control" id="edit_warna" name="warna_tanda" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="edit_lahir" name="tanggal_lahir" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <select class="form-select" id="edit_kelamin" name="jenis_kelamin" required>
                                <option value="j">Jantan</option>
                                <option value="b">Betina</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pemilik</label>
                        <select class="form-select" id="edit_pemilik" name="idpemilik" required>
                            @foreach($pemilik as $p)
                                <option value="{{ $p->idpemilik }}">{{ $p->user->nama ?? '-' }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ras Hewan</label>
                        <select class="form-select" id="edit_ras" name="idras_hewan" required>
                            @foreach($rasHewan as $ras)
                                <option value="{{ $ras->idras_hewan }}">
                                    {{ $ras->jenisHewan->nama_jenis_hewan ?? '' }} - {{ $ras->nama_ras }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var editModal = document.getElementById('editModal');
        editModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            
            // Ambil data dari tombol edit
            var nama = button.getAttribute('data-nama');
            var lahir = button.getAttribute('data-lahir');
            var warna = button.getAttribute('data-warna');
            var kelamin = button.getAttribute('data-kelamin');
            var pemilik = button.getAttribute('data-pemilik');
            var ras = button.getAttribute('data-ras');
            var url = button.getAttribute('data-url');
            
            // Isi form
            editModal.querySelector('#edit_nama').value = nama;
            editModal.querySelector('#edit_lahir').value = lahir;
            editModal.querySelector('#edit_warna').value = warna;
            editModal.querySelector('#edit_kelamin').value = kelamin;
            editModal.querySelector('#edit_pemilik').value = pemilik;
            editModal.querySelector('#edit_ras').value = ras;
            
            document.getElementById('editForm').action = url;
        });
    });
</script>
@endpush
@endsection
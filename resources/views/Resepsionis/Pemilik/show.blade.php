@extends('layouts.app')

@section('title', 'Detail Pemilik & Hewan')

@section('content')
    <div class="container py-4">
        <div class="mb-4">
            <a href="{{ route('Resepsionis.Pemilik.index') }}" class="text-decoration-none text-muted">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Pemilik
            </a>
        </div>

        {{-- Info Pemilik --}}
        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary me-3">
                            <i class="bi bi-person-vcard fs-3"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-1">{{ $pemilik->user->nama }}</h4>
                            <p class="text-muted mb-0"><i class="bi bi-whatsapp me-1"></i> {{ $pemilik->no_wa }}</p>
                            <small class="text-muted"><i class="bi bi-geo-alt me-1"></i> {{ $pemilik->alamat }}</small>
                        </div>
                    </div>
                    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#modalEditPemilik">
                        <i class="bi bi-pencil me-1"></i> Edit Profil
                    </button>
                </div>
            </div>
        </div>

        {{-- Daftar Hewan --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold text-dark mb-0">Daftar Hewan Peliharaan</h5>
            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalAddPet">
                <i class="bi bi-plus-lg me-1"></i> Tambah Hewan
            </button>
        </div>

        <div class="row g-3">
            @forelse($pemilik->pets as $pet)
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <h5 class="fw-bold text-success mb-0">{{ $pet->nama }}</h5>
                                @if($pet->jenis_kelamin == 'J')
                                    <span class="badge bg-primary"><i class="bi bi-gender-male"></i> Jantan</span>
                                @else
                                    <span class="badge bg-danger"><i class="bi bi-gender-female"></i> Betina</span>
                                @endif
                            </div>
                            <p class="text-muted small mb-1">
                                {{ $pet->rasHewan->nama_ras ?? '-' }}
                                ({{ $pet->rasHewan->jenisHewan->nama_jenis_hewan ?? '-' }})
                            </p>
                            <p class="text-muted small mb-3">
                                Umur: {{ \Carbon\Carbon::parse($pet->tanggal_lahir)->age }} Thn | Warna: {{ $pet->warna_tanda }}
                            </p>

                            <hr>

                            <div class="d-grid">
                                <button class="btn btn-primary" {{-- Tambahkan 2 baris ini agar modal otomatis terbuka oleh
                                    Bootstrap --}} data-bs-toggle="modal" data-bs-target="#modalDaftar" {{-- Biarkan ini untuk
                                    mengisi data ke dalam modal --}}
                                    onclick="isiDataModal('{{ $pet->idpet }}', '{{ $pet->nama }}')">
                                    <i class="bi bi-calendar-plus me-1"></i> Daftar Berobat
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-warning text-center">
                        Belum ada data hewan. Silakan tambahkan hewan terlebih dahulu.
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    {{-- ================= MODAL TAMBAH HEWAN ================= --}}
    <div class="modal fade" id="modalAddPet" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold">Tambah Hewan Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('Resepsionis.Pet.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="idpemilik" value="{{ $pemilik->idpemilik }}">

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nama Hewan</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label small fw-bold">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-select" required>
                                    <option value="J">Jantan</option>
                                    <option value="B">Betina</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold">Tanggal Lahir (Kira-kira)</label>
                                <input type="date" name="tanggal_lahir" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Ras / Jenis</label>
                            <select name="idras_hewan" class="form-select" required>
                                <option value="">-- Pilih Ras --</option>
                                @foreach($rasHewan as $ras)
                                    <option value="{{ $ras->idras_hewan }}">
                                        {{ $ras->jenisHewan->nama_jenis_hewan }} - {{ $ras->nama_ras }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Warna / Ciri Fisik</label>
                            <input type="text" name="warna_tanda" class="form-control"
                                placeholder="Contoh: Putih belang hitam">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan Data Hewan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ================= MODAL EDIT PEMILIK ================= --}}
    <div class="modal fade" id="modalEditPemilik" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold">Edit Profil Pemilik</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('Resepsionis.Pemilik.update', $pemilik->idpemilik) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" value="{{ $pemilik->user->nama }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No. WhatsApp</label>
                            <input type="text" name="no_wa" class="form-control" value="{{ $pemilik->no_wa }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="2" required>{{ $pemilik->alamat }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ================= MODAL PENDAFTARAN (APPOINTMENT) ================= --}}
    <div class="modal fade" id="modalDaftar" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold"><i class="bi bi-clipboard-plus me-2"></i>Pendaftaran Berobat</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('Resepsionis.TemuDokter.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="idpet" id="input_idpet">

                        <div class="alert alert-info d-flex align-items-center">
                            <i class="bi bi-info-circle fs-4 me-3"></i>
                            <div>
                                Mendaftarkan pasien <strong id="label_nama_pet"></strong> untuk pemeriksaan hari ini.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Pilih Dokter Tujuan</label>
                            <select name="idrole_user" class="form-select" required>
                                <option value="">-- Pilih Dokter --</option>
                                @foreach($dokterList as $d)
                                    <option value="{{ $d->idrole_user }}">Dr. {{ $d->user->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary fw-bold">Daftarkan Sekarang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Ganti nama fungsi biar lebih sesuai, misal "isiDataModal"
        function isiDataModal(idPet, namaPet) {
            // 1. Isi Hidden Input ID Pet
            document.getElementById('input_idpet').value = idPet;

            // 2. Ganti Teks Nama Hewan di Info
            document.getElementById('label_nama_pet').innerText = namaPet;

            // KITA HAPUS BAGIAN "new bootstrap.Modal(...)" 
            // Karena modal sudah terbuka otomatis lewat data-bs-target di tombol
        }
    </script>
@endsection
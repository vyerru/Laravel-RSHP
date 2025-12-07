<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSHP Unair - Rumah Sakit Hewan Pendidikan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Menggunakan asset() untuk memuat CSS dari folder public --}}
    <link href="{{ asset('css/style.css') }}" rel="stylesheet"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow-sm" style="background-color: #005590;">
    <div class="container">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="{{ route('index') }}">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/layanan') }}">Layanan</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Tentang</a></li>
          
          {{-- LOGIKA DINAMIS DIMULAI DI SINI --}}
          @guest
            {{-- Tampilkan ini HANYA jika pengguna BELUM login --}}
            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
          @else
            {{-- Tampilkan ini HANYA jika pengguna SUDAH login --}}
            
            {{-- Ambil role dan ubah ke huruf kecil --}}
            @php( $role = strtolower(trim(Auth::user()->role)) )

            {{-- Arahkan ke dashboard yang sesuai --}}
            @if ($role == 'admin')
                <li class="nav-item"><a class="nav-link" href="{{ route('Admin.dashboard') }}">Dashboard</a></li>
            @elseif ($role == 'dokter')
                <li class="nav-item"><a class="nav-link" href="{{ route(name: 'Dokter.Dashboard.index') }}">Dashboard</a></li>
            @elseif ($role == 'resepsionis')
                <li class="nav-item"><a class="nav-link" href="{{ route('resepsionis.dashboard') }}">Dashboard</a></li>
            @elseif ($role == 'perawat')
                <li class="nav-item"><a class="nav-link" href="{{ route('Perawat.Dashboard.index') }}">Dashboard</a></li>
            @elseif ($role == 'pemilik')
                <li class="nav-item"><a class="nav-link" href="{{ route('Pemilik.Dashboard.index') }}">Dashboard</a></li>
            @else
                {{-- Fallback jika role tidak dikenal --}}
                <li class="nav-item"><a class="nav-link" href="/home">Dashboard</a></li>
            @endif

            {{-- Tambahkan tombol Logout --}}
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                 document.getElementById('logout-form-public').submit();">
                    Logout
                </a>
                <form id="logout-form-public" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
          @endguest
          {{-- LOGIKA DINAMIS SELESAI --}}

        </ul>
      </div>
    </div>
  </nav>

  <header class="py-2 my-2" style="margin-top: 56px;"> {{-- Menambahkan margin-top agar tidak tertutup navbar --}}
    <div class="container">
      {{-- Ganti path gambar menggunakan asset() --}}
      <img src="{{ asset('Css/Gambar/Header RSHP.webp') }}" class="img-fluid w-100 rounded shadow" alt="RSHP Header Image">
    </div>
  </header>

  <div class="container my-1">
    <section id="about" class="mb-5 py-5">
      <div class="row align-items-center g-5">
        <div class="col-lg-6">
          <h2 class="section-title text-start">Profil RSHP Unair</h2>
          <div class="video-container shadow rounded overflow-hidden">
            <iframe src="https://www.youtube.com/embed/rCfvZPECZvE" title="YouTube video player"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
              allowfullscreen></iframe>
          </div>
        </div>
        <div class="col-lg-6">
          <h3>Tentang Kami</h3>
          <p class="text-justify">
            Rumah Sakit Hewan Pendidikan Universitas Airlangga berinovasi untuk selalu meningkatkan kualitas pelayanan.
            Oleh karena itu, kami menyediakan fitur pendaftaran online yang mempermudah Anda untuk mendaftarkan hewan
            kesayangan.
          </p>
          <div class="text-center mt-3">
            {{-- Logika dinamis untuk tombol daftar --}}
            @guest
                <a href="{{ route('login') }}" class="btn btn-primary">Daftar Online Sekarang</a>
            @else
                <a href="#" class="btn btn-secondary disabled">Anda sudah login</a>
            @endguest
          </div>
        </div>
      </div>
    </section>

    <section id="latest-news" class="py-5 bg-light rounded">
      <div class="container">
        <h2 class="section-title">Berita Terbaru</h2>
        <div class="row g-4">
          <div class="col-md-6 col-lg-4">
            <div class="card h-100">
              {{-- Ganti path gambar menggunakan asset() --}}
              <img src="{{ asset('Css/Gambar/open_recruit.png') }}" class="card-img-top" alt="Rekrutmen Staf">
              <div class="card-body">
                <h5 class="card-title">Open Recruit Staf RSHP Unair</h5>
                <p class="card-text text-muted"><small>1 June 2025</small></p>
                <p class="card-text">Kami membuka kesempatan bagi para profesional untuk bergabung dengan tim
                  administrasi perkantoran kami.</p>
              </div>
              <div class="card-footer bg-white border-0">
                <a href="#" class="text-decoration-none">Read more...</a>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-4">
            <div class="card h-100">
              <img src="{{ asset('Css/Gambar/senam_juara.jpg') }}" class="card-img-top" alt="Tim Satu Sehat">
              <div class="card-body">
                <h5 class="card-title">Tim Satu Sehat, Juara 1 Senam Bugar Airlangga</h5>
                <p class="card-text text-muted"><small>4 November 2024</small></p>
                <p class="card-text">Tim kolaborasi RSHP, Rumah Sakit Gigi dan Mulut, meraih juara pertama dalam
                  kompetisi senam bugar.</p>
              </div>
              <div class="card-footer bg-white border-0">
                <a href="#" class="text-decoration-none">Read more...</a>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-4">
            <div class="card h-100">
              <img src="{{ asset('Css/Gambar/seminar_workshop.webp') }}" class="card-img-top" alt="Workshop Sitologi">
              <div class="card-body">
                <h5 class="card-title">Seminar & Workshop Sitologi RSHP 2024</h5>
                <p class="card-text text-muted"><small>27 August 2024</small></p>
                <p class="card-text">Workshop mengenai Cytological And Histopathological Quantitative Measurement untuk
                  para praktisi.</p>
              </div>
              <div class="card-footer bg-white border-0">
                <a href="#" class="text-decoration-none">Read more...</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

  </div>

  <footer class="bg-dark text-white text-center py-4 mt-5">
    <div class="container">
      <p class="mb-0">&copy; 2025 RSHP Universitas Airlangga. All Rights Reserved.</p>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
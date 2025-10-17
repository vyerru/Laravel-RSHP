<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSHP Unair - Rumah Sakit Hewan Pendidikan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/style.css" rel="stylesheet">
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow-sm" style="background-color: #005590;">
    <div class="container">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Layanan</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Tentang</a></li>
          <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <header class="py-2 my-2">
    <div class="container">
      <img src="Css\Gambar\Header RSHP.webp" class="img-fluid w-100 rounded shadow" alt="RSHP Header Image">
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
            <a href="login.php" class="btn btn-primary">Daftar Online Sekarang</a>
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
              <img src="Css\Gambar\open_recruit.png" class="card-img-top" alt="Rekrutmen Staf">
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
              <img src="Css\Gambar\senam_juara.jpg" class="card-img-top" alt="Tim Satu Sehat">
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
              <img src="Css\Gambar\seminar_workshop.webp" class="card-img-top" alt="Workshop Sitologi">
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

</body>

</html>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>

  <link rel="stylesheet" href="{{ asset('css/app_footer.css') }}">

  <style>
    body {
      background-color: #f0f4f8;
      margin: 0;
      font-family: 'Poppins', sans-serif;
    }

    .banner {
      height: 420px;
      background: url('{{ asset('asset/latarbelakang.png') }}') center/cover no-repeat;
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      text-align: center;
    }

    .banner::before {
      content: "";
      position: absolute;
      inset: 0;
      background: rgba(0,0,0,.45);
    }

    .banner-content {
      position: relative;
      z-index: 1;
      max-width: 700px;
    }

    .banner-content h1 {
      font-size: 42px;
      margin-bottom: 12px;
    }

   .dashboard {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        padding: 40px 60px;
        margin-bottom: 60px; 
    }


    .card {
      background: #fff;
      border-radius: 14px;
      padding: 22px;
      text-align: center;
      text-decoration: none;
      color: #333;
      box-shadow: 0 4px 8px rgba(0,0,0,.1);
      transition: .3s;
    }

    .card:hover {
      transform: translateY(-6px);
      box-shadow: 0 10px 18px rgba(0,0,0,.15);
    }

    .card h3 {
      margin-bottom: 8px;
      font-size: 16px;
    }

    .card p {
      font-size: 13px;
      color: #666;
    }
  </style>
</head>

<body>
<header class="appbar">
  <div class="left">
    <img src="{{ asset('asset/logo2.png') }}" class="logo">
  </div>
  <div class="profile">
    <img src="{{ asset('asset/mat.jpg') }}" class="avatar">
    <span>User Name</span>
  </div>
</header>
<section class="banner">
  <div class="banner-content">
    <h1>Selamat Datang di MyBerikan!</h1>
    <p>
      Kelola data karyawan, logistik, meeting, maintenance,
      dan produk dalam satu sistem terintegrasi.
    </p>
  </div>
</section>
<div class="dashboard">
  <a href="/karyawan" class="card">
    <h3>Data Karyawan</h3>
    <p>Kelola informasi dan status karyawan</p>
  </a>

  <a href="/logistik" class="card">
    <h3>Data Logistik</h3>
    <p>Pantau stok dan distribusi barang</p>
  </a>

  <a href="/meetings" class="card">
    <h3>Jadwal Meeting</h3>
    <p>Atur agenda meeting</p>
  </a>

  <a href="/maintenance" class="card">
    <h3>Maintenance</h3>
    <p>Kelola perawatan aset</p>
  </a>

  <a href="/produk" class="card">
    <h3>Data Produk</h3>
    <p>Kelola hasil produk</p>
  </a>
</div>
<footer>
  © 2025 PT Berikan Teknologi Indonesia
</footer>

</body>
</html>

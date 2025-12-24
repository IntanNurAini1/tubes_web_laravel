<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Logistik</title>

    <!-- ===== STYLE ===== -->
    <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #f5f7fa;
      color: #333;
    }

    .appbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: #ffffff;
      padding: 12px 32px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.05);
      position: sticky;
      top: 0;
      z-index: 1000;
    }

    .appbar .logo img {
      height: 50px;
    }

    .appbar .profile {
      display: flex;
      align-items: center;
      background-color: #007bff;
      color: #fff;
      padding: 6px 12px;
      border-radius: 25px;
    }

    .avatar {
      width: 28px;
      height: 28px;
      border-radius: 50%;
      overflow: hidden;
      background-color: #fff;
      margin-right: 8px;
    }

    .avatar img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .container {
      max-width: 1200px;
      margin: 40px auto;
      padding: 0 20px;
    }

    .header-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .toolbar {
      display: flex;
      gap: 10px;
    }

    .toolbar input {
      padding: 10px 14px;
      border: 1px solid #d0d0d0;
      border-radius: 8px;
      width: 260px;
    }

    .toolbar button {
      background-color: #4189d4;
      color: white;
      border: none;
      padding: 10px 18px;
      border-radius: 8px;
      cursor: pointer;
    }

    .product-table {
      width: 100%;
      background-color: #fff;
      border-radius: 12px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
      border-collapse: collapse;
    }

    .product-table th {
      background-color: #f3f6fb;
      padding: 14px;
    }

    .product-table td {
      padding: 14px;
      border-bottom: 1px solid #eee;
    }

    .btnEdit {
      background-color: #f8f872;
      border: none;
      padding: 6px 16px;
      border-radius: 6px;
      cursor: pointer;
    }

    .btnHapus {
      background-color: #ea7163;
      border: none;
      padding: 6px 14px;
      border-radius: 6px;
      color: white;
      cursor: pointer;
    }

    /* ===== POPUP ===== */
    .popup {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0,0,0,0.3);
      justify-content: center;
      align-items: center;
      z-index: 2000;
    }

    .popup-content {
      background: #ffffff;
      padding: 25px 30px;
      border-radius: 12px;
      width: 360px;
      text-align: left;
    }

    .popup-content.small {
      width: 280px;
      text-align: center;
    }

    /* INPUT & SELECT SERAGAM */
    .popup-content input,
    .popup-content select {
      width: 100%;
      margin-bottom: 12px;
      padding: 10px 12px;
      border: 1px solid #d0d0d0;
      border-radius: 8px;
      font-size: 14px;
      background-color: #ffffff;
      box-sizing: border-box;
    }

    .popup-content select {
      appearance: none;
      background-image: url("data:image/svg+xml,%3Csvg fill='gray' height='20' viewBox='0 0 20 20' width='20' xmlns='http://www.w3.org/2000/svg'%3E%3Cpolygon points='0,0 20,0 10,10'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 12px center;
      background-size: 10px;
    }

    /* BUTTON POPUP */
    .popup-buttons {
      display: flex;
      gap: 10px;
      margin-top: 10px;
    }

    .popup-buttons button {
      flex: 1;
      padding: 12px 0;
      font-size: 15px;
      font-weight: 600;
      border-radius: 8px;
      border: none;
      cursor: pointer;
    }

    /* SIMPAN / UPDATE */
    .popup-buttons button[type="submit"],
    .popup-buttons button:not([type]) {
      background-color: #4189d4;
      color: #fff;
    }

    /* BATAL */
    .popup-buttons button[type="button"] {
      background-color: #e0e0e0;
      color: #333;
    }

    footer {
      position: fixed;
      bottom: 0;
      width: 100%;
      text-align: center;
      padding: 15px 0;
      background-color: #007bff;
      color: white;
    }
</style>
</head>

<body>

<!-- ===== APPBAR ===== -->
<header class="appbar">
    <div class="logo">
        <img src="{{ asset('asset/logo2.png') }}">
    </div>

    <div class="profile">
        <div class="avatar">
            <img src="{{ asset('asset/mat.jpg') }}">
        </div>
        <span>User Name</span>
    </div>
</header>

<!-- ===== CONTENT ===== -->
<main class="container">

    <div class="header-bar">
        <h2>Data Logistik</h2>
        <div class="toolbar">
            <input id="searchInput" placeholder="Cari Berdasarkan Kode atau Nama...">
            <button onclick="openTambah()">Tambah Logistik</button>
        </div>
    </div>

    <table class="product-table">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @foreach($logistik as $l)
            <tr>
                <td>{{ $l['kode'] }}</td>
                <td>{{ $l['nama'] }}</td>
                <td>{{ $l['jumlah'] }}</td>
                <td>{{ $l['status'] }}</td>
                <td>Rp {{ number_format($l['harga'],0,',','.') }}</td>
                <td>
                    <button class="btnEdit"
                        onclick="openEdit('{{ $l['id'] }}','{{ $l['kode'] }}','{{ $l['nama'] }}','{{ $l['jumlah'] }}','{{ $l['status'] }}','{{ $l['harga'] }}')">
                        Edit
                    </button>
                    <button class="btnHapus" onclick="openDelete('{{ $l['id'] }}')">
                        Hapus
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</main>

<!-- ===== POPUP TAMBAH ===== -->
<div class="popup" id="popupTambah">
    <div class="popup-content">
        <h3>Tambah Logistik</h3>
        <form action="/logistik" method="POST">
            @csrf
            <input name="kode" placeholder="Kode">
            <input name="nama" placeholder="Nama">
            <input type="number" name="jumlah" placeholder="Jumlah">
            <select name="status">
                <option>Tersedia</option>
                <option>Kosong</option>
                <option>Dalam Pengiriman</option>
            </select>
            <input type="number" name="harga" placeholder="Harga">
            <div class="popup-buttons">
                <button>Simpan</button>
                <button type="button" onclick="closeAll()">Batal</button>
            </div>
        </form>
    </div>
</div>

<!-- ===== POPUP EDIT ===== -->
<div class="popup" id="popupEdit">
    <div class="popup-content">
        <h3>Edit Logistik</h3>
        <form method="POST" id="formEdit">
            @csrf
            @method('PUT')
            <input id="e_kode" name="kode">
            <input id="e_nama" name="nama">
            <input type="number" id="e_jumlah" name="jumlah">
           <select id="e_status" name="status">
    <option value="Tersedia">Tersedia</option>
    <option value="Kosong">Kosong</option>
    <option value="Dalam Pengiriman">Dalam Pengiriman</option>
</select>
            <input type="number" id="e_harga" name="harga">
            <div class="popup-buttons">
                <button>Update</button>
                <button type="button" onclick="closeAll()">Batal</button>
            </div>
        </form>
    </div>
</div>

<!-- ===== POPUP DELETE ===== -->
<div class="popup" id="popupDelete">
    <div class="popup-content small">
        <h4>Hapus Data?</h4>
        <div class="popup-buttons">
            <button onclick="hapus()">Ya</button>
            <button onclick="closeAll()">Batal</button>
        </div>
    </div>
</div>

<footer>
    © 2025 PT Berikan Teknologi Indonesia ~ Data Logistik
</footer>

<!-- ===== SCRIPT ===== -->
<script>
let selectedId = '';

function openTambah(){
    popupTambah.style.display='flex';
}

function openEdit(id,kode,nama,jumlah,status,harga){
    selectedId = id;
    formEdit.action = '/logistik/' + id;
    e_kode.value = kode;
    e_nama.value = nama;
    e_jumlah.value = jumlah;
    e_status.value = status;
    e_harga.value = harga;
    popupEdit.style.display='flex';
}

function openDelete(id){
    selectedId = id;
    popupDelete.style.display='flex';
}

function hapus(){
    fetch('/logistik/' + selectedId, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    }).then(() => location.reload());
}

function closeAll(){
    document.querySelectorAll('.popup')
        .forEach(p => p.style.display='none');
}
</script>

<script>
/* ===== SEARCH KODE / NAMA ===== */
document.getElementById('searchInput').addEventListener('keyup', function () {
    const keyword = this.value.toLowerCase();
    const rows = document.querySelectorAll('.product-table tbody tr');

    rows.forEach(row => {
        const kode = row.cells[0].innerText.toLowerCase();
        const nama = row.cells[1].innerText.toLowerCase();

        if (kode.includes(keyword) || nama.includes(keyword)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>
</body>
</html>
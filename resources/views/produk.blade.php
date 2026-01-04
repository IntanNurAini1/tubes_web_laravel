<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Produk</title>

    <link rel="stylesheet" href="{{ asset('css/app_footer.css') }}">

    <style>

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
            border-radius: 8px;
            border: 1px solid #ccc;
            width: 220px;
        }

        .toolbar button {
            background: #0d6efd;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 8px;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,.05);
        }

        th, td {
            padding: 14px;
            font-size: 14px;
        }

        th {
            background: #f3f6fb;
        }

        tr:not(:last-child) td {
            border-bottom: 1px solid #eee;
        }

        .aktif {
            color: green;
            font-weight: 600;
        }

        .non {
            color: red;
            font-weight: 600;
        }

        .aksi {
            cursor: pointer;
            text-align: center;
            font-weight: bold;
        }

        .popup {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.4);
            justify-content: center;
            align-items: center;
            z-index: 999;
        }

        .popup-content {
            background: #fff;
            padding: 24px;
            border-radius: 14px;
            width: 360px;
        }

        .popup-content h3 {
            margin-top: 0;
            margin-bottom: 16px;
            text-align: center;
        }

        .popup-content input,
        .popup-content select {
            width: 100%;
            padding: 12px;
            margin-bottom: 12px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        .popup-content button {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            margin-top: 8px;
            font-size: 14px;
        }

        .primary { background: #0d6efd; color: white; }
        .danger  { background: #dc3545; color: white; }
        .secondary { background: #d1d1d1; }
    </style>
</head>


<body>

<header class="appbar">
  <div class="left">
    <a href="{{ route('halaman.utama') }}">
        <img src="{{ asset('asset/logo2.png') }}" class="logo">
    </a>
  </div>
  <div class="profile">
    <img src="{{ asset('asset/mat.jpg') }}" class="avatar">
    <span>User Name</span>
  </div>
</header>

<div class="container">

    <div class="header-bar">
        <h2>Data Produk</h2>
        <div class="toolbar">
            <input type="text"
            id="searchKode"
            placeholder="Cari Kode Produk..."
            onkeyup="searchProduk()">
            <button onclick="openTambah()">Tambah Produk</button>
        </div>
    </div>

    <table id="produkTable">
        <thead>
            <tr>
                <th>Kode Produk</th>
                <th>Nama Produk</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
          @foreach($products as $p)
            <tr>
                <td>{{ $p->kode_produk }}</td>
                <td>{{ $p->nama_produk }}</td>
                <td>{{ $p->jumlah }}</td>
                <td class="{{ $p->status == 'Aktif' ? 'aktif' : 'non' }}">
                    {{ $p->status }}
                </td>
                <td class="aksi"
                    onclick="openAksi(
                        '{{ $p->kode_produk }}',
                        '{{ $p->nama_produk }}',
                        '{{ $p->jumlah }}',
                        '{{ $p->status }}'
                    )">
                    :
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>

</div>

<footer>
    © 2025 PT Berikan Teknologi Indonesia ~ Data Produk
</footer>


<div class="popup" id="popupTambah">
    <div class="popup-content">
        <h3>Tambah Produk</h3>

        <form action="/store" method="POST">
            @csrf

            @error('kode_produk')
                <div style="color:red; font-size:13px; margin-bottom:8px;">
                    {{ $message }}
                </div>
            @enderror

            <input type="text"
            name="kode_produk"
            placeholder="Kode Produk (contoh: P001)"
            pattern="P[0-9]{3}"
            title="Format harus P diikuti 3 angka (contoh: P001)"
            value="{{ old('kode_produk') }}"
            required>

            <input type="text" name="nama_produk"
                   placeholder="Nama Produk"
                   value="{{ old('nama_produk') }}"
                   required>

            <input type="number" name="jumlah"
                   placeholder="Jumlah"
                   value="{{ old('jumlah') }}"
                   required>

            <select name="status">
                <option {{ old('status')=='Aktif' ? 'selected' : '' }}>Aktif</option>
                <option {{ old('status')=='Non Aktif' ? 'selected' : '' }}>Non Aktif</option>
            </select>

            <button class="primary">Simpan</button>
            <button type="button" class="secondary" onclick="closeAll()">Batal</button>
        </form>
    </div>
</div>

<!-- ===== Edit ===== -->
<div class="popup" id="popupEdit">
    <div class="popup-content">
        <h3>Edit Produk</h3>
        <form method="POST" id="formEdit">
            @csrf
            <input type="text" id="e_kode" readonly>
            <input type="text" name="nama_produk" id="e_nama" required>
            <input type="number" name="jumlah" id="e_jumlah" required>
            <select name="status" id="e_status">
                <option>Aktif</option>
                <option>Non Aktif</option>
            </select>
            <button class="primary">Update</button>
            <button type="button" class="secondary" onclick="closeAll()">Batal</button>
        </form>
    </div>
</div>

<!-- ===== Aksi ===== -->
<div class="popup" id="popupAksi">
    <div class="popup-content">
        <button class="primary" onclick="openEdit()">Edit</button>
        <button class="danger" onclick="openDelete()">Hapus</button>
        <button class="secondary" onclick="closeAll()">Batal</button>
    </div>
</div>

<!-- ===== Delete ===== -->
<div class="popup" id="popupDelete">
    <div class="popup-content">
        <h3>Konfirmasi</h3>
        <p>Apakah yakin ingin menghapus produk ini?</p>
        <button class="danger" onclick="hapus()">Ya, Hapus</button>
        <button class="secondary" onclick="closeAll()">Batal</button>
    </div>
</div>

<!-- ===== Success ===== -->
<div class="popup" id="popupSuccess">
    <div class="popup-content">
        <h3>Berhasil!!</h3>
        <p id="successMessage" style="text-align:center;"></p>
    </div>
</div>


@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('successMessage').innerText =
            "{{ session('success') }}";
        document.getElementById('popupSuccess').style.display = 'flex';

        setTimeout(() => {
            closeAll();
        }, 2000);
    });
</script>
@endif


<script>
    let kodeProduk = '';

    function openTambah() {
        document.getElementById('popupTambah').style.display = 'flex';
    }

    function openAksi(kode, nama, jumlah, status) {
        kodeProduk = kode;
        document.getElementById('e_kode').value = kode;
        document.getElementById('e_nama').value = nama;
        document.getElementById('e_jumlah').value = jumlah;
        document.getElementById('e_status').value = status;
        document.getElementById('popupAksi').style.display = 'flex';
    }

    function openEdit() {
        closeAll();
        document.getElementById('formEdit').action = '/update/' + kodeProduk;
        document.getElementById('popupEdit').style.display = 'flex';
    }

    function openDelete() {
        closeAll();
        document.getElementById('popupDelete').style.display = 'flex';
    }

    function hapus() {
        window.location.href = '/delete/' + kodeProduk;
    }

    function closeAll() {
        document.querySelectorAll('.popup')
            .forEach(p => p.style.display = 'none');
    }

    function searchProduk() {
        let input = document.getElementById("searchKode").value.toUpperCase();
        let table = document.getElementById("produkTable");
        let tr = table.getElementsByTagName("tr");

        for (let i = 1; i < tr.length; i++) {
            let td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                let text = td.textContent || td.innerText;
                tr[i].style.display =
                    text.toUpperCase().includes(input) ? "" : "none";
            }
        }
    }
</script>

@if ($errors->any())
<script>
    document.getElementById('popupTambah').style.display = 'flex';
</script>
@endif


</body>
</html>

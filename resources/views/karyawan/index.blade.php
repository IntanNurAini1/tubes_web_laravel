<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Karyawan</title>

    <link rel="stylesheet" href="{{ asset('css/app_footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dataKaryawan.css') }}">
</head>

<body>

<header class="appbar">
    <div class="left">
        <a href="{{ route('halaman.utama') }}">
            <img src="{{ asset('asset/logo2.png') }}" class="logo">
        </a>
    </div>
    {{-- <div class="profile">
        <img src="{{ asset('asset/mat.jpg') }}" class="avatar">
        <span>User Name</span>
    </div> --}}
</header>

<div class="container">

    <div class="header-bar">
        <h2>Data Karyawan</h2>
        <div class="toolbar">
            <input type="text" id="searchInput" placeholder="Cari Karyawan...">
            <button onclick="openTambah()">+ Tambah Karyawan</button>
        </div>
    </div>

    <!-- ===== GRID CARD ===== -->
    <div class="employee-grid" id="employeeList">
        @foreach ($karyawan as $i => $k)
            @php
                $initials = strtoupper(substr($k->nama, 0, 2));
                $colors = ['#1abc9c','#9b59b6','#3498db','#e67e22','#e74c3c'];
                $bg = $colors[$i % count($colors)];

                $svg = "
                <svg xmlns='http://www.w3.org/2000/svg' width='80' height='80'>
                    <rect width='100%' height='100%' rx='40' fill='$bg'/>
                    <text x='50%' y='55%' text-anchor='middle'
                        fill='white' font-size='28'
                        font-family='Arial' font-weight='bold'>$initials</text>
                </svg>";

                $avatar = 'data:image/svg+xml;base64,' . base64_encode($svg);
            @endphp

            <div class="employee-card"
                 onclick="goDetail('{{ route('karyawan.show', $k->nip) }}')">

                <img src="{{ $avatar }}" alt="Avatar">

                <h3>{{ $k->nama }}</h3>
                <div class="role">{{ $k->jabatan }}</div>
                <div class="divisi">{{ $k->divisi ?? '-' }}</div>

                <span class="status {{ $k->status == 'Aktif' ? 'Aktif' : 'Cuti' }}">
                    {{ $k->status }}
                </span>

                <div class="salary">
                    Rp {{ number_format($k->gaji ?? 0, 0, ',', '.') }}
                </div>

                <div class="card-actions" onclick="event.stopPropagation()">
                    <button onclick="openEdit(
                        '{{ $k->nip }}',
                        '{{ $k->nama }}',
                        '{{ $k->jabatan }}',
                        '{{ $k->divisi }}',
                        '{{ $k->gaji }}',
                        '{{ $k->alamat ?? '' }}',
                        '{{ $k->status }}'
                    )">✏️</button>

                    <button onclick="openDelete('{{ $k->nip }}')">🗑️</button>
                </div>

            </div>
        @endforeach
    </div>

</div>

<footer>
    © 2025 PT Berikan Teknologi Indonesia ~ Data Karyawan
</footer>

<!-- ===== POPUP TAMBAH ===== -->
<div class="popup" id="popupTambah">
    <div class="popup-content">
        <h3>Tambah Karyawan</h3>

        <form method="POST" action="{{ route('karyawan.store') }}">
            @csrf

            <input name="nip" placeholder="NIP" required>
            <input name="nama" placeholder="Nama Karyawan" required>
            <input name="jabatan" placeholder="Jabatan" required>
            <input name="divisi" placeholder="Divisi">
            <input name="gaji" type="number" placeholder="Masukkan Gaji (Angka)">
            <textarea name="alamat" placeholder="Masukkan Alamat Lengkap" rows="3"></textarea>

            <select name="status" required>
                <option value="Aktif">Aktif</option>
                <option value="Non Aktif">Non Aktif</option>
            </select>

            <div class="popup-buttons">
                <button type="submit" id="saveBtn">Simpan</button>
                <button type="button" id="cancelBtn" onclick="closeAll()">Batal</button>
            </div>
        </form>
    </div>
</div>

<!-- ===== POPUP EDIT ===== -->
<div class="popup" id="popupEdit">
    <div class="popup-content">
        <h3>Edit Karyawan</h3>

        <form method="POST" id="formEdit">
            @csrf
            @method('PUT')

            <input id="e_nip" name="nip" readonly>
            <input id="e_nama" name="nama">
            <input id="e_jabatan" name="jabatan">
            <input id="e_divisi" name="divisi">
            <input id="e_gaji" name="gaji" type="number">
            <textarea id="e_alamat" name="alamat" rows="3"></textarea>

            <select id="e_status" name="status">
                <option value="Aktif">Aktif</option>
                <option value="Non Aktif">Non Aktif</option>
            </select>

            <div class="popup-buttons">
                <button type="submit" id="saveBtn">Update</button>
                <button type="button" id="cancelBtn" onclick="closeAll()">Batal</button>
            </div>
        </form>
    </div>
</div>

<!-- ===== POPUP DELETE ===== -->
<div class="popup" id="popupDelete">
    <div class="popup-content small">
        <p>Apakah yakin ingin menghapus karyawan ini?</p>

        <form method="POST" id="formDelete">
            @csrf
            @method('DELETE')

            <button id="confirmDelete">Ya</button>
            <button type="button" id="cancelDelete" onclick="closeAll()">Batal</button>
        </form>
    </div>
</div>

<script>
function goDetail(url){
    window.location.href = url;
}

function openTambah(){
    document.getElementById('popupTambah').style.display = 'flex';
}

function openEdit(nip, nama, jabatan, divisi, gaji, alamat, status){
    const form = document.getElementById('formEdit');
    form.action = '/karyawan/' + nip;

    e_nip.value = nip;
    e_nama.value = nama;
    e_jabatan.value = jabatan;
    e_divisi.value = divisi;
    e_gaji.value = gaji ?? '';
    e_alamat.value = alamat ?? '';
    e_status.value = status;

    popupEdit.style.display = 'flex';
}

function openDelete(nip){
    formDelete.action = '/karyawan/' + nip;
    popupDelete.style.display = 'flex';
}

function closeAll(){
    document.querySelectorAll('.popup').forEach(p => p.style.display = 'none');
}

document.getElementById('searchInput').addEventListener('keyup', function () {
    const keyword = this.value.toLowerCase();
    document.querySelectorAll('.employee-card').forEach(card => {
        card.style.display = card.innerText.toLowerCase().includes(keyword)
            ? ''
            : 'none';
    });
});
</script>

</body>
</html>

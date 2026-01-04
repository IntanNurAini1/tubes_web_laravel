<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Karyawan</title>
    <link rel="stylesheet" href="{{ asset('css/detailKaryawan.css') }}">
</head>
<body>

<div class="detail-container">

    <button class="btn-back" onclick="history.back()">← Kembali</button>

    @php
        $inisial = strtoupper(substr($karyawan['nama'],0,2));
        $colors = ['#1abc9c','#3498db','#9b59b6','#e67e22','#e74c3c'];
        $bg = $colors[crc32($karyawan['nip']) % count($colors)];
    @endphp

    <div class="profile-header">
        <div class="profile-img-large"
             style="background:{{ $bg }};
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    color:white;
                    font-size:48px;
                    font-weight:bold;">
            {{ $inisial }}
        </div>

        <h1>{{ $karyawan['nama'] }}</h1>
        <p class="role-large">{{ $karyawan['jabatan'] }}</p>

        <span class="status {{ ($karyawan['status'] ?? 'Aktif') == 'Aktif' ? 'aktif' : 'nonaktif' }}">
            {{ $karyawan['status'] ?? 'Aktif' }}
        </span>

    </div>

    <div class="info-grid">

        <div class="info-item">
            <label>NIP</label>
            <p>{{ $karyawan['nip'] }}</p>
        </div>

        <div class="info-item">
            <label>Divisi</label>
            <p>{{ $karyawan['divisi'] }}</p>
        </div>

        <div class="info-item">
            <label>Gaji</label>
            <p>Rp {{ number_format($karyawan['gaji'],0,',','.') }}</p>
        </div>

        <div class="info-item full-width">
            <label>Alamat Lengkap</label>
            <p>{{ $karyawan['alamat'] ?? '-' }}</p>
        </div>

    </div>
</div>

</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Data Maintenance Alat</title>

<link rel="stylesheet" href="{{ asset('css/app_footer.css') }}">

<style>
.container{
    max-width:1200px;
    margin:40px auto;
    padding:0 20px 80px;
}

.header-bar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:15px;
}

.header-bar input{
    padding:10px 16px;
    border-radius:10px;
    border:1px solid #ccc;
    width:250px;
}

.header-bar button{
    padding:10px 18px;
    border-radius:10px;
    border:none;
    background:#0d6efd;
    color:white;
    cursor:pointer;
}

.card-list{
    display:flex;
    flex-direction:column;
    gap:12px;
    max-height:360px;
    overflow-y:auto;
    padding-right:6px;
}

.card-item{
    background:white;
    border-radius:14px;
    padding:12px 16px;
    box-shadow:0 4px 14px rgba(0,0,0,.06);
    display:flex;
    justify-content:space-between;
    align-items:center;
    transition:.2s;
}

.card-item h4{
    margin:0;
    font-size:15px;
    font-weight:700;
}

.card-item p{
    font-size:13px;
    color:#666;
    margin:5px 0 6px 0;
}

.status-belum{
    color:#e74c3c;
    font-size:13px;
    font-weight:600;
}

.status-solved{
    color:#2e8b57;
    font-size:13px;
    font-weight:600;
}

.dropdown{
    position:relative;
}

.dropdown button{
    border:none;
    background:none;
    font-size:16px;
    cursor:pointer;
    padding:4px 6px;
    border-radius:8px;
}

.dropdown button:hover{
    background:#eeeeee;
}

.dropdown-menu{
    position:absolute;
    right:0;
    top:24px;
    background:white;
    border-radius:10px;
    width:125px;
    box-shadow:0 3px 12px rgba(0,0,0,.18);
    display:none;
    overflow:hidden;
}

.dropdown-menu button{
    width:100%;
    padding:8px 12px;
    background:white;
    border:none;
    cursor:pointer;
    text-align:left;
    font-size:13px;
}

.dropdown-menu button:hover{
    background:#f2f2f2;
}

.dropdown-menu button.delete{
    color:#e74c3c;
}

.dropdown-menu button.delete:hover{
    background:#ffeaea;
}

.popup{
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.45);
    justify-content:center;
    align-items:center;
    z-index:999;
    backdrop-filter: blur(3px);
}

.popup-content{
    background:white;
    padding:22px;
    border-radius:16px;
    width:380px;
    box-shadow:0 10px 25px rgba(0,0,0,.25);
}

.popup-content h3{
    margin-top:0;
    margin-bottom:10px;
}

.popup-content input,
.popup-content textarea,
.popup-content select{
    width:100%;
    padding:10px 12px;
    margin:8px 0;
    border-radius:10px;
    border:1px solid #ccc;
}

.popup-content textarea{
    height:90px;
}

.popup-actions{
    display:flex;
    justify-content:flex-end;
    gap:10px;
    margin-top:12px;
}

button.primary{
    background:#0d6efd;
    color:white;
    border:none;
    padding:10px 14px;
    border-radius:10px;
    cursor:pointer;
}

button.primary:disabled{
    background:#9dbcf7;
    cursor:not-allowed;
}

button.primary:hover{background:#0b5cd6;}
button.secondary{
    background:#e0e0e0;
    border:none;
    padding:10px 14px;
    border-radius:10px;
    cursor:pointer;
}

button.danger{
    background:#e74c3c;
    color:white;
    border:none;
    padding:10px 14px;
    border-radius:10px;
    cursor:pointer;
}
</style>
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
    <h2>Data Maintenance Alat</h2>

    <div class="toolbar">
        <input type="text" id="search" placeholder="Cari Alat..." onkeyup="searchAlat()">
        <button onclick="openTambah()">Tambah Data</button>
    </div>
</div>

<div class="card-list" id="alatList">

    @foreach($maintenances as $m)
    <div class="card-item">

        <div>
            <h4>{{ $m['nama_alat'] }} ({{ $m['id_alat'] }})</h4>
            <p>{{ $m['deskripsi'] }}</p>

            <span class="{{ $m['status']=='Solved' ? 'status-solved':'status-belum'}}">
                {{ $m['status']=='Solved' ? 'Tersolved':'Belum' }}
            </span>
        </div>

        <div class="dropdown">
            <button onclick="toggleMenu(this)">⋮</button>

            <div class="dropdown-menu">
                <button onclick="openEdit(
                    '{{ $m['id_alat'] }}',
                    '{{ $m['nama_alat'] }}',
                    '{{ $m['deskripsi'] }}',
                    '{{ $m['status'] }}'
                )">Edit</button>

                <button onclick="openDelete('{{ $m['id_alat'] }}')" class="delete">
                    Hapus
                </button>
            </div>
        </div>

    </div>
    @endforeach
</div>
</div>

<footer>
© 2025 PT Berikan Teknologi Indonesia ~ Maintenance
</footer>


<div class="popup" id="popupTambah">
<div class="popup-content">
<h3>Tambah Data Alat</h3>

<form action="/maintenance/store" method="POST" id="formTambah">
@csrf

<input name="id_alat" placeholder="Kode Alat" required>
<small id="idWarning" style="color:red;display:none">ID Alat sudah digunakan!</small>

<input name="nama_alat" placeholder="Nama Alat" required>
<small id="namaWarning" style="color:red;display:none">Nama Alat sudah digunakan!</small>

<textarea name="deskripsi" placeholder="Keluhan" required></textarea>

<select name="status">
<option>Belum</option>
<option>Solved</option>
</select>

<div class="popup-actions">
<button class="secondary" type="button" onclick="closeAll()">Batal</button>
<button class="primary" id="btnSave">Simpan</button>
</div>
</form>
</div>
</div>

<div class="popup" id="popupEdit">
<div class="popup-content">
<h3>Edit Data Alat</h3>

<form method="POST" id="formEdit">
@csrf
<input id="e_id" readonly>
<input name="nama_alat" id="e_nama" required>
<textarea name="deskripsi" id="e_deskripsi" required></textarea>

<select name="status" id="e_status">
<option>Belum</option>
<option>Solved</option>
</select>

<div class="popup-actions">
<button class="secondary" type="button" onclick="closeAll()">Batal</button>
<button class="primary">Update</button>
</div>
</form>
</div>
</div>

<div class="popup" id="popupDelete">
<div class="popup-content">
<h3>Konfirmasi</h3>
<p>Yakin hapus data?</p>

<div class="popup-actions">
<button class="secondary" onclick="closeAll()">Batal</button>
<button class="danger" id="btnDelete">Ya, Hapus</button>
</div>
</div>
</div>

<script>
function toggleMenu(btn){
    const menu = btn.nextElementSibling;
    menu.style.display = menu.style.display === "block" ? "none" : "block";
}

function openTambah(){
    resetTambahForm();
    closeAll();
    document.getElementById('popupTambah').style.display='flex';
}

function openEdit(id,nama,deskripsi,status){
    closeAll();
    document.getElementById('popupEdit').style.display='flex';
    document.getElementById('formEdit').action='/maintenance/update/'+id;
    document.getElementById('e_id').value=id;
    document.getElementById('e_nama').value=nama;
    document.getElementById('e_deskripsi').value=deskripsi;
    document.getElementById('e_status').value=status;
}

let deleteId="";
function openDelete(id){
    closeAll();
    deleteId=id;
    document.getElementById('popupDelete').style.display='flex';
    document.getElementById('btnDelete').onclick=()=>location.href='/maintenance/delete/'+id;
}

function closeAll(){
    document.querySelectorAll('.popup').forEach(p=>p.style.display='none');
    resetTambahForm();
}

function resetTambahForm(){
    const form = document.getElementById('formTambah');
    form.reset();

    document.getElementById('idWarning').style.display="none";
    document.getElementById('namaWarning').style.display="none";

    document.querySelector('#popupTambah input[name="id_alat"]').style.borderColor="";
    document.querySelector('#popupTambah input[name="nama_alat"]').style.borderColor="";

    document.getElementById('btnSave').disabled = false;
}

function searchAlat(){
    let input=document.getElementById("search").value.toUpperCase();
    let cards=document.querySelectorAll(".card-item");
    cards.forEach(c=>{
        let text=c.innerText.toUpperCase();
        c.style.display=text.includes(input)? "flex":"none";
    });
}

const dataExisting = @json($maintenances);

const idInput = document.querySelector('#popupTambah input[name="id_alat"]');
const namaInput = document.querySelector('#popupTambah input[name="nama_alat"]');
const saveBtn = document.getElementById('btnSave');

const idWarn = document.getElementById('idWarning');
const namaWarn = document.getElementById('namaWarning');

function checkDuplicate(){
    let disable = false;

    const idVal = idInput.value.trim();
    const namaVal = namaInput.value.trim().toLowerCase();

    const sameId = dataExisting.some(item => item.id_alat == idVal);
    const sameNama = dataExisting.some(item => item.nama_alat.toLowerCase() === namaVal);

    if(sameId){
        idWarn.style.display="block";
        idInput.style.borderColor="red";
        disable = true;
    } else {
        idWarn.style.display="none";
        idInput.style.borderColor="";
    }

    if(sameNama){
        namaWarn.style.display="block";
        namaInput.style.borderColor="red";
        disable = true;
    } else {
        namaWarn.style.display="none";
        namaInput.style.borderColor="";
    }

    saveBtn.disabled = disable;
}

idInput.addEventListener("input", checkDuplicate);
namaInput.addEventListener("input", checkDuplicate);
</script>

</body>
</html>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Jadwal Meeting</title>
    <link rel="stylesheet" href="{{ asset('css/meeting.css') }}">
</head>

<body>

    <nav class="navbar">
        <div class="logo">
            <a href="{{ route('halaman.utama') }}">
                <img src="{{ asset('asset/logo2.png') }}" alt="MyBerikan">
            </a>
        </div>
        <div class="profile">
            <img src="{{ asset('asset/mat.jpg') }}">
            <span>User Name</span>
        </div>
    </nav>

    <div class="container">

        <div class="page-header">
            <h1>Jadwal Meeting</h1>
            <button class="btn" onclick="openAdd()">+ Tambah Meeting</button>
        </div>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif
    </div>


    <div class="container">
        @foreach($meetings as $meeting)
            <div class="card">
                <div class="card-title">{{ $meeting['judul'] }}</div>
                <div class="card-subject">{{ $meeting['target_divisi'] }}</div>
                <div class="card-info">
                    Tanggal: {{ substr($meeting['tanggal'], 0, 10) }}
                    <br>Waktu: {{ date('H:i', strtotime($meeting['waktu_mulai'])) }} - {{ date('H:i', strtotime($meeting['waktu_selesai'])) }}
                    <br>{{ $meeting['deskripsi'] }}
                </div>

                <div class="card-actions">
                    <button class="btn btn-edit" onclick='openEdit(
                        @json($meeting["id_meeting"]),
                        @json($meeting["judul"]),
                        @json($meeting["target_divisi"]),
                        @json($meeting["tanggal"]),
                        @json($meeting["waktu_mulai"]),
                        @json($meeting["waktu_selesai"]),
                        @json($meeting["deskripsi"])
                    )'>
                    Edit
                    </button>

                    <button type="button" class="btn btn-delete" onclick="openDelete('{{ $meeting['id_meeting'] }}')">
                        Hapus
                    </button>

                </div>
            </div>
        @endforeach
    </div>

    <div class="modal" id="meetingModal">
        <div class="modal-content">
            <h3 id="modalTitle">Tambah Meeting</h3>

            <form id="meetingForm" method="POST">
                @csrf
                <input type="hidden" id="methodField">

                <input type="text" name="judul" id="judul" placeholder="Judul Meeting" required>
                <input type="text" name="target_divisi" id="target_divisi" placeholder="Target Divisi" required>
                <input type="date" name="tanggal" id="tanggal" required>
                <input type="time" name="waktu_mulai" id="waktu_mulai" required>
                <input type="time" name="waktu_selesai" id="waktu_selesai" required>
                <textarea name="deskripsi" id="deskripsi" placeholder="Deskripsi"></textarea>
                <div class="modal-buttons">
                    <button class="btn">Simpan</button>
                    <button type="button" class="btn btn-delete" onclick="closeModal()">Batal</button>
                </div>
            </form>
        </div>
    </div>
    <div class="modal" id="deleteModal">
        <div class="modal-content">
            <h3>Konfirmasi</h3>
            <p>Apakah Anda yakin untuk menghapus jadwal ini?</p>

            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')

                <div class="modal-buttons">
                    <button class="btn btn-delete">Ya</button>
                    <button type="button" class="btn" onclick="closeDelete()">Tidak</button>
                </div>
            </form>
        </div>
    </div>

    <footer>
        © 2025 PT Berikan Teknologi Indonesia
    </footer>

    <script>
        const tanggalInput = document.getElementById('tanggal');
        const waktuMulaiInput = document.getElementById('waktu_mulai');
        const waktuSelesaiInput = document.getElementById('waktu_selesai');

        function openAdd() {
            document.getElementById('modalTitle').innerText = 'Tambah Meeting';
            document.getElementById('meetingForm').action = '/meetings';
            document.getElementById('methodField').removeAttribute('name');
            document.getElementById('methodField').removeAttribute('value');
            document.getElementById('meetingForm').reset();
            setMinTime();
            document.getElementById('meetingModal').style.display = 'flex';
        }


        function openEdit(id, judul, target_divisi, tanggal, waktu_mulai, waktu_selesai, deskripsi) {
            document.getElementById('modalTitle').innerText = 'Edit Meeting';
            document.getElementById('meetingForm').action = '/meetings/' + id;

            const methodField = document.getElementById('methodField');
            methodField.setAttribute('name', '_method');
            methodField.setAttribute('value', 'PUT');

            document.getElementById('judul').value = judul;
            document.getElementById('target_divisi').value = target_divisi;
            document.getElementById('tanggal').value = tanggal.slice(0, 10);
            document.getElementById('waktu_mulai').value = waktu_mulai.slice(0, 5);
            document.getElementById('waktu_selesai').value = waktu_selesai.slice(0, 5);
            document.getElementById('deskripsi').value = deskripsi;

            setMinTime();
            document.getElementById('meetingModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('meetingModal').style.display = 'none';
        }

        function getLocalDateString(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }
        function setMinTime() {
            const today = new Date();
            // const todayStr = today.toISOString().split('T')[0];
            const todayStr = getLocalDateString(today);

            waktuMulaiInput.min = "";
            waktuSelesaiInput.min = "";

            if (tanggalInput.value === todayStr) {
                today.setHours(today.getHours() + 1);

                const hours = String(today.getHours()).padStart(2, '0');
                const minutes = String(today.getMinutes()).padStart(2, '0');
                const minTimeStr = `${hours}:${minutes}`;

                waktuMulaiInput.min = minTimeStr;
                if (waktuMulaiInput.value) {
                    waktuSelesaiInput.min = waktuMulaiInput.value;
                }
            }
        }

        waktuMulaiInput.addEventListener('change', function() {
            waktuSelesaiInput.min = waktuMulaiInput.value;
        });
        tanggalInput.addEventListener('change', setMinTime);

        function openDelete(id) {
            document.getElementById('deleteForm').action = '/meetings/' + id;
            document.getElementById('deleteModal').style.display = 'flex';
        }

        function closeDelete() {
            document.getElementById('deleteModal').style.display = 'none';
        }
    </script>

</body>

</html>
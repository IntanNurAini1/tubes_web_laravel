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
            <img src="{{ asset('asset/logo2.png') }}">
        </div>
        <div class="profile">
            <img src="{{ asset('asset/mat.jpg') }}">
            <span>User Name</span>
        </div>
    </nav>

    <header>
        <h1>Jadwal Meeting</h1>
    </header>

    <div class="container">
        <div class="actions">
            <button class="btn" onclick="openAdd()">+ Tambah Meeting</button>
        </div>

        @foreach($meetings as $meeting)
            <div class="card">
                <div class="card-title">{{ $meeting['judul'] }}</div>
                <div class="card-info">
                    Tanggal: {{ date('Y-m-d', strtotime($meeting['tanggal'])) }}
                    <br>Waktu: {{ date('H:i', strtotime($meeting['waktu'])) }}
                    <br>{{ $meeting['deskripsi'] }}
                </div>

                <div class="card-actions">
                    <button class="btn btn-edit" onclick="openEdit(
                                                    '{{ $meeting['id_meeting'] }}',
                                                    '{{ $meeting['judul'] }}',
                                                    '{{ $meeting['tanggal'] }}',
                                                    '{{ $meeting['waktu']}}',
                                                    `{{ $meeting['deskripsi'] }}`
                                                )">
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
                <input type="date" name="tanggal" id="tanggal" min="{{ date('Y-m-d') }}" required>
                <input type="time" name="waktu" id="waktu" required>
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
        const waktuInput = document.getElementById('waktu');

        function openAdd() {
            document.getElementById('modalTitle').innerText = 'Tambah Meeting';
            document.getElementById('meetingForm').action = '/meetings';
            document.getElementById('methodField').outerHTML = '';
            document.getElementById('meetingForm').reset();
            setMinTime();
            document.getElementById('meetingModal').style.display = 'flex';
        }


        function openEdit(id, judul, tanggal, waktu, deskripsi) {
            document.getElementById('modalTitle').innerText = 'Edit Meeting';
            document.getElementById('meetingForm').action = '/meetings/' + id;

            document.getElementById('methodField').outerHTML =
                `<input type="hidden" name="_method" value="PUT" id="methodField">`;

            document.getElementById('judul').value = judul;
            document.getElementById('tanggal').value = tanggal.split('T')[0]; 
            document.getElementById('waktu').value = waktu.split(':').slice(0, 2).join(':'); 
            document.getElementById('deskripsi').value = deskripsi;

            setMinTime();
            document.getElementById('meetingModal').style.display = 'flex';
        }


        function closeModal() {
            document.getElementById('meetingModal').style.display = 'none';
        }

        function setMinTime() {
            const today = new Date();
            const selectedDate = new Date(tanggalInput.value);
            waktuInput.min = "";
            if (tanggalInput.value === today.toISOString().split('T')[0]) {
                today.setHours(today.getHours() + 1);

                const hours = String(today.getHours()).padStart(2, '0');
                const minutes = String(today.getMinutes()).padStart(2, '0');

                const minTimeStr = `${hours}:${minutes}`;
                waktuInput.min = minTimeStr;
                if (waktuInput.value) {
                    const [inputHour, inputMinute] = waktuInput.value.split(':').map(Number);
                    const [minHour, minMinute] = minTimeStr.split(':').map(Number);

                    if (inputHour < minHour || (inputHour === minHour && inputMinute < minMinute)) {
                        waktuInput.value = minTimeStr;
                    }
                }
            }
        }

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
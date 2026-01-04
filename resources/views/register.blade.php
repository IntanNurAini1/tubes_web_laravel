<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Register</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }

    body {
      background: url('{{ asset('asset/Rectangle2.png') }}') no-repeat center center/cover;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .container {
      background: rgba(255, 255, 255, 0.95);
      padding: 40px 50px;
      border-radius: 15px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
      width: 500px;
    }

    .container img {
      display: block;
      margin: 0 auto 10px auto;
      width: 80px;
    }

    .container h2 {
      text-align: center;
      margin-bottom: 10px;
      font-size: 22px;
      font-weight: 600;
    }

    .container p {
      text-align: center;
      font-size: 14px;
      color: #555;
      margin-bottom: 20px;
    }

    .input-group {
      margin-bottom: 15px;
    }

    .input-group label {
      display: block;
      font-size: 14px;
      margin-bottom: 5px;
      color: #333;
    }

    .input-group input {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
    }

    .login-text {
      text-align: center;
      font-size: 13px;
      margin: 15px 0;
      color: #444;
    }

    .login-text a {
      color: #007bff;
      text-decoration: none;
      font-weight: 500;
    }

    .login-text a:hover {
      text-decoration: underline;
    }

    .btn {
      width: 100%;
      padding: 10px;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 15px;
      transition: 0.3s;
    }

    .btn:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>

  <div class="container">
    <img src="{{ asset('asset/logo.png') }}" alt="Logo">
    <h2>Selamat Datang</h2>
    <p>Lengkapi data di bawah untuk membuat akun baru</p>

    @if(session('error'))
  <div style="color:red; margin-bottom:10px;">
    {{ session('error') }}
  </div>
  @endif

  @if(session('success'))
    <div style="color:green; margin-bottom:10px;">
      {{ session('success') }}
    </div>
  @endif


    <!-- FORM REGISTER -->
    <form action="{{ route('akun.store') }}" method="POST">
      @csrf
      <div class="input-group">
        <label for="nip">ID Karyawan</label>
        <input type="text" id="nip" name="nip" placeholder="ID Pengguna" required>
      </div>

      <div class="input-group">
        <label for="username">Nama Pengguna</label>
        <input type="text" id="username" name="username" placeholder="Nama Pengguna" required>
      </div>

      <div class="input-group">
        <label for="password">Kata Sandi</label>
        <input type="password" id="password" name="password" placeholder="Masukkan Kata Sandi" required>
      </div>

      <div class="input-group">
        <label for="confirm">Konfirmasi Kata Sandi</label>
        <input type="password" id="confirm" name="confirm" placeholder="Masukkan Ulang Kata Sandi" required>
      </div>

      <div class="login-text">
        Sudah memiliki akun? <a href="{{ route('login') }}">Login di sini</a>
      </div>

      <button type="submit" class="btn">Register</button>
    </form>
  </div>

  <script>
    const form = document.querySelector('form');

    form.addEventListener('submit', function(e) {
      const password = document.getElementById('password').value.trim();
      const confirm = document.getElementById('confirm').value.trim();

      if (password !== confirm) {
        e.preventDefault();
        alert('Kata sandi dan konfirmasi tidak cocok!');
      }
    });
  </script>

</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Login - LaskarCilik</title>
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
   <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
  <div class="login-container">

    <!-- KIRI: Branding -->
    <div class="kiri-section">
    <h1>Selamat <span>Datang!</span></h1>
    <div class="kiri-logo-wrap">
        <img src="{{ asset('assets/logo laskar cilik.png') }}"
             alt="Logo Laskar Cilik">
    </div>

    <p class="kiri-tagline">
        Sistem Pencatatan Akademik & Sosial<br>
        TKIT Khaleefa El Rahman
    </p>

  </div>
    <!-- KANAN: Form -->
    <div class="kanan-section">
      <div class="login-kanan">

        <div class="login-logo">
          <h2 class="brand">Laskar Cilik</h2>
          <p class="login-subtitle">Masuk ke akun Anda untuk melanjutkan</p>
        </div>

        @if(session('logout'))
          <div id="toast-logout" class="toast-success">{{ session('logout') }}</div>
        @endif
        @if(session('error'))
          <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <form id="loginForm">
          @csrf

          <label for="username">Username</label>
          <div class="input-group">
            <i class="fa-solid fa-user"></i>
            <input type="text" id="username" name="username" placeholder="Masukkan username" required>
          </div>

          <label for="password">Password</label>
          <div class="input-group">
            <i class="fa-solid fa-lock"></i>
            <input type="password" id="password" name="password" placeholder="Masukkan password" required>
          </div>

          <button type="submit" id="loginBtn">
            <i class="fa-solid fa-right-to-bracket"></i> Masuk
          </button>
        </form>

      </div>
    </div>
  </div>

  <script>
  document.getElementById('loginForm').addEventListener('submit', async function(e) {
      e.preventDefault();
      const username = document.getElementById('username').value;
      const password = document.getElementById('password').value;
      const loginBtn = document.getElementById('loginBtn');
      loginBtn.disabled = true;
      loginBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memproses...';
      try {
          const response = await fetch('{{ route("login.post") }}', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
              },
              body: JSON.stringify({ username, password })
          });
          const data = await response.json();
          if (data.success) {
              window.location.href = data.redirect;
          } else {
              alert(data.message);
              loginBtn.disabled = false;
              loginBtn.innerHTML = '<i class="fa-solid fa-right-to-bracket"></i> Masuk';
          }
      } catch (error) {
          alert('Terjadi kesalahan: ' + error);
          loginBtn.disabled = false;
          loginBtn.innerHTML = '<i class="fa-solid fa-right-to-bracket"></i> Masuk';
      }
  });
  </script>
</body>
</html>

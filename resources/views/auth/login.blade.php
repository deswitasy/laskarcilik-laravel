<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Login - LaskarCilik</title>
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
  <div class="login-container">
    <div class="kiri-section">
      <h1>SELAMAT<br><span>DATANG!</span></h1>
    </div>

    <div class="kanan-section">
      <div class="login-kanan">
        <h2 class="brand">LaskarCilik</h2>
        
       @if(session('logout'))
<div id="toast-logout" class="toast-success">
  {{ session('logout') }}
</div>
@endif


        @if(session('error'))
          <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <form id="loginForm">
          @csrf
          <label for="username">USERNAME</label>
          <input type="text" id="username" name="username" placeholder="Enter your Username" required>

          <label for="password">PASSWORD</label>
          <input type="password" id="password" name="password" placeholder="Enter your Password" required>

          <button type="submit" id="loginBtn">Login</button>
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
      loginBtn.textContent = 'Loading...';
      
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
              loginBtn.textContent = 'Login';
          }
      } catch (error) {
          alert('Terjadi kesalahan: ' + error);
          loginBtn.disabled = false;
          loginBtn.textContent = 'Login';
      }
  });
  </script>
</body>
</html>
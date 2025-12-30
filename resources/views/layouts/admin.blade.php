<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') - Laskar Cilik</title>

    <!-- CSS -->
     <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/daftarCatatan.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @stack('styles')
</head>
<body>

<div class="app-wrapper">
    <!-- Sidebar -->
    @include('components.sidebar', ['role' => 'admin'])

    <!-- Main Content -->
    <main class="main-content" id="mainContent">

        <!-- Header -->
         <header class="header">
                <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
                <div class="header-right">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="logout-button" title="Logout">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        </button>
                    </form>

                    <div class="avatar">
                        {{ strtoupper(substr(Auth::user()->nama_user, 0, 1)) }}
                    </div>
                </div>
            </header>

        <!-- Alert Messages -->
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

        @if($errors->any())
            <div class="alert alert-error">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Content -->
        <div class="content-container">
            @yield('content')
        </div>

    </main>
</div>

<!-- Scripts -->
<script src="{{ asset('js/daftarCatatan.js') }}"></script>
<script src="{{ asset('js/sidebar.js') }}"></script>
@stack('scripts')

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AnakKost')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    {{-- NAVBAR --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">AnakKost</a>

            <div class="ms-auto">
                @auth
                    <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="btn btn-outline-danger btn-sm">
                        Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">
                        Login
                    </a>
                @endguest
            </div>
        </div>
    </nav>


    {{-- FLASH MESSAGE --}}
    <div class="container">
        @if(session('success'))
            <div class="alert success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert error">
                {{ session('error') }}
            </div>
        @endif

        @if(session('info'))
            <div class="alert info">
                {{ session('info') }}
            </div>
        @endif
    </div>

    {{-- PAGE CONTENT --}}
    <main>
        @yield('content')
    </main>
    @stack('scripts')
</body>
</html>

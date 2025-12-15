<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Login</title>
</head>

<body class="login-page">
    <div class="auth-container">
        <div class="auth-card">
            <h1 class="title">Login</h1>
            <form method="POST" action="{{ route('login') }}">
    
                @csrf
    
                <div class="input-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
    
                    @error('email')
                    <span style="color: red;">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required>
                </div>
                <div class="input-group">
                    <label>
                        <input type="checkbox" name="remember">
                        Remember me
                    </label>
                </div>
    
                <div>
                    <button class="btn" type="submit">Login</button>
                </div>
    
                <div class="register-link">
                    <p>Don't have an account? 
                        <a href="{{ route('user.register') }}">
                            Register
                        </a> 
                    </p>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
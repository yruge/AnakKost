<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Register User</title>
</head>
<body class="register-page">
    <div class="auth-container">
        <div class="auth-card">

            <h1 class="title">Register</h1>

            <form action="{{ route('user.register.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="input-group">
                    <label>Name</label>
                    <input type="text" name="name" required>
                </div>

                <div class="input-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>

                <div class="input-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>

                <div class="input-group">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" required>
                </div>

                <button class="btn" type="submit">Register</button>

                <div class="login-link">
                    <p>Already have an account? 
                        <a href="{{ route('login') }}">
                            Login
                        </a> 
                    </p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
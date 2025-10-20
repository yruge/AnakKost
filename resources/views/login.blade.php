<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <form method="POST" action="{{ route('login') }}">

            @csrf

            <h1>Login</h1>

            <div class="input-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>

                @error('email')
                <span style="color: red;">{{ $message }}</span>
                @enderror

                <label for="password">Password</label>
                <input id="password" type="password" name="password" required>
            </div>

            <div>
                <a href="{{ route('login') }}">Login</a>
            </div>
        </form>
    </div>
</body>

</html>
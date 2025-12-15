<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <link rel="stylesheet" href="{{ asset('css/login-register.css') }}"> --}}
        <style>
        * {
            box-sizing: border-box;
            font-family: "Georgia", serif;
        }

        body {
            min-height: 100vh;
            background: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .card {
            width: 380px;
            border: 1px solid #bfbfbf;
            border-radius: 10px;
            margin: 20px;
            padding: 40px 35px;
            background: #fff;
        }

        .title {
            text-align: center;
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: bold;
        }

        .input-group {
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
        }

        .input-group label {
            margin-bottom: 8px;
            font-size: 16px;
        }

        .input-group input,
        .input-group select {
            padding: 10px;
            font-size: 14px;
            border: 1px solid #c9c9c9;
            border-radius: 5px;
        }

        .btn {
            display: block;
            margin-top: 10px;
            padding: 12px;
            text-align: center;
            background: #6f6ff2;
            border: none;
            border-radius: 5px;
            color: white;
            text-decoration: none;
            font-weight: bold;
            width: 100%;
            cursor: pointer;
        }

        .login-link {
            margin-top: 15px;
            font-size: 14px;
        }

        .login-link a:hover {
            opacity: 0.9;
        }
    </style>
    <title>Register User</title>
</head>
<body>
    <div class="container">
        <div class="card">

            <h1 class="title">Register</h1>

            <form action="{{ route('user.register.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="input-group">
                    <label>Name</label>
                    <input type="text" name="name" required>
                </div>

                {{-- <div class="input-group">
                    <label>Phone Number</label>
                    <input type="text" name="phone_number" required>
                </div>

                <div class="input-group">
                    <label>KTP Photo</label>
                    <input type="file" name="ktp_photo"  required>
                </div> --}}

                {{-- <div class="input-group">
                    <label>Move In Date</label>
                    <input type="date" name="move_in_date" value="{{ 'move_in_date' }}" required>
                </div> --}}

                {{-- <div class="input-group">
                    <label>Select Room</label>
                    <select name="room_id" required>
                        @foreach($rooms as $room)
                        <option value="{{ $room->id }}">
                            {{ $room->name }} - {{ number_format($room->price) }} IDR
                        </option>
                        @endforeach
                    </select>
                </div> --}}

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
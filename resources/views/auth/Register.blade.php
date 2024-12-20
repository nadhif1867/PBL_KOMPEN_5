<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIKOMTI - Registrasi Mahasiswa</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Source Sans Pro', sans-serif;
            background-color: #f4f6f9;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .header-background {
            background-color: #0E1F43;
            width: 100%;
            height: 30vh;
            border-bottom-left-radius: 85% 85%;
            border-bottom-right-radius: 85% 85%;
            position: relative;
            text-align: center;
            color: #fff;
            padding-top: 30px;
        }

        .header-background img {
            max-width: 300px;
            margin: 0 auto;
        }

        .header-background p {
            font-size: 1.5rem;
            margin-top: 10px;
        }

        .login-container {
            margin-top: -80px;
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-bottom: 100px;
            /* Adds space between form and footer */
        }

        .login-container h3 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.5rem;
            color: #001c41;
        }

        .form-control {
            width: 90%;
            padding: 10px;
            margin: 15px auto;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btn-login {
            display: block;
            width: 80%;
            margin: 10px auto;
            padding: 10px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            text-align: center;
            cursor: pointer;
        }

        .btn-login2 {
            display: block;
            width: 80%;
            margin: 10px auto;
            padding: 10px;
            background-color: #F9271C;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            text-align: center;
            cursor: pointer;
        }

        .btn-login:hover {
            background-color: #1e8436;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            color: #001c41;
            font-size: 0.9rem;
        }

        footer {
            position: relative;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #0E1F43;
            color: white;
            text-align: center;
            padding: 1rem;
            font-size: 0.9rem;
        }

        .alert {
            width: 90%;
            margin: 10px auto;
            padding: 10px;
            border-radius: 4px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header-background">
        <a href="{{url('/')}}"><img src="{{ asset('images/SIKOMTI.png') }}" alt="SIKOMTI Logo"></a>
        <h1>REGISTRASI MAHASISWA</h1>
    </div>

    <!-- Form Registrasi -->
    <div class="login-container">
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <input type="text" name="username" class="form-control" placeholder="Username" required minlength="3" maxlength="50">
            <input type="password" name="password" class="form-control" placeholder="Password" required minlength="5">
            <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password" required>
            <input type="text" name="nim" class="form-control" placeholder="NIM" required pattern="[0-9]{9}">
            <input type="text" name="kelas" class="form-control" placeholder="Kelas" required>
            <input type="text" name="semester" class="form-control" placeholder="Semester" required>
            <input type="text" name="prodi" class="form-control" placeholder="Program Studi" required>
            <input type="email" name="email" class="form-control" placeholder="Email" required>
            <input type="number" name="tahun_masuk" class="form-control" placeholder="Tahun Masuk" required min="1900" max="{{ date('Y') }}">
            <input type="tel" name="no_telepon" class="form-control" placeholder="Nomor Telepon" required pattern="[0-9]{10,15}">
            <input type="text" name="nama" class="form-control" placeholder="Nama" required maxlength="100">
            <button type="submit" class="btn-login">Registrasi</button>
        </form>
        <button type="button" class="btn-login2" onclick="window.location='{{ route('login.mahasiswa') }}'">Kembali ke Login</button>
    </div>

    <footer>
        ©2024 Sistem Kompensasi Jurusan
    </footer>
</body>

</html>
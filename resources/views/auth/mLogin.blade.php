<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIKOMTI - Login Mahasiswa</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Source Sans Pro', sans-serif;
            background-color: #f4f6f9;
        }

        /* Header dengan setengah lingkaran biru */
        .header-background {
            background-color: #0E1F43;
            width: 100%;
            height: 30vh;
            /* Ubah tinggi menjadi 45vh */
            border-bottom-left-radius: 85% 85%;
            /* Lengkungan ke tengah */
            border-bottom-right-radius: 85% 85%;
            /* Lengkungan ke tengah */
            position: relative;
            text-align: center;
            color: #fff;
            padding-top: 30px;
            /* Tambahkan padding atas */
        }

        .header-background img {
            max-width: 300px;
            margin: 0 auto;
        }

        .header-background p {
            font-size: 1.5rem;
            margin-top: 10px;
        }

        /* Kontainer form login */
        .login-container {
            margin-top: -80px;
            max-width: 400px;
            /* Ubah lebar kotak di sini */
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);

        }

        .login-container h3 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.5rem;
            color: #001c41;
        }

        /* .form-control {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        } */

        .form-control {
            width: 90%;
            /* Lebar input */
            padding: 10px;
            margin: 15px auto;
            border: 1px solid #ccc;
            border-radius: 4px;
        }


        /* .btn-login {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
        } */

        .btn-login {
            /* width: 80%; /* Samakan dengan .form-control */
            /* padding: 8px;
            margin: 10px auto;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 0.9rem;
            cursor: pointer; */

            display: block;
            /* Ubah tombol menjadi elemen blok */
            width: 80%;
            /* Samakan lebar dengan input Username dan Password */
            margin: 10px auto;
            /* Pusatkan secara horizontal */
            padding: 10px;
            /* Sesuaikan ukuran padding */
            background-color: #28a745;
            /* Warna hijau */
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            text-align: center;
            /* Pastikan teks tombol di tengah */
            cursor: pointer;
        }

        .btn-login:hover {
            background-color: #218838;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            color: #001c41;
            font-size: 0.9rem;
        }

        .footer a {
            color: #007bff;
            text-decoration: none;
        }

        footer {
            position: fixed;
            bottom: 0;
            /* Letakkan di bagian bawah layar */
            left: 0;
            /* Mulai dari sisi kiri */
            width: 100%;
            /* Lebar penuh halaman */
            background-color: #0E1F43;
            /* Warna latar footer */
            color: white;
            /* Warna teks footer */
            text-align: center;
            /* Teks di tengah */
            padding: 1rem;
            /* Spasi dalam */
            font-size: 0.9rem;
            /* Ukuran teks */
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header-background">
    <a href="{{url('/')}}"><img src="{{ asset('images/SIKOMTI.png') }}" alt="SIKOMTI Logo"></a>
        <h1>LOGIN MAHASISWA</h1>

    </div>

    <!-- Form Login -->
    <div class="login-container">
        {{-- <h3>Login Mahasiswa</h3> --}}
        <form action="{{ route('login.mahasiswa') }}" method="POST">
            @csrf <!-- Tambahkan token CSRF -->
            <input type="text" name="username" class="form-control" placeholder="Username" required>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
            <div style="margin-bottom: 10px;">
                <input type="checkbox" id="show-password" onclick="togglePassword()"> Tampilkan Password
            </div>
            <button type="submit" class="btn-login">Login</button>
        </form>
        <div class="footer">
            <p><a href="{{'register'}}">Registrasi Mahasiswa?</a></p>

        </div>
    </div>

    <footer>
        ©2024 Sistem Kompensasi Jurusan
    </footer>

    <script>
        function togglePassword() {
            var passwordField = document.querySelector('input[name="password"]');
            passwordField.type = passwordField.type === 'password' ? 'text' : 'password';
        }
    </script>
</body>

</html>
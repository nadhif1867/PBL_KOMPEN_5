<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIKOMTI - Politeknik Negeri Malang</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #fff;
        }

        .container {
            position: relative;
            text-align: center;
            color: white;
        }

        .half-circle {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 45vh;
            /* Mengatur tinggi menjadi seperempat dari tinggi layar */
            background-color: #0E1F43;
            border-bottom-left-radius: 95% 95%;
            /* Lengkungan ke tengah */
            border-bottom-right-radius: 95% 95%;
            /* Lengkungan ke tengah */
        }

        .logo {
            max-width: 300px;
            margin: 100px auto 1rem;
            position: relative;
            z-index: 2;
        }

        /* .logo2 {
            max-width: 100px;
            margin: 100px auto 1rem;
            position: relative;
            z-index: 2;
        } */

        .title {
            font-size: 2.5rem;
            font-weight: bold;
            position: relative;
            z-index: 2;
        }

        .subtitle {
            font-size: 1.5rem;
            position: relative;
            z-index: 2;
        }

        .content {
            background-color: white;
            text-align: center;
            padding: 2rem 1rem;
            z-index: 1;
            margin-top: 300px;
        }

        .login-text {
            font-size: 1.5rem;
            margin-bottom: 20px;
            color: #333;
        }

        .btn-container {
            display: flex;
            justify-content: center;
            gap: 1rem;
        }

        .btn {
            display: inline-block;
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            text-align: center;
            text-decoration: none;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn.admin {
            background-color: #b71c1c;
        }

        .btn.dosen {
            background-color: #ff6f00;
        }

        .btn.tendik {
            background-color: #ff6f00;
        }

        .btn.mahasiswa {
            background-color: #ffab00;
        }

        .btn:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        footer {
            background-color: #0E1F43;
            color: white;
            text-align: center;
            padding: 1rem;
            font-size: 0.9rem;
            margin-top: auto;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="half-circle"></div>
        {{-- <img src="{{ asset('images/JTI.png') }}" alt="JTI Logo" class="logo2"> --}}
        <img src="{{ asset('images/SIKOMTI.png') }}" alt="SIKOMTI Logo" class="logo">
        <p class="subtitle">POLITEKNIK NEGERI MALANG</p>
    </div>

    <div class="content">
        <p class="login-text">Login Sebagai:</p>
        <div class="btn-container">
            <a href="{{ url('login/admin') }}" class="btn admin">Admin</a>
            <a href="{{ url('login/dosen') }}" class="btn dosen">Dosen</a>
            <a href="{{ url('login/tendik') }}" class="btn tendik">Tendik</a>
            <a href="{{ url('login/mahasiswa') }}" class="btn mahasiswa">Mahasiswa</a>
        </div>
    </div>

    <footer>
        ©2024 Sistem Kompensasi Jurusan
    </footer>

</body>

</html>
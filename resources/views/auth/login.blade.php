<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Inventaris SMKN 2 Padang Panjang</title>
    <style>
        /* ========== RESET & BASE ========== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0f2b4a 0%, #1a4a7a 50%, #0f2b4a 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        /* ========== KARTU LOGIN ========== */
        .login-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            padding: 40px 40px 30px;
            width: 100%;
            max-width: 420px;
            transition: transform 0.3s ease;
        }

        .login-container:hover {
            transform: translateY(-3px);
        }

        /* ========== LOGO / HEADER ========== */
        .login-header {
            text-align: center;
            margin-bottom: 25px;
        }

        .login-header .logo {
            display: block;
            margin: 0 auto 10px;
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #1a4a7a;
            padding: 5px;
            background: white;
            box-shadow: 0 4px 15px rgba(26, 74, 122, 0.2);
        }

        .login-header h1 {
            font-size: 20px;
            font-weight: 700;
            color: #0f2b4a;
            letter-spacing: 1px;
        }

        .login-header .subtitle {
            font-size: 13px;
            color: #6b7a8f;
            margin-top: 4px;
            font-weight: 400;
        }

        .login-header .school-name {
            font-size: 13px;
            font-weight: 600;
            color: #1a4a7a;
            margin-top: 6px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .divider {
            height: 3px;
            width: 60px;
            background: #1a4a7a;
            margin: 10px auto 0;
            border-radius: 10px;
        }

        /* ========== FORM ========== */
        .login-form h2 {
            font-size: 17px;
            font-weight: 600;
            color: #0f2b4a;
            margin-bottom: 18px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #1a2a3a;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 11px 16px;
            border: 2px solid #dce3ed;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #f7f9fc;
            color: #0f2b4a;
        }

        .form-group input:focus {
            outline: none;
            border-color: #1a4a7a;
            background: white;
            box-shadow: 0 0 0 4px rgba(26, 74, 122, 0.12);
        }

        .form-group input::placeholder {
            color: #a0b3c9;
            font-size: 13px;
        }

        /* ========== TOMBOL ========== */
        .btn-login {
            width: 100%;
            padding: 12px;
            background: #0f2b4a;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            letter-spacing: 1px;
            margin-top: 6px;
        }

        .btn-login:hover {
            background: #1a4a7a;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(15, 43, 74, 0.35);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        /* ========== DEMO AKUN ========== */
        .demo-accounts {
            margin-top: 22px;
            padding-top: 18px;
            border-top: 2px dashed #e2e8f0;
            text-align: center;
        }

        .demo-accounts p {
            font-size: 12px;
            font-weight: 600;
            color: #1a2a3a;
            margin-bottom: 8px;
        }

        .demo-accounts .demo-grid {
            display: flex;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .demo-accounts .demo-item {
            background: #f0f4fa;
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 11px;
            color: #0f2b4a;
            font-weight: 500;
        }

        .demo-accounts .demo-item strong {
            color: #1a4a7a;
        }

        /* ========== ALERT ========== */
        .alert {
            padding: 10px 16px;
            border-radius: 8px;
            margin-bottom: 16px;
            font-size: 13px;
            font-weight: 500;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid #dc2626;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border-left: 4px solid #22c55e;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px 22px;
            }

            .login-header .logo {
                width: 70px;
                height: 70px;
            }

            .login-header h1 {
                font-size: 17px;
            }

            .login-header .school-name {
                font-size: 11px;
            }

            .demo-accounts .demo-grid {
                gap: 8px;
            }

            .demo-accounts .demo-item {
                font-size: 10px;
                padding: 4px 10px;
            }
        }
    </style>
</head>
<body>

    <div class="login-container">

        <!-- ===== HEADER ===== -->
        <div class="login-header">
            {{-- GANTI src-nya dengan path gambar logo sekolah Anda --}}
            <img class="logo" src="{{ asset('images/logo-sekolah.png') }}" alt="Logo SMKN 2 Padang Panjang">
            <h1>SMKN 2 PADANG PANJANG</h1>
            <div class="school-name">Sistem Inventaris Barang Sekolah</div>
            <div class="divider"></div>
        </div>

        <!-- ===== FORM LOGIN ===== -->
        <div class="login-form">

            <h2>🔐 Masuk Ke Akun Anda</h2>

            @if(session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="nis">USERNAME / NIS</label>
                    <input type="text" id="nis" name="nis" placeholder="Masukkan NIS / Username" value="{{ old('nis') }}" required>
                </div>

                <div class="form-group">
                    <label for="password">PASSWORD</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan Password" required>
                </div>

                <button type="submit" class="btn-login">MASUK</button>
            </form>
        </div>

        

    </div>

</body>
</html>
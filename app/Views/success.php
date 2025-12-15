<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Berhasil</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #ffffff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow-x: hidden;
        }

        .container {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            position: relative;
            z-index: 1;
        }

        .logo-container {
            margin-bottom: 50px;
        }

        .logo-image {
            max-width: 200px;
            width: 60px;
            height: 28,68px;
        }

        .success-icon {
            width: 150px;
            height: 150px;
            margin: 0 auto 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .success-icon img {
            width: 100%;
            height: auto;
        }

        .success-title {
            font-size: 32px;
            font-weight: 700;
            color: #000;
            text-align: center;
            margin-bottom: 16px;
        }

        .success-message {
            font-size: 16px;
            font-weight: 400;
            color: #666;
            text-align: center;
            max-width: 300px;
            line-height: 1.6;
        }

        .footer-image {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            z-index: 0;
        }

        .footer-image img {
            width: 100%;
            height: auto;
            display: block;
        }

        @media (max-width: 480px) {
            .success-title {
                font-size: 28px;
            }

            .success-message {
                font-size: 14px;
            }

            .success-icon {
                width: 120px;
                height: 120px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo-container">
            <img src="/images/maglogoblack.svg" alt="MAG 2025 MEDCO AMPERA GAMES BEYOND" class="logo-image">
        </div>

        <div class="success-icon">
            <img src="/images/successmag.png" alt="Success">
        </div>

        <h1 class="success-title">Pendaftaran Berhasil</h1>
        <p class="success-message">Anda sekarang resmi terdaftar dalam undian. Semoga beruntung!</p>
    </div>

    <div class="footer-image">
        <img src="/images/footermag.png" alt="Footer">
    </div>
</body>
</html>


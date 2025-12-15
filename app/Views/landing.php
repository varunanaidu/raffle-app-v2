<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAG 2025 - Medco Ampera Games</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #0a0a0a;
            min-height: 100vh;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        /* Grid pattern background */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 30px 30px;
            z-index: 0;
            pointer-events: none;
        }

        /* Star dots effect */
        body::after {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: radial-gradient(circle, rgba(255, 255, 255, 0.15) 1px, transparent 1px);
            background-size: 50px 50px;
            background-position: 0 0, 25px 25px;
            z-index: 0;
            pointer-events: none;
            opacity: 0.3;
        }

        .landing-container {
            position: relative;
            z-index: 1;
            text-align: center;
            padding: 20px;
            animation: fadeIn 1s ease-in;
        }

        .logo-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0;
        }

        .logo-image {
            max-width: 400px;
            width: 90%;
            height: auto;
            margin: 0;
            filter: drop-shadow(0 0 30px rgba(255, 107, 53, 0.2));
            animation: logoFloat 3s ease-in-out infinite;
        }

        @keyframes logoFloat {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        .loading-text {
            color: rgba(255, 255, 255, 0.6);
            font-size: 14px;
            margin-top: 40px;
            font-weight: 400;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 0.6;
            }
            50% {
                opacity: 1;
            }
        }

        @media (max-width: 480px) {
            .logo-image {
                max-width: 320px;
            }
        }
    </style>
</head>
<body onclick="redirectToRegister()">
    <div class="landing-container">
        <div class="logo-wrapper">
            <img src="/images/maglogo.svg" alt="MAG 2025 MEDCO AMPERA GAMES BEYOND" class="logo-image">
        </div>
        
        <div class="loading-text">Tap untuk melanjutkan...</div>
    </div>

    <script>
        function redirectToRegister() {
            window.location.href = '/register';
        }

        // Auto redirect setelah 3 detik
        setTimeout(() => {
            redirectToRegister();
        }, 3000);
    </script>
</body>
</html>


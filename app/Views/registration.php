<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration - Form</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #1a1a1a;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
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
            background-size: 20px 20px;
            z-index: 0;
            pointer-events: none;
        }

        .container {
            position: relative;
            z-index: 1;
            max-width: 100%;
            margin: 0 auto;
            padding: 0;
        }

        /* Header section with dark background */
        .header-section {
            background: #1a1a1a;
            padding: 40px 20px 30px;
            position: relative;
        }

        .logo-container {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            margin-bottom: 30px;
            width: 70px;
            height: 70px;
        }

        .logo-image {
            max-width: 200px;
            width: 100%;
            height: auto;
        }

        .welcome-section {
            margin-top: 20px;
        }

        .welcome-title {
            font-size: 48px;
            font-weight: 700;
            color: white;
            margin-bottom: 10px;
            line-height: 1.1;
        }

        .welcome-subtitle {
            font-size: 16px;
            color: white;
            font-weight: 400;
            opacity: 0.9;
        }

        /* Form section with white background */
        .form-section {
            background:rgb(255, 252, 252);
            padding: 40px 20px 60px;
            margin-top: -20px;
            position: relative;
            z-index: 2;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .form-input,
        .form-select {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            font-family: 'Poppins', sans-serif;
            background: white;
            color: #333;
            transition: border-color 0.3s;
        }

        .form-input:focus,
        .form-select:focus {
            outline: none;
            border-color: #FF6B35;
        }

        .form-input::placeholder {
            color: #999;
        }

        .btn-daftar {
            width: 100%;
            padding: 16px;
            background: #FF6B35;
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 18px;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            margin-top: 10px;
            transition: background 0.3s, transform 0.1s;
        }

        .btn-daftar:hover {
            background: #e55a2b;
        }

        .btn-daftar:active {
            transform: scale(0.98);
        }

        .btn-daftar:disabled {
            background: #ccc;
            cursor: not-allowed;
        }

        .terms-text {
            margin-top: 20px;
            font-size: 12px;
            color: #666;
            text-align: center;
            line-height: 1.6;
        }

        .terms-text a {
            color: #FF6B35;
            text-decoration: underline;
            font-weight: 600;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        @media (max-width: 480px) {
            .welcome-title {
                font-size: 40px;
            }

            .form-section {
                padding: 30px 16px 50px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header Section -->
        <div class="header-section">
            <div class="logo-container">
                <img src="/images/maglogo.png" alt="MAG 2025 MEDCO AMPERA GAMES BEYOND" class="logo-image">
            </div>

            <div class="welcome-section">
                <h1 class="welcome-title">Welcome</h1>
                <p class="welcome-subtitle">Closing Ceremony Medco Ampera Games</p>
            </div>
        </div>

        <!-- Form Section -->
        <div class="form-section">
            <div id="alert-container"></div>

            <form id="registrationForm">
                <div class="form-group">
                    <label class="form-label" for="name">Nama</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        class="form-input" 
                        placeholder="Nama"
                        required
                    >
                </div>

                <div class="form-group">
                    <label class="form-label" for="bisnis_unit">Bisnis Unit</label>
                    <input 
                        type="text"
                        id="bisnis_unit"
                        name="bisnis_unit"
                        class="form-input"
                        placeholder="Bisnis Unit"
                        required
                    >
                </div>

                <div class="form-group">
                    <label class="form-label" for="phone_number">No. Handphone</label>
                    <input 
                        type="tel" 
                        id="phone_number" 
                        name="phone_number" 
                        class="form-input" 
                        placeholder="No.handphone"
                        required
                    >
                </div>

                <button type="submit" class="btn-daftar" id="submitBtn">
                    Daftar
                </button>

                <p class="terms-text">
                    Dengan mendaftar, Anda menyetujui 
                    <a href="#" onclick="alert('Persyaratan Layanan'); return false;">Persyaratan Layanan</a> 
                    dan 
                    <a href="#" onclick="alert('Perjanjian Pemrosesan Data'); return false;">Perjanjian Pemrosesan Data</a>
                </p>
            </form>
        </div>
    </div>

    <script>
        const form = document.getElementById('registrationForm');
        const submitBtn = document.getElementById('submitBtn');
        const alertContainer = document.getElementById('alert-container');

        function showAlert(message, type = 'success') {
            alertContainer.innerHTML = `<div class="alert alert-${type}">${message}</div>`;
            setTimeout(() => {
                alertContainer.innerHTML = '';
            }, 5000);
        }

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            submitBtn.disabled = true;
            submitBtn.textContent = 'Mendaftar...';

            const formData = new FormData(form);

            try {
                const response = await fetch('/register', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                });

                // Cek apakah response adalah JSON
                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    const text = await response.text();
                    throw new Error('Response bukan JSON: ' + text.substring(0, 100));
                }

                const data = await response.json();

                if (data.status === 'success') {
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    } else {
                        window.location.href = '/register/success';
                    }
                } else {
                    const errorMsg = data.message || 'Terjadi kesalahan';
                    showAlert(errorMsg, 'error');
                }
            } catch (error) {
                console.error('Registration error:', error);
                showAlert('Terjadi kesalahan saat mengirim data: ' + error.message, 'error');
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Daftar';
            }
        });
    </script>
</body>
</html>


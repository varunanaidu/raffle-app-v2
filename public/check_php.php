<!DOCTYPE html>
<html>
<head>
    <title>PHP Extension Checker</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .success { color: green; }
        .error { color: red; }
        .info { background: #f0f0f0; padding: 15px; margin: 10px 0; border-radius: 5px; }
        pre { background: #f5f5f5; padding: 10px; border-radius: 5px; }
    </style>
</head>
<body>
    <h1>PHP Extension Checker</h1>
    
    <div class="info">
        <h2>Status Extension:</h2>
        <p>
            <strong>mysqli:</strong> 
            <?php if (extension_loaded('mysqli')): ?>
                <span class="success">✓ Aktif</span>
            <?php else: ?>
                <span class="error">✗ Tidak Aktif</span>
            <?php endif; ?>
        </p>
        <p>
            <strong>pdo_mysql:</strong> 
            <?php if (extension_loaded('pdo_mysql')): ?>
                <span class="success">✓ Aktif</span>
            <?php else: ?>
                <span class="error">✗ Tidak Aktif</span>
            <?php endif; ?>
        </p>
    </div>

    <div class="info">
        <h2>Informasi PHP:</h2>
        <p><strong>PHP Version:</strong> <?= phpversion() ?></p>
        <p><strong>php.ini Location:</strong> <?= php_ini_loaded_file() ?></p>
        <p><strong>Loaded php.ini:</strong> <?= php_ini_loaded_file() ?></p>
    </div>

    <?php if (!extension_loaded('mysqli') && !extension_loaded('pdo_mysql')): ?>
    <div class="info">
        <h2>Cara Mengaktifkan Extension mysqli:</h2>
        <ol>
            <li>Buka file php.ini di lokasi: <code><?= php_ini_loaded_file() ?></code></li>
            <li>Cari baris: <code>;extension=mysqli</code></li>
            <li>Hapus tanda <code>;</code> di depan, menjadi: <code>extension=mysqli</code></li>
            <li>Jika tidak ada, tambahkan baris: <code>extension=mysqli</code></li>
            <li>Simpan file php.ini</li>
            <li><strong>RESTART Apache/XAMPP</strong> (penting!)</li>
            <li>Refresh halaman ini untuk mengecek ulang</li>
        </ol>
        
        <h3>Atau untuk XAMPP:</h3>
        <ol>
            <li>Buka XAMPP Control Panel</li>
            <li>Klik "Config" di sebelah Apache</li>
            <li>Pilih "PHP (php.ini)"</li>
            <li>Cari <code>;extension=mysqli</code></li>
            <li>Hapus tanda <code>;</code></li>
            <li>Simpan dan restart Apache</li>
        </ol>
    </div>
    <?php endif; ?>

    <div class="info">
        <h2>Semua Extension yang Terpasang:</h2>
        <pre><?php print_r(get_loaded_extensions()); ?></pre>
    </div>
</body>
</html>


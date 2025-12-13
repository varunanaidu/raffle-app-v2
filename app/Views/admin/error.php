<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<div class="alert alert-danger" role="alert">
    <h4 class="alert-heading"><?= esc($title ?? 'Error') ?></h4>
    <p><?= esc($error ?? 'Terjadi kesalahan') ?></p>
    <hr>
    <p class="mb-0">
        <strong>Solusi:</strong><br>
        1. Pastikan extension mysqli atau pdo_mysql sudah diaktifkan di php.ini<br>
        2. Restart web server (Apache/XAMPP)<br>
        3. Periksa konfigurasi database di app/Config/Database.php
    </p>
</div>

<?= $this->endSection() ?>


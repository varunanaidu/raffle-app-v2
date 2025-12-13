<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger" role="alert">
        <strong>Error:</strong> <?= esc($error) ?>
    </div>
<?php endif; ?>

<h4>Registrants</h4>
<!-- <a href="<?= site_url('admin/sync') ?>" class="btn-sync">🔄 Sync from Google Form</a> -->

<?php if (empty($registrants)): ?>
    <p>Tidak ada data registrant.</p>
<?php else: ?>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Bisnis Unit</th>
                <th>Company</th>
                <th>Registered At</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($registrants as $reg): ?>
            <tr>
                <td><?= esc($reg['name'] ?? '-') ?></td>
                <td><?= esc($reg['email'] ?? '-') ?></td>
                <td><?= esc($reg['phone_number'] ?? '-') ?></td>
                <td><?= esc($reg['bisnis_unit'] ?? '-') ?></td>
                <td><?= esc($reg['company'] ?? '-') ?></td>
                <td><?= esc($reg['created_at'] ?? '-') ?></td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
<?php endif; ?>

<?= $this->endSection() ?>

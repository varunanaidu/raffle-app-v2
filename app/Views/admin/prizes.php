<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger" role="alert">
        <strong>Error:</strong> <?= esc($error) ?>
        <br><small>Pastikan extension mysqli atau pdo_mysql sudah diaktifkan di php.ini</small>
    </div>
<?php endif; ?>

<h4>Manage Prizes</h4>
<form action="<?= base_url('admin/savePrize') ?>" method="post" enctype="multipart/form-data">
    <?php if (isset($prize['id'])): ?>
        <input type="hidden" name="id" value="<?= $prize['id'] ?>">
    <?php endif; ?>

    <div class="mb-3">
        <label for="name" class="form-label">Nama Hadiah</label>
        <input type="text" class="form-control" name="name" id="name" value="<?= esc($prize['name'] ?? '') ?>" required>
    </div>

    <div class="mb-3">
        <label for="stock" class="form-label">Jumlah Pemenang</label>
        <input type="number" class="form-control" name="stock" id="stock" value="<?= esc($prize['stock'] ?? '') ?>" required>
    </div>

    <div class="mb-3">
        <label for="image" class="form-label">Gambar Hadiah</label>
        <input type="file" class="form-control" name="image" id="image" accept="image/*">
        <?php if (!empty($prize['image'])): ?>
            <p class="mt-2">Gambar saat ini:</p>
            <img src="<?= base_url('uploads/prizes/' . $prize['image']) ?>" alt="Prize Image" class="img-fluid" style="max-height: 200px;">
            <?php endif; ?>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>


<table class="table mt-4">
    <thead><tr><th>Name</th><th>Stock</th><th>Action</th></tr></thead>
    <tbody>
    <?php if (!empty($prizes)): ?>
        <?php foreach ($prizes as $prize): ?>
            <tr>
                <td><?= esc($prize['name']) ?></td>
                <td><?= esc($prize['stock']) ?></td>
                <td><a href="/admin/deletePrize/<?= $prize['id'] ?>" class="btn btn-sm btn-danger">Delete</a></td>
            </tr>
        <?php endforeach ?>
    <?php else: ?>
        <tr>
            <td colspan="3" class="text-center">Tidak ada data hadiah</td>
        </tr>
    <?php endif ?>
    </tbody>
</table>

<?= $this->endSection() ?>

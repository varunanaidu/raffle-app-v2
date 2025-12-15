<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger" role="alert">
        <strong>Error:</strong> <?= esc($error) ?>
    </div>
<?php endif; ?>

<h4>Registrants</h4>
<!-- <a href="<?= site_url('admin/sync') ?>" class="btn-sync">🔄 Sync from Google Form</a> -->

<div class="mb-3">
    <button 
        type="button" 
        class="btn btn-danger btn-sm reset-registrants-btn" 
        title="Hapus semua data registrant">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
        </svg>
        Reset Registrants
    </button>
</div>

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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const resetBtn = document.querySelector('.reset-registrants-btn');
    if (resetBtn) {
        resetBtn.addEventListener('click', function() {
            if (!confirm('Yakin ingin menghapus semua data registrant? Tindakan ini tidak dapat dibatalkan!')) {
                return;
            }

            // Disable button
            this.disabled = true;
            const originalText = this.innerHTML;
            this.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Resetting...';

            // Send AJAX request
            fetch('/admin/reset-registrants', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Berhasil menghapus semua data registrant!');
                    location.reload();
                } else {
                    alert('Error: ' + (data.message || 'Failed to reset'));
                    this.disabled = false;
                    this.innerHTML = originalText;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error: Failed to reset');
                this.disabled = false;
                this.innerHTML = originalText;
            });
        });
    }
});
</script>

<?= $this->endSection() ?>

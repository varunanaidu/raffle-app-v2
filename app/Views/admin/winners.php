<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<h4>Winner List</h4>

<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Phone Number</th>
            <th>Company</th>
            <th>Prize</th>
            <th>Status</th>
            <th>Won At</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($winners as $i => $winner): ?>
            <tr id="winner-row-<?= esc($winner['id']) ?>">
                <td><?= esc($winner['name']) ?></td>
                <td><?= esc($winner['phone_number']) ?></td>
                <td><?= esc($winner['company']) ?></td>
                <td><?= esc($winner['prize']) ?></td>
                <td>
                    <span class="badge <?= ($winner['status'] ?? 'Pending') === 'Done' ? 'bg-success' : 'bg-warning' ?>">
                        <?= esc($winner['status'] ?? 'Pending') ?>
                    </span>
                </td>
                <td><?= esc($winner['created_at']) ?></td>
                <td>
                    <?php if (($winner['status'] ?? 'Pending') !== 'Done'): ?>
                        <button 
                            type="button" 
                            class="btn btn-sm btn-outline-success mark-done-btn" 
                            data-winner-id="<?= esc($winner['id']) ?>"
                            title="Mark as picked up">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 2.384 4.323a.75.75 0 0 1 1.06-1.061l4.033 4.033a.75.75 0 0 1 1.08-.022l3.992-4.99a.75.75 0 0 1 1.071 1.05z"/>
                            </svg>
                        </button>
                    <?php else: ?>
                        <span class="text-success">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 2.384 4.323a.75.75 0 1 0-1.06 1.061L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                            </svg>
                        </span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const markDoneButtons = document.querySelectorAll('.mark-done-btn');
    
    markDoneButtons.forEach(button => {
        button.addEventListener('click', function() {
            const winnerId = this.getAttribute('data-winner-id');
            const row = document.getElementById('winner-row-' + winnerId);
            
            // Disable button to prevent multiple clicks
            this.disabled = true;
            this.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span>';
            
            // Create form data
            const formData = new FormData();
            formData.append('winner_id', winnerId);
            
            // Send AJAX request
            fetch('/admin/update-winner-status', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Update status badge
                    const statusCell = row.querySelector('td:nth-child(5)');
                    statusCell.innerHTML = '<span class="badge bg-success">Done</span>';
                    
                    // Update action cell
                    const actionCell = row.querySelector('td:nth-child(7)');
                    actionCell.innerHTML = '<span class="text-success"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 2.384 4.323a.75.75 0 1 0-1.06 1.061L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/></svg></span>';
                } else {
                    alert('Error: ' + (data.message || 'Failed to update status'));
                    // Re-enable button
                    this.disabled = false;
                    this.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 2.384 4.323a.75.75 0 0 1 1.06-1.061l4.033 4.033a.75.75 0 0 1 1.08-.022l3.992-4.99a.75.75 0 0 1 1.071 1.05z"/></svg>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error: Failed to update status');
                // Re-enable button
                this.disabled = false;
                this.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 2.384 4.323a.75.75 0 0 1 1.06-1.061l4.033 4.033a.75.75 0 0 1 1.08-.022l3.992-4.99a.75.75 0 0 1 1.071 1.05z"/></svg>';
            });
        });
    });
});
</script>

<?= $this->endSection() ?>

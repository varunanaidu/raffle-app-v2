<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<h2 class="mb-4">Select Grand Prize</h2>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Prize</th>
            <th>Stock</th>
            <th>Raffled</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($grandPrizes)): ?>
            <?php foreach ($grandPrizes as $prize): ?>
                <tr>
                    <td><?= esc($prize['name']) ?></td>
                    <td><?= esc($prize['stock']) ?></td>
                    <td><?= esc($prize['raffled'] ?? 0) ?></td>
                    <td class="d-flex gap-2">

                        <!-- Pilih Hadiah (first-time only) -->
                        <form action="<?= base_url('admin/save-grand-prize-selection') ?>" method="post" onsubmit="openGrandPrizeTab(event)">
                            <input type="hidden" name="prize_id" value="<?= $prize['id'] ?>">
                            <button type="submit"
                                class="btn btn-warning fw-bold <?= (!empty($prize['raffled'])) ? 'btn-disabled' : '' ?>"
                                <?= (!empty($prize['raffled'])) ? 'disabled' : '' ?>>
                                <?= (!empty($prize['raffled'])) ? 'Selesai' : 'Pilih Hadiah' ?>
                            </button>
                        </form>


                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="text-center">No grand prizes found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<script>
function openGrandPrizeTab(event) {
    event.preventDefault();
    const form = event.target;
    const prizeId = form.querySelector('input[name="prize_id"]').value;

    window.open("<?= base_url('admin/grandprize') ?>/" + prizeId, "_blank");

    setTimeout(() => {
        form.submit();
    }, 300);
}
</script>

<?= $this->endSection() ?>

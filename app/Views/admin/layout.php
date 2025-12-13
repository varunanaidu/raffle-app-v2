<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - Raffle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>

<?php if (empty($hideNavbar)): ?>
<div class="container mt-4">
    <h2 class="mb-4">🎁 Admin Panel - Raffle System</h2>

    <nav>
        <a href="/admin" class="btn btn-outline-primary btn-sm">Dashboard</a>
        <a href="/admin/prizes" class="btn btn-outline-primary btn-sm">Prizes</a>
        <a href="/admin/registrants" class="btn btn-outline-primary btn-sm">Registrants</a>
        <a href="/admin/winners" class="btn btn-outline-primary btn-sm">Winners</a>
        <a href="/admin/select-prize" class="btn btn-outline-primary btn-sm">Select Doorprize</a>
        <a href="/admin/select-grandprize" class="btn btn-outline-primary btn-sm">Select Grandprize</a>
    </nav>

    <hr>
<?php endif; ?>

<?= $this->renderSection('content') ?>

<?php if (empty($hideNavbar)): ?>
</div>
<?php endif; ?>

</body>
</html>

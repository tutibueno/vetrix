<!DOCTYPE html>
<html lang="pt-br">

<?php
// $clinica deve ser passado pelo controller
?>
<header class="bg-white shadow-sm mb-4">
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <div class="container py-3 d-flex align-items-center justify-content-center flex-column text-center">
        <?php if (!empty($clinica['logo'])): ?>
            <img src="<?= base_url('uploads/clinica/' . $clinica['logo']) ?>" alt="Logo da Clínica"
                class="mb-2" style="max-height: 80px;">
        <?php endif; ?>
        <h2 class="mb-0"><?= esc($clinica['nome_clinica']) ?></h2>
        <?php if (!empty($clinica['crmv'])): ?>
            <small class="text-muted">CRMV: <?= esc($clinica['crmv']) ?></small>
        <?php endif; ?>
    </div>
</header>
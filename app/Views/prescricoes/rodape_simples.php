<?= date('d/m/Y', strtotime($prescricao['data_prescricao'])) ?><br>
Assinado Digitalmente por:<br>
<strong><?= esc($veterinario['nome']) ?></strong><br>
CRMV: <?= esc($veterinario['crmv']) ?><br><br>

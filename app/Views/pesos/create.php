<!-- Cabeçalho com título -->
<div class="modal-header bg-primary text-white">
    <h5 class="modal-title">Adicionar Peso - <?= esc($pet['nome']) ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<form action="<?= base_url('pesos/store') ?>" method="post" autocomplete="off">
    <?= $this->include('pesos/_form') ?>
</form>
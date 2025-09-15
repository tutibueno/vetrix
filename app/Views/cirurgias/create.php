<!-- Cabeçalho com título -->
<div class="modal-header bg-primary text-white">
    <h5 class="modal-title">Adicionar Cirurgia - <?= esc($pet['nome']) ?></h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="container-fluid">
    <form action="<?= base_url('cirurgias/store') ?>" method="post" autocomplete="off" id="formCirurgia">
        <?= csrf_field() ?>
        <?= $this->include('cirurgias/_form') ?>
    </form>
</div>
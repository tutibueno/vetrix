<div class="modal-header bg-primary text-white">
    <h5 class="modal-title">Editar Cirurgia - <?= esc($pet['nome']) ?></h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<form action="<?= base_url('cirurgias/update/' . $cirurgia['id']) ?>" method="post" autocomplete="off" id="formCirurgia">
    <?= csrf_field() ?>
    <?= $this->include('cirurgias/_form') ?>
</form>
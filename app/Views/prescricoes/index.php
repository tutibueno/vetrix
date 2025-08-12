<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Prescrições</h3>
        <a href="<?= site_url('prescricoes/create') ?>" class="btn btn-primary" id="btnNovaPrescricao">+ Nova Prescrição</a>
    </div>
    <div class="card-body">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <?php if (!empty($prescricoes)): ?>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Data</th>
                        <th>Pet</th>
                        <th>Veterinário</th>
                        <th>Tipo</th>
                        <th>Instruções Gerais</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($prescricoes as $p): ?>
                        <tr>
                            <td><?= esc($p['id']) ?></td>
                            <td><?= date('d/m/Y', strtotime($p['data_prescricao'])) ?></td>
                            <td><?= esc($p['pet']['nome'] ?? 'N/D') ?></td>
                            <td><?= esc($p['veterinario']['nome'] ?? 'N/D') ?></td>
                            <td><?= esc($p['tipo_prescricao']) ?></td>
                            <td><?= esc($p['instrucoes_gerais']) ?></td>
                            <td>
                                <a href="<?= site_url('prescricoes/edit/' . $p['id']) ?>" class="btn btn-sm btn-warning btnEditarPrescricao" data-id="<?= $p['id'] ?>">Editar</a>
                                <form action="<?= site_url('prescricoes/delete/' . $p['id']) ?>" method="post" style="display:inline-block;" onsubmit="return confirm('Confirma exclusão?');">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Nenhuma prescrição encontrada.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalPrescricao" tabindex="-1" role="dialog" aria-labelledby="modalPrescricaoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="modalContentPrescricao">
            <!-- Conteúdo AJAX carregado aqui -->
        </div>
    </div>
</div>

<script>
    $(function() {
        $('#btnNovaPrescricao').on('click', function(e) {
            e.preventDefault();
            $('#modalContentPrescricao').html('<div class="p-4 text-center">Carregando...</div>');
            $('#modalPrescricao').modal('show');
            $.get($(this).attr('href'), function(data) {
                $('#modalContentPrescricao').html(data);
            });
        });

        $('.btnEditarPrescricao').on('click', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');
            $('#modalContentPrescricao').html('<div class="p-4 text-center">Carregando...</div>');
            $('#modalPrescricao').modal('show');
            $.get(url, function(data) {
                $('#modalContentPrescricao').html(data);
            });
        });
    });
</script>

<?= $this->endSection() ?>
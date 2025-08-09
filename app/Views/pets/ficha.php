<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Ficha de <?= esc($pet['nome']) ?></h3>
    </div>
    <div class="card-body">
        <?php if ($pet['foto']): ?>
            <div class="mb-3 text-center">
                <img src="<?= base_url('uploads/pets/' . $pet['foto']) ?>" alt="Foto do pet" class="img-thumbnail" style="max-height: 300px;">
            </div>
        <?php endif; ?>

        <p><strong>Espécie:</strong> <?= esc($pet['especie']) ?></p>
        <p><strong>Raça:</strong> <?= esc($pet['raca']) ?></p>
        <p><strong>Sexo:</strong> <?= esc($pet['sexo']) ?></p>
        <p><strong>Data de Nascimento:</strong> <?= esc(date('d/m/Y', strtotime($pet['data_nascimento']))) ?></p>
        <p><strong>Tutor:</strong> <?= esc($pet['nome_tutor']) ?> - <?= esc($pet['telefone']) ?></p>
        <p><strong>Observações:</strong> <?= esc($pet['observacoes']) ?></p>

        <div class="mb-3">
            <button class="btn btn-primary" id="btnAdicionarAtendimento" data-pet="<?= $pet['id'] ?>">
                <i class="fas fa-notes-medical"></i> Adicionar Atendimento
            </button>
            <button class="btn btn-success" id="btnAdicionarVacina" data-pet="<?= $pet['id'] ?>">
                <i class="fas fa-syringe"></i> Adicionar Vacinação
            </button>
        </div>

        <hr>

        <h5>📋 Histórico Médico</h5>
        <?php if ($historico): ?>
            <ul class="list-group mb-4">
                <?php foreach ($historico as $h): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong><?= date('d/m/Y', strtotime($h['data_consulta'])) ?>:</strong>
                            <?= esc($h['diagnostico']) ?> (<?= esc($h['veterinario_nome'] ?? 'Não informado') ?>)
                        </div>
                        <div>
                            <button class="btn btn-sm btn-warning" onclick="editarAtendimento(<?= $h['id'] ?>)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <a href="<?= base_url('historico_medico/delete/' . $h['id']) ?>"
                                class="btn btn-sm btn-danger"
                                onclick="return confirm('Tem certeza que deseja excluir este atendimento?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Nenhum atendimento registrado.</p>
        <?php endif; ?>

        <h5>💉 Vacinas</h5>
        <?php if ($vacinas): ?>
            <ul class="list-group">
                <?php foreach ($vacinas as $v): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong><?= esc($v['nome_vacina']) ?></strong> - <?= date('d/m/Y', strtotime($v['data_aplicacao'])) ?>
                            <?php if ($v['data_reforco']): ?>
                                <br><small>Próxima: <?= date('d/m/Y', strtotime($v['data_reforco'])) ?></small>
                            <?php endif; ?>
                            <br><small><?= esc($v['veterinario_nome'] ?? 'Veterinário não informado') ?></small>
                        </div>
                        <div>
                            <button class="btn btn-sm btn-warning" onclick="editarVacina(<?= $v['id'] ?>)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <a href="<?= base_url('vacinas/delete/' . $v['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Remover vacina?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Nenhuma vacina registrada.</p>
        <?php endif; ?>
    </div>
</div>

<div class="modal fade" id="modalFormulario" tabindex="-1" role="dialog" aria-labelledby="modalFormularioLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="modalContent">
            <!-- Conteúdo AJAX será carregado aqui -->
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#btnAdicionarAtendimento').on('click', function() {
            const petId = $(this).data('pet');
            $('#modalContent').html('<div class="text-center p-4">Carregando...</div>');
            $('#modalFormulario').modal('show');
            $.get("<?= base_url('historico_medico/create') ?>/" + petId, function(data) {
                $('#modalContent').html(data);
            });
        });

        $('#btnAdicionarVacina').on('click', function() {
            const petId = $(this).data('pet');
            $('#modalContent').html('<div class="text-center p-4">Carregando...</div>');
            $('#modalFormulario').modal('show');
            $.get("<?= base_url('vacinas/nova') ?>/" + petId, function(data) {
                $('#modalContent').html(data);
            });
        });
    });
</script>

<script>
    function editarVacina(id) {
        $('#modalContent').html('<div class="text-center p-4">Carregando...</div>');
        $('#modalFormulario').modal('show');
        $.get("<?= base_url('vacinas/editar') ?>/" + id, function(data) {
            $('#modalContent').html(data);
        });
    }
</script>

<script>
    function editarAtendimento(id) {
        $('#modalContent').html('<div class="text-center p-4">Carregando...</div>');
        $('#modalFormulario').modal('show');
        $.get("<?= base_url('historico_medico/edit') ?>/" + id, function(data) {
            $('#modalContent').html(data);
        });
    }
</script>

<?= $this->endSection() ?>
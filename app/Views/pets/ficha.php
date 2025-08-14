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

        <p>
            <strong>Está Vivo:</strong>
            <?= $pet['esta_vivo'] === 'sim' ? '<span class="badge badge-success">Sim</span>' : '<span class="badge badge-danger">Não</span>' ?>
        </p>
        <p><strong>Espécie:</strong> <?= esc($pet['especie']) ?></p>
        <p><strong>Raça:</strong> <?= esc($pet['raca']) ?></p>
        <p><strong>Sexo:</strong> <?= esc($pet['sexo']) ?></p>
        <p><strong>Data de Nascimento:</strong> <?= esc(date('d/m/Y', strtotime($pet['data_nascimento']))) ?></p>
        <p><strong>Tutor:</strong> <?= esc($pet['nome_tutor']) ?> - <?= esc($pet['telefone']) ?></p>
        <p><strong>Observações:</strong> <?= esc($pet['observacoes']) ?></p>
        <p><strong>Castrado:</strong> <?= ucfirst($pet['castrado']) ?></p>
        <p><strong>Peso:</strong> <?= $pet['peso'] ? number_format($pet['peso'], 2, ',', '.') . ' kg' : 'Não informado' ?></p>
        <p><strong>Pelagem:</strong> <?= $pet['pelagem'] ?: 'Não informada' ?></p>
        <p><strong>Número de Identificação:</strong> <?= $pet['numero_identificacao'] ?: 'Não informado' ?></p>
        <p><strong>Alergias:</strong> <?= $pet['alergias'] ?: 'Nenhuma' ?></p>
        <div class="mb-3">
            <button class="btn btn-primary" id="btnAdicionarAtendimento" data-pet="<?= $pet['id'] ?>">
                <i class="fas fa-notes-medical"></i> &plus; Atendimento
            </button>
            <button class="btn btn-primary" id="btnAdicionarVacina" data-pet="<?= $pet['id'] ?>">
                <i class="fas fa-syringe"></i> &plus; Vacinação
            </button>
            <button class="btn btn-primary" id="btnAdicionarPrescricao" data-pet="<?= $pet['id'] ?>">
                <i class="fas fa-file-medical"></i> &plus; Prescrição
            </button>
            <button class="btn btn-primary" id="btnAdicionarExame" data-pet="<?= $pet['id'] ?>">
                <i class="fas fa-book-medical"></i> &plus; Exame
            </button>
        </div>

        <hr>

        <h5>📋 Histórico Médico</h5>
        <?php if ($historico): ?>
            <ul class="list-group mb-4">
                <?php foreach ($historico as $h): ?>
                    <li class="list-group-item">
                        <strong><?= date('d/m/Y', strtotime($h['data_consulta'])) ?>:</strong>
                        <br><strong>Veterinário:</strong> <?= esc($h['veterinario_nome'] ?? 'Não informado') ?>
                        <br><strong>Anamnese:</strong> <?= esc($h['anamnese']) ?>
                        <br><strong>Sinais Clínicos:</strong> <?= esc($h['sinais_clinicos']) ?>
                        <br><strong>Diagnóstico:</strong> <?= esc($h['diagnostico']) ?>
                        <br><strong>Prescrição Médica:</strong> <?= esc($h['prescricao_medica']) ?>
                        <br><strong>Solicitação de Exame:</strong> <?= esc($h['solicitacao_exame']) ?>
                        <br><strong>Observações:</strong> <?= esc($h['observacoes']) ?>

                        <div class="mt-2">
                            <button class="btn btn-sm btn-warning" onclick="editarAtendimento(<?= $h['id'] ?>)">
                                <i class="fas fa-edit"></i> Editar
                            </button>
                            <a href="<?= site_url('historico_medico/delete/' . $h['id']) ?>" class="btn btn-sm btn-danger"
                                onclick="return confirm('Tem certeza que deseja excluir este atendimento?');">
                                <i class="fas fa-trash"></i> Excluir
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

        <h5>Prescrições</h5>
        <?php if (!empty($prescricoes)): ?>
            <div class="accordion" id="accordionPrescricoes">
                <?php foreach ($prescricoes as $index => $prescricao): ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading<?= $index ?>">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse<?= $index ?>" aria-expanded="false" aria-controls="collapse<?= $index ?>">
                                <?= date('d/m/Y', strtotime($prescricao['data_prescricao'])) ?> -
                                <?= esc($prescricao['veterinario_nome']) ?> (<?= esc($prescricao['tipo_prescricao']) ?>)
                            </button>
                        </h2>
                        <div id="collapse<?= $index ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $index ?>"
                            data-bs-parent="#accordionPrescricoes">
                            <div class="accordion-body">
                                <strong>Instruções Gerais:</strong>
                                <p><?= nl2br(esc($prescricao['instrucoes_gerais'])) ?></p>

                                <h5>Medicamentos</h5>
                                <ul>
                                    <?php foreach ($prescricao['medicamentos'] as $med): ?>
                                        <li>
                                            <strong><?= esc($med['nome_medicamento']) ?></strong> -
                                            <?= esc($med['posologia']) ?> (<?= esc($med['quantidade']) ?>)
                                        </li>
                                    <?php endforeach; ?>
                                </ul>

                                <div class="mt-2">
                                    <button class="btn btn-sm btn-warning" onclick="editarPrescricao(<?= $prescricao['id'] ?>)">Editar</button>
                                    <button class="btn btn-sm btn-danger" onclick="excluirPrescricao(<?= $prescricao['id'] ?>)">Excluir</button>
                                    <a href="<?= site_url('prescricoes/imprimir/' . $prescricao['id']) ?>" target="_blank" class="btn btn-sm btn-secondary">
                                        <i class="fas fa-print"></i> Imprimir
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Nenhuma prescrição cadastrada.</p>
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

        $('#btnAdicionarPrescricao').on('click', function() {
            const petId = $(this).data('pet');
            $('#modalContent').html('<div class="text-center p-4">Carregando...</div>');
            $('#modalFormulario').modal('show');
            $.get("<?= base_url('prescricoes/create') ?>/" + petId, function(data) {
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

<script>
    function editarPrescricao(id) {
        $('#modalContent').html('<div class="text-center p-4">Carregando...</div>');
        $('#modalFormulario').modal('show');
        $.get("<?= base_url('prescricoes/edit') ?>/" + id, function(data) {
            $('#modalContent').html(data);
        });
    }

    function excluirPrescricao(id) {
        if (confirm('Tem certeza que deseja excluir esta prescrição?')) {
            $.post(`/prescricoes/delete/${id}`, {
                _method: 'DELETE'
            }, function() {
                location.reload();
            });
        }
    }
</script>

<?= $this->endSection() ?>
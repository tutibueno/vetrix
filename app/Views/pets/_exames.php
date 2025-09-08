<div class="card-body">
    <!-- conteúdo exames -->
    <?php if (!empty($exames)): ?>
        <?php foreach ($exames as $e): ?>
            <div class="card mb-4 border border-secondary shadow-sm">
                <div class="card-body">

                    <p class="text-muted mb-2">
                        <strong>Data da Solicitação:</strong> <?= date('d/m/Y', strtotime($e['data_solicitacao'])) ?><br>
                        <strong>Médico Responsável:</strong> <?= esc($e['veterinario_nome']) ?><br>
                        <strong>Observações:</strong> <?= esc($e['observacoes']) ?>
                    </p>

                    <!-- Itens de exames -->
                    <div class="row">
                        <?php if (!empty($e['itens'])): ?>
                            <?php foreach ($e['itens'] as $item): ?>
                                <div class="col-md-6">
                                    <div class="card bg-light border-0 shadow-sm mb-3">
                                        <div class="card-body">
                                            <h6 class="card-subtitle mb-2 text-primary">
                                                <i class="fas fa-vial"></i> <?= esc($item['nome_exame']) ?>
                                            </h6>
                                            <?php if (!empty($item['observacoes'])): ?>
                                                <p class="mb-1"><strong>Obs.:</strong> <?= esc($item['observacoes']) ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12">
                                <span class="badge bg-warning">Nenhum exame detalhado informado.</span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Motivos -->
                    <?php if (!empty($e['motivos'])): ?>
                        <h6 class="mt-3"><i class="fas fa-notes-medical"></i> Motivos / Suspeitas</h6>
                        <ul>
                            <?php foreach ($e['motivos'] as $motivo): ?>
                                <li><?= esc($motivo['motivo_suspeita']) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                    <!-- Botões -->
                    <div class="card-footer d-flex justify-content-end gap-2">
                        <a href="<?= base_url('exames/imprimir/' . $e['id']) ?>"
                            class="btn btn-primary btn-sm" target="_blank">
                            <i class="fas fa-print"></i> Imprimir
                        </a>
                        <button class="btn btn-sm btn-warning" onclick="editarExame(<?= $e['id'] ?>)">
                            <i class="fas fa-edit"></i> Editar
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="excluirExame(<?= $e['id'] ?>)">
                            <i class="fas fa-trash"></i> Excluir
                        </button>
                    </div>

                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="alert alert-info">
            Nenhuma solicitação de exame cadastrada para este pet.
        </div>
    <?php endif; ?>
</div>

<script>
    
    $('#btnAdicionarExame').on('click', function() {
        const petId = $(this).data('pet');
        $('#modalContent').html('<div class="text-center p-4"><i class="fas fa-spinner fa-spin"></i> Carregando...</div>');
        $('#modalFormulario').modal('show');
        $.get("<?= base_url('exames/create') ?>/" + petId, function(data) {
            $('#modalContent').html(data);
        });
    });

    function excluirExame(id) {
        if (confirm('Tem certeza que deseja excluir este exame?')) {
            $.get(`/exames/delete/${id}`, {
                _method: 'GET'
            }, function() {
                location.reload();
            });
        }
    }

    function editarExame(id) {
        $('#modalContent').html('<div class="text-center p-4"><i class="fas fa-spinner fa-spin"></i> Carregando...</div>');
        $('#modalFormulario').modal('show');
        $.get("<?= base_url('exames/edit') ?>/" + id, function(data) {
            $('#modalContent').html(data);
        });
    }
</script>
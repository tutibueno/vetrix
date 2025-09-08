<div class="card-body">
    <!-- conteúdo histórico -->
    <?php if (!empty($historico)): ?>
        <?php foreach ($historico as $h): ?>
            <div class="card mb-4 border border-secondary shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-notes-medical"></i> Registro #<?= esc($h['id']) ?>&nbsp;
                    </h5><br>
                    <p class="text-muted mb-2">
                        <strong>Data:</strong> <?= date('d/m/Y', strtotime($h['data_consulta'])) ?><br>
                        <strong>Retorno:</strong> <?= esc($h['flag_retorno']) == 'N' ? 'Não' : 'Sim' ?><br>
                        <strong>Médico(a):</strong> <?= esc($h['veterinario_nome']) ?>
                    </p>

                    <br><strong>Anamnese:</strong></br>
                    <p><?= nl2br(esc($h['anamnese'])) ?></p>


                    <br><strong>Sinais Clínicos:</strong></br>
                    <p><?= nl2br(esc($h['sinais_clinicos'])) ?></p>



                    <br><strong>Diagnóstico:</strong></br>
                    <p><?= nl2br(esc($h['diagnostico'])) ?></p>



                    <br><strong>Observações:</strong></br>
                    <p><?= nl2br(esc($h['observacoes'])) ?></p>

                </div>

                <!-- Rodapé do card com ações -->
                <div class="card-footer d-flex justify-content-end gap-2">
                    <a onclick="editarAtendimento(<?= $h['id'] ?>)" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <a href="<?= site_url('historico_medico/delete/' . $h['id']) ?>"
                        class="btn btn-sm btn-danger"
                        onclick="return confirm('Tem certeza que deseja excluir este registro?')">
                        <i class="fas fa-trash"></i> Excluir
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="alert alert-info">
            Nenhum registro de histórico médico cadastrado para este pet.
        </div>
    <?php endif; ?>
</div>

<script>
    $('#btnAdicionarAtendimento').on('click', function() {
        const petId = $(this).data('pet');
        $('#modalContent').html('<div class="text-center p-4"><i class="fas fa-spinner fa-spin"></i> Carregando...</div>');
        $('#modalFormulario').modal('show');
        $.get("<?= base_url('historico_medico/create') ?>/" + petId, function(data) {
            $('#modalContent').html(data);
        });
    });

    function editarAtendimento(id) {
        $('#modalContent').html('<div class="text-center p-4"><i class="fas fa-spinner fa-spin"></i> Carregando...</div>');
        $('#modalFormulario').modal('show');
        $.get("<?= base_url('historico_medico/edit') ?>/" + id, function(data) {
            $('#modalContent').html(data);
        });
    }
</script>
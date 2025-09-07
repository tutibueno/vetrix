<button class="btn btn-primary mb-3" id="btnAdicionarVacina" data-pet="<?= $pet['id'] ?>">
    <i class="fas fa-plus"></i> Vacina
</button>
<div class="card-body">
    <!-- conteúdo vacinas -->
    <?php if (!empty($vacinas)): ?>
        <div class="row">
            <?php foreach ($vacinas as $v): ?>
                <div class="col-12">
                    <div class="card bg-light shadow-sm mb-3">
                        <div class="card-body">
                            <h6 class="card-subtitle mb-2 text-success">
                                <i class="fas fa-syringe"></i> <?= esc($v['nome_vacina']) ?>
                            </h6>
                            <p class="mb-1"><strong>Data:</strong> <?= date('d/m/Y', strtotime($v['data_aplicacao'])) ?></p>
                            <p class="mb-1"><strong>Data Reforço:</strong> <?= !empty($v['data_reforco']) ? date('d/m/Y', strtotime($v['data_reforco'])) : '-' ?></p>
                            <p class="mb-1"><strong>Observações:</strong> <?= $v['observacoes'] ?></p>
                        </div>
                        <!-- Rodapé do card com ações -->
                        <div class="card-footer d-flex justify-content-end gap-2">
                            <a class="btn btn-sm btn-warning" onclick="editarVacina(<?= $v['id'] ?>)">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <a href="<?= base_url('vacinas/delete/' . $v['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Remover vacina?')">
                                <i class="fas fa-trash"></i> Excluir
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info">Nenhuma vacina cadastrada para este pet.</div>
    <?php endif; ?>

</div>

<script>
    function editarVacina(id) {
        $('#modalContent').html('<div class="text-center p-4"><i class="fas fa-spinner fa-spin"></i> Carregando...</div>');
        $('#modalFormulario').modal('show');
        $.get("<?= base_url('vacinas/editar') ?>/" + id, function(data) {
            $('#modalContent').html(data);
        });
    }

    $('#btnAdicionarVacina').on('click', function() {
        const petId = $(this).data('pet');
        $('#modalContent').html('<div class="text-center p-4"><i class="fas fa-spinner fa-spin"></i> Carregando...</div>');
        $('#modalFormulario').modal('show');
        $.get("<?= base_url('vacinas/nova') ?>/" + petId, function(data) {
            $('#modalContent').html(data);
        });
    });
    
</script>
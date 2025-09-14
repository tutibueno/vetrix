<div class="card-body">
    <!-- conteúdo prescrições -->
    <?php if (!empty($prescricoes)): ?>
        <?php foreach ($prescricoes as $p): ?>
            <div class="card mb-4 border border-secondary shadow-sm">
                <div class="card-body">


                    <p class="text-muted mb-2">
                        <strong>Data:</strong> <?= date('d/m/Y', strtotime($p['data_prescricao'])) ?>
                        <br>
                        <strong>Médico Responsável:</strong> <?= esc($p['veterinario_nome']) ?>
                        <br>
                        <strong>Tipo de Receita:</strong> <?= esc($p['tipo_prescricao']) ?>
                    </p>

                    <div class="row">
                        <?php foreach ($p['medicamentos'] as $item): ?>
                            <div class="col-md-6">
                                <div class="card bg-light border-0 shadow-sm mb-3">
                                    <div class="card-body">
                                        <h6 class="card-subtitle mb-2 text-primary">
                                            <i class="fas fa-pills"></i> <?= esc($item['nome_medicamento']) ?>
                                        </h6>
                                        <p class="mb-1"><strong>Posologia:</strong> <?= esc($item['posologia']) ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="card-footer d-flex justify-content-end gap-1">
                        <a href="<?= base_url('prescricoes/imprimir/' . $p['id']) ?>"
                            class="btn btn-primary btn-sm" target="_blank">
                            <i class="fas fa-print"></i> Imprimir
                        </a>
                        <button class="btn btn-sm btn-warning" onclick="editarPrescricao(<?= $p['id'] ?>)">
                            <i class="fas fa-edit"></i>Editar</button>
                        <button class="btn btn-sm btn-danger" onclick="excluirPrescricao(<?= $p['id'] ?>)">
                            <i class="fas fa-trash"></i>Excluir</button>

                    </div>

                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="alert alert-info">
            Nenhuma prescrição cadastrada para este pet.
        </div>
    <?php endif; ?>
</div>

<script>
    $(document).ready(function() {
        $('#btnAdicionarPrescricao').on('click', function() {
            const petId = $(this).data('pet');
            $('#modalContent').html('<div class="text-center p-4"><i class="fas fa-spinner fa-spin"></i> Carregando...</div>');
            $('#modalFormulario').modal('show');
            $.get("<?= base_url('prescricoes/create') ?>/" + petId, function(data) {
                $('#modalContent').html(data);
            });
        });
    });

    function editarPrescricao(id) {
        $('#modalContent').html('<div class="text-center p-4"><i class="fas fa-spinner fa-spin"></i> Carregando...</div>');
        $('#modalFormulario').modal('show');
        $.get("<?= base_url('prescricoes/edit') ?>/" + id, function(data) {
            $('#modalContent').html(data);
        });
    }

    function excluirPrescricao(id) {
        if (confirm('Tem certeza que deseja excluir esta prescrição?')) {
            $.get(`/prescricoes/delete/${id}`, {
                _method: 'GET'
            }, function() {
                location.reload();
            });
        }
    }

    function VisualizarImpressao(id) {

        let isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);

        if (!isMobile) {
            document.getElementById("previewContent").innerHTML =
                `<iframe src="<?= site_url('prescricoes/imprimir/') ?>${id}" style="width:100%; height:70vh; border:none;"></iframe>`;
        } else {
            document.getElementById("previewContent").innerHTML =
                `<iframe src="<?= site_url('prescricoes/imprimir/') ?>${id}" style="width:100%; height:70vh; border:none;"></iframe>`;
        }
        var modal = new bootstrap.Modal(document.getElementById('previewModal'));
        modal.show();

    }
</script>
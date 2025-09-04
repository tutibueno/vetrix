<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Agendamentos de Banho & Tosa</h3>
        <button class="btn btn-primary btn-sm" id="btnNovoBanho">Novo Agendamento</button>
    </div>
    <div class="card-body">
        <div class="row">
            <?php if (empty($banhos)): ?>
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        Nenhum agendamento encontrado.
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($banhos as $b): ?>
                    <div class="col-12">
                        <div class="card shadow-sm mb-3">
                            <?php
                            // Define ícone conforme o serviço
                            $icone = '🛁'; // padrão Banho
                            if (stripos($b['nome_servico'], 'tosa') !== false) {
                                $icone = '✂️';
                            }
                            ?>
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <?= $icone ?> <?= esc($b['pet_nome']) ?> - <?= esc($b['nome_servico']) ?>
                                </h5>
                            </div>

                            <div class="card-body">
                                <p class="card-text mb-1">
                                    <b>Data/Hora:</b> <?= date('d/m/Y H:i', strtotime($b['data_agendamento'])) ?>
                                </p>

                                <p class="card-text mb-1">
                                    <b>Duração:</b> <?= esc($b['duracao_minutos']) ?> min
                                </p>

                                <p class="card-text mb-0">
                                    <b>Status:</b>
                                    <span class="badge 
                        <?= $b['status'] == 'concluido' ? 'bg-success' : ($b['status'] == 'cancelado' ? 'bg-danger' : 'bg-warning') ?>">
                                        <?= ucfirst($b['status']) ?>
                                    </span>
                                </p>
                            </div>

                            <div class="card-footer d-flex justify-content-end">
                                <button
                                    class="btn btn-sm btn-info btnEditar"
                                    data-id="<?= $b['id'] ?>">
                                    Editar
                                </button>

                                <button
                                    class="btn btn-sm btn-danger btnExcluir"
                                    data-url="<?= site_url('banhotosa/delete/' . $b['id']) ?>">
                                    Excluir
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalBanho" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="modalBanhoContent"></div>
    </div>
</div>

<!-- JS (reutiliza seu código atual) -->
<script>
    // Abrir "Novo"
    $('#btnNovoBanho').on('click', function() {
        $.get('<?= base_url("banhotosa/create") ?>', function(html) {
            $('#modalBanhoContent').html(html);
            $('#modalBanho').modal('show');
        });
    });

    // Editar
    $('.btnEditar').on('click', function() {
        const id = $(this).data('id');
        $.get('<?= base_url("banhotosa/edit") ?>/' + id, function(html) {
            $('#modalBanhoContent').html(html);
            $('#modalBanho').modal('show');
        });
    });

    // Submissão via AJAX (_form já configurado)
    $(document).on('submit', '#formBanhoTosa', function(e) {
        e.preventDefault();
        let form = $(this);
        let url = form.attr('action');
        let method = form.attr('method') || 'POST';
        let formData = form.serialize();

        $.ajax({
            url: url,
            type: method,
            data: formData,
            dataType: 'json',
            success: function(res) {
                if (res.success) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: res.message,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    $('#modalBanho').modal('hide');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro',
                        html: res.message
                    });
                }
            },
            error: function() {
                Swal.fire('Erro', 'Erro inesperado no servidor.', 'error');
            }
        });
    });

    // Excluir
    $(document).on('click', '.btnExcluir', function(e) {
        e.preventDefault();
        const url = $(this).data('url');

        Swal.fire({
            title: 'Excluir agendamento?',
            text: "Essa ação não poderá ser desfeita.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sim, excluir',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    success: function(res) {
                        if (res.success) {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: res.message,
                                showConfirmButton: false,
                                timer: 3000
                            });
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            Swal.fire('Erro', res.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Erro', 'Erro inesperado no servidor.', 'error');
                    }
                });
            }
        });
    });
</script>

<?= $this->endSection() ?>
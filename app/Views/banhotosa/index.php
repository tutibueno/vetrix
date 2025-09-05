<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Agendamentos de Banho & Tosa</h3>
        <button class="btn btn-primary btn-sm" id="btnNovoBanho">Novo Agendamento</button>
    </div>
    <div class="card-body">
        <!-- Container dos cards -->
        <div id="banhoTosaCards" class="row"></div>
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
    $(document).ready(function() {

        // Função para carregar e renderizar os cards (usada sempre que precisar atualizar)
        function carregarAgendamentos() {
            $.getJSON("<?= site_url('banhotosa/listar-json') ?>")
                .done(function(data) {
                    let html = '';
                    if (!data || data.length === 0) {
                        html = `<div class="col-12"><div class="alert alert-info text-center">Nenhum agendamento encontrado.</div></div>`;
                    } else {
                        data.forEach(b => {
                            // formata datas
                            const inicio = new Date(b.data_hora_inicio);
                            const fim = new Date(b.data_hora_fim);

                            const inicioFmt = inicio.toLocaleString('pt-BR', {
                                day: '2-digit',
                                month: '2-digit',
                                year: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            });

                            const fimFmt = fim.toLocaleString('pt-BR', {
                                day: '2-digit',
                                month: '2-digit',
                                year: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            });

                            // calcula duração em minutos
                            const duracaoMin = Math.round((fim - inicio) / 60000);

                            // escolhe ícone
                            let icone = '🛁';
                            if (b.servico_nome && /tosa/i.test(b.servico_nome)) icone = '✂️';

                            // badge status
                            let badgeClass = 'bg-warning';
                            if (b.status === 'concluido' || b.status === 'concluído') badgeClass = 'bg-success';
                            if (b.status === 'cancelado') badgeClass = 'bg-danger';

                            html += `
                    <div class="col-12">
                        <div class="card shadow-sm mb-3">
                            <div class="card-header">
                                <h5 class="card-title mb-0">${icone} ${escapeHtml(b.pet_nome)} - ${escapeHtml(b.servico_nome)}</h5>
                            </div>
                            <div class="card-body">
                                <p class="card-text mb-1"><b>Início:</b> ${inicioFmt}</p>
                                <p class="card-text mb-1"><b>Fim:</b> ${fimFmt}</p>
                                <p class="card-text mb-1"><b>Duração:</b> ${duracaoMin} min</p>
                                <p class="card-text mb-0"><b>Status:</b>
                                    <span class="badge ${badgeClass}">${escapeHtml(capitalize(b.status))}</span>
                                </p>
                            </div>
                            <div class="card-footer d-flex justify-content-end gap-2">
                                <button class="btn btn-sm btn-info btnEditar" data-id="${b.id}">
                                    <i class="fas fa-edit"></i> Editar
                                </button>
                                <button class="btn btn-sm btn-danger btnExcluir" data-id="${b.id}">
                                    <i class="fas fa-trash"></i> Excluir
                                </button>
                            </div>
                        </div>
                    </div>`;
                        });
                    }
                    $("#banhoTosaCards").html(html);
                })
                .fail(function() {
                    $("#banhoTosaCards").html(`<div class="col-12"><div class="alert alert-danger text-center">Erro ao carregar agendamentos.</div></div>`);
                });
        }

        // funções auxiliares
        function escapeHtml(text) {
            if (text === null || text === undefined) return '';
            return String(text)
                .replace(/&/g, '&amp;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;');
        }

        function capitalize(s) {
            if (!s) return '';
            return s.charAt(0).toUpperCase() + s.slice(1);
        }

        // inicial load
        carregarAgendamentos();

        // Novo Agendamento (abre modal com form)
        $(document).on('click', '#btnNovoBanho', function(e) {
            e.preventDefault();
            $.get('<?= base_url("banhotosa/create") ?>', function(html) {
                $('#modalBanhoContent').html(html);
                $('#modalBanho').modal('show');
            }).fail(function() {
                Swal.fire('Erro', 'Não foi possível abrir o formulário.', 'error');
            });
        });

        // Editar (delegated - funciona para botões recém-inseridos)
        $(document).on('click', '.btnEditar', function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            if (!id) return Swal.fire('Erro', 'ID do agendamento não encontrado.', 'error');

            $.get('<?= base_url("banhotosa/edit") ?>/' + id, function(html) {
                $('#modalBanhoContent').html(html);
                $('#modalBanho').modal('show');
            }).fail(function() {
                Swal.fire('Erro', 'Não foi possível carregar o formulário de edição.', 'error');
            });
        });

        // Submit do form dentro do modal (delegated)
        $(document).on('submit', '#formBanhoTosa', function(e) {
            e.preventDefault();
            let form = $(this);
            let url = form.attr('action');
            let method = form.attr('method') || 'POST';
            let data = form.serialize();

            $.ajax({
                url: url,
                type: method,
                data: data,
                dataType: 'json'
            }).done(function(res) {
                if (res.success) {
                    $('#modalBanho').modal('hide');
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: res.message,
                        showConfirmButton: false,
                        timer: 2500
                    });
                    carregarAgendamentos();
                } else {
                    let msg = res.message || 'Erro ao salvar.';
                    if (res.errors) msg += '<br>' + Object.values(res.errors).join('<br>');
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro',
                        html: msg
                    });
                }
            }).fail(function(xhr) {
                Swal.fire('Erro', xhr.responseText || 'Erro inesperado no servidor.', 'error');
            });
        });

        // Excluir (delegated). Usa POST para /banhotosa/delete/{id}
        $(document).on('click', '.btnExcluir', function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            if (!id) return Swal.fire('Erro', 'ID do agendamento não encontrado.', 'error');

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
                        url: '<?= site_url('banhotosa/delete') ?>/' + id,
                        type: 'POST',
                        dataType: 'json'
                    }).done(function(res) {
                        if (res.success) {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: res.message || 'Excluído',
                                showConfirmButton: false,
                                timer: 2000
                            });
                            carregarAgendamentos();
                        } else {
                            Swal.fire('Erro', res.message || 'Não foi possível excluir.', 'error');
                        }
                    }).fail(function(xhr) {
                        Swal.fire('Erro', xhr.responseJSON?.message || 'Erro inesperado no servidor.', 'error');
                    });
                }
            });
        });

    });
</script>

<?= $this->endSection() ?>
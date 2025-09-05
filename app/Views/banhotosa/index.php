<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Agendamentos de Banho & Tosa</h3>
        <button class="btn btn-primary btn-sm" id="btnNovoBanho">Novo Agendamento</button>
    </div>
    <div class="card-body">

        <!-- Tabs -->
        <ul class="nav nav-tabs" id="banhoTosaTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="tab-calendario" data-bs-toggle="tab" href="#calendario" role="tab">Calendário</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-lista" data-bs-toggle="tab" href="#lista" role="tab">Lista</a>
            </li>
        </ul>

        <div class="tab-content mt-3" id="banhoTosaTabContent">
            <!-- FullCalendar Tab -->
            <div class="tab-pane fade show active" id="calendario" role="tabpanel">
                <div id="fullCalendar"></div>
            </div>

            <!-- Lista Tab -->
            <div class="tab-pane fade" id="lista" role="tabpanel">
                <div id="banhoTosaCards" class="row"></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalBanho" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="modalBanhoContent"></div>
    </div>
</div>

<!-- Scripts -->
<script src="<?= base_url('public/fullcalendar/dist/index.global.min.js') ?>"></script>


<!-- Modal -->
<div class="modal fade" id="modalBanho" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="modalBanhoContent"></div>
    </div>
</div>

<script>
    var calendar;

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('fullCalendar');

        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'pt-br',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            selectable: true, // habilita seleção de horários
            dateClick: function(info) {
                if (calendar.view.type === 'timeGridDay' || calendar.view.type === 'timeGridWeek') {
                    // info.dateStr vem tipo "2025-09-05T14:30:00+00:00"
                    let dt = new Date(info.date);
                    let ano = dt.getFullYear();
                    let mes = String(dt.getMonth() + 1).padStart(2, '0');
                    let dia = String(dt.getDate()).padStart(2, '0');
                    let hora = String(dt.getHours()).padStart(2, '0');
                    let min = String(dt.getMinutes()).padStart(2, '0');

                    let formatted = `${ano}-${mes}-${dia}T${hora}:${min}`;

                    // abrir modal e preencher input
                    $.get('<?= base_url("banhotosa/create") ?>', function(html) {
                        $('#modalBanhoContent').html(html);
                        $('#modalBanho').modal('show');

                        $('#data_hora_inicio').val(formatted);
                    });
                } else {
                    calendar.changeView('timeGridDay', info.dateStr);
                }
            },
            events: function(fetchInfo, successCallback, failureCallback) {
                $.getJSON("<?= site_url('banhotosa/listar-json') ?>", function(data) {
                    let eventos = data.map(b => {
                        let duracaoMinutos = Math.round((new Date(b.data_hora_fim) - new Date(b.data_hora_inicio)) / 60000);

                        // Definir cores conforme o status
                        let corFundo = '#3788d8'; // azul padrão
                        let corBorda = '#276ba0';
                        if (b.status === 'cancelado') {
                            corFundo = '#f44336'; // vermelho
                            corBorda = '#d32f2f';
                        } else if (b.status === 'concluido') {
                            corFundo = '#4caf50'; // verde
                            corBorda = '#388e3c';
                        }

                        return {
                            id: b.id,
                            title: `${b.pet_nome} - ${b.servico_nome}`,
                            start: b.data_hora_inicio,
                            end: b.data_hora_fim,
                            backgroundColor: corFundo,
                            borderColor: corBorda,
                            textColor: 'white',
                            extendedProps: {
                                status: b.status,
                                pet: b.pet_nome,
                                servico: b.servico_nome,
                                duracao: duracaoMinutos,
                                observacoes: b.observacoes || ''
                            },
                            // Tooltip
                            titleTooltip: `Pet: ${b.pet_nome}\nServiço: ${b.servico_nome}\nStatus: ${b.status}\nDuração: ${duracaoMinutos} min\nObservações: ${b.observacoes || '-'}`
                        };
                    });
                    successCallback(eventos);
                }).fail(function() {
                    failureCallback();
                });
            },
            eventDidMount: function(info) {
                // Tooltip usando Bootstrap 5
                var tooltipText = info.event.extendedProps.observacoes ?
                    `Pet: ${info.event.extendedProps.pet}\nServiço: ${info.event.extendedProps.servico}\nStatus: ${info.event.extendedProps.status}\nDuração: ${info.event.extendedProps.duracao} min\nObservações: ${info.event.extendedProps.observacoes}` :
                    `Pet: ${info.event.extendedProps.pet}\nServiço: ${info.event.extendedProps.servico}\nStatus: ${info.event.extendedProps.status}\nDuração: ${info.event.extendedProps.duracao} min`;

                new bootstrap.Tooltip(info.el, {
                    title: tooltipText,
                    placement: 'top',
                    trigger: 'hover',
                    container: 'body',
                    html: false
                });

                // força a cor de fundo também no "month"
                if (info.event.backgroundColor) {
                    info.el.style.backgroundColor = info.event.backgroundColor;
                    info.el.style.borderColor = info.event.borderColor;
                    info.el.style.color = info.event.textColor;
                }
            },
            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            },
            eventClick: function(info) {
                const id = info.event.id;
                $.get('<?= base_url("banhotosa/edit") ?>/' + id, function(html) {
                    $('#modalBanhoContent').html(html);
                    $('#modalBanho').modal('show');
                });
            }
        });

        calendar.render();


    });
</script>

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
            // Preenche automaticamente a data/hora atual no input
            let agora = new Date();

            // Ajusta para horário local
            const localDate = new Date(agora.getTime() - agora.getTimezoneOffset() * 60000);

            // Formata YYYY-MM-DDTHH:MM para datetime-local
            const formattedDate = localDate.toISOString().slice(0, 16);

            $.get('<?= base_url("banhotosa/create") ?>', function(html) {
                $('#modalBanhoContent').html(html);
                $('#modalBanho').modal('show');
                $('#data_hora_inicio').val(formattedDate);
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
            let petId = $('#pet_id').val();
            if (!petId) {
                e.preventDefault(); // impede submissão
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: 'Por favor, selecione um Pet válido da lista.'
                });
                $('#pet_nome').focus();
                return false;
            }
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
                    // Atualiza o calendário
                    if (calendar) {
                        calendar.refetchEvents();
                    }
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
                        type: 'GET',
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
                            $('#modalBanho').modal('hide');
                            carregarAgendamentos();
                            // Atualiza o calendário
                            if (calendar) {
                                calendar.refetchEvents();
                            }
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

<style>
    /* Eventos do calendário */
    .fc-event {
        cursor: pointer !important;
    }

    /* Slots clicáveis (quando a pessoa clica no dia/hora do calendário) */
    .fc-daygrid-day,
    /* células da visão month */
    .fc-timegrid-slot {
        /* células da visão week/day */
        cursor: pointer !important;
    }

    .tooltip {
        z-index: 9999 !important;
        /* maior que o popover do FullCalendar */
    }
</style>

<?= $this->endSection() ?>
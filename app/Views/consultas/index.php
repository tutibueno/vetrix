<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Agendamentos de Cosultas</h3>
        <a onclick="novaConsulta()" class="btn btn-primary btn-sm">
            <i class="fas fa-calendar-plus"></i> Nova Consulta
        </a>
    </div>
    <div class="card-body">

        <!-- Nav Tabs -->
        <ul class="nav nav-tabs mb-3" id="consultasTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="calendario-tab" data-bs-toggle="tab" href="#calendario" role="tab" aria-controls="calendario" aria-selected="true">
                    <i class="fas fa-calendar-alt"></i> Calendário
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="lista-tab" data-bs-toggle="tab" href="#lista" role="tab" aria-controls="lista" aria-selected="false">
                    <i class="fas fa-list"></i> Lista de Consultas
                </a>
            </li>
        </ul>

        <!-- Conteúdo Tabs -->
        <div class="tab-content mt-3" id="consultasTabContent">

            <!-- CALENDÁRIO -->
            <div class="tab-pane fade show active" id="calendario" role="tabpanel" aria-labelledby="calendario-tab">
                <div class="card-body">
                    <div id="fullcalendarConsultas"></div>
                </div>
            </div>

            <!-- LISTA -->
            <div class="tab-pane fade" id="lista" role="tabpanel" aria-labelledby="lista-tab">

                <div class="row">
                    <?php if (!empty($consultas)): ?>
                        <?php foreach ($consultas as $c): ?>
                            <div class="col-12 mb-3">
                                <div class="card shadow-sm">
                                    <div class="card shadow-sm position-relative">
                                        <div class="card-body">
                                            <h5 class="mb-1">
                                                <i class="fas fa-paw text-primary"></i> <?= esc($c['pet_nome']) ?>
                                            </h5>
                                            <p class="mb-1"><strong>Tutor:</strong> <?= esc($c['cliente_nome']) ?></p>
                                            <p class="mb-1"><strong>Veterinário:</strong> <?= esc($c['vet_nome']) ?></p>
                                            <p class="mb-1"><strong>Data:</strong> <?= date('d/m/Y H:i', strtotime($c['data_consulta'])) ?></p>
                                            <p class="mb-1"><strong>Status:</strong> <?= ucfirst($c['status']) ?></p>
                                            <p class="card-text mb-1 text-muted"><small><strong>Cadastrada em:</strong> <?= esc($c['created_at']) ?></small></p>
                                            <p class="card-text mb-1 text-muted"><small><strong>Atualizada em:</strong> <?= esc($c['updated_at']) ?></small></p>
                                        </div>
                                        <div class="card-footer d-flex justify-content-end">
                                            <button class="btn btn-sm btn-warning" onclick="editarConsulta(<?= $c['id'] ?>)">
                                                <i class="fas fa-edit"></i> Editar
                                            </button>
                                            <a href="<?= site_url('consultas/delete/' . $c['id']) ?>" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Deseja cancelar esta consulta?')">
                                                <i class="fas fa-trash"></i> Excluir
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <div class="alert alert-info">Nenhuma consulta cadastrada.</div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>



<script>
    //Full calendar consultas

    var calendarConsulta;

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('fullcalendarConsultas');

        calendarConsulta = new FullCalendar.Calendar(calendarEl, {
            themeSystem: 'bootstrap5',
            initialView: 'dayGridMonth',
            locale: 'pt-br',
            timeZone: 'local',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            buttonText: {
                today: 'Hoje',
                month: 'Mês',
                week: 'Semana',
                day: 'Dia',
                list: 'Agenda'
            },
            navLinks: true, // clique em dias/semana
            editable: false,
            selectable: true,
            events: '<?= base_url("consultas/agendaJson") ?>',
            eventClick: function(info) {
                //info.jsEvent.preventDefault(); // evita navegação
                const id = info.event.id; // o id da consulta

                $('#modalGlobalContent').html('<div class="text-center p-4"><i class="fas fa-spinner fa-spin"></i> Carregando...</div>');
                $('#modalGlobal').modal('show');
                $.get('<?= base_url("consultas/edit") ?>/' + id, function(html) {
                    $('#modalGlobalContent').html(html);
                });
            },
            dateClick: function(info) {
                if (calendarConsulta.view.type === 'timeGridDay' || calendarConsulta.view.type === 'timeGridWeek') {
                    // info.dateStr vem tipo "2025-09-05T14:30:00+00:00"
                    let dt = new Date(info.date);
                    let ano = dt.getFullYear();
                    let mes = String(dt.getMonth() + 1).padStart(2, '0');
                    let dia = String(dt.getDate()).padStart(2, '0');
                    let hora = String(dt.getHours()).padStart(2, '0');
                    let min = String(dt.getMinutes()).padStart(2, '0');

                    let formatted = `${ano}-${mes}-${dia}T${hora}:${min}`;
                    $('#modalGlobalContent').html('<div class="text-center p-4"><i class="fas fa-spinner fa-spin"></i> Carregando...</div>');
                    $('#modalGlobal').modal('show');
                    // abrir modal e preencher input
                    $.get('<?= base_url("consultas/create") ?>', function(html) {
                        $('#modalGlobalContent').html(html);
                        $('#data_consulta').val(formatted);
                    });


                } else {
                    calendarConsulta.changeView('timeGridDay', info.dateStr);
                }
            },
            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            },
            eventDidMount: function(info) {

                // Desktop → cria tooltip
                let statusColor = '#007bff';
                if (info.event.extendedProps.status.toLowerCase() === 'agendada') statusColor = '#007bff';
                else if (info.event.extendedProps.status.toLowerCase() === 'realizada') statusColor = '#ffc107';
                else if (info.event.extendedProps.status.toLowerCase() === 'cancelada') statusColor = '#dc3545';

                // força a cor de fundo também no "month"
                if (info.event.backgroundColor) {
                    info.el.style.backgroundColor = info.event.backgroundColor;
                    info.el.style.borderColor = info.event.borderColor;
                    info.el.style.color = info.event.textColor;
                }

                if (window.matchMedia("(pointer: coarse)").matches) {
                    // Mobile ou tablet → não criar tooltip
                    return;
                }

                const petNome = info.event.extendedProps.retorno === 'S' ?
                    info.event.extendedProps.pet + ' (Retorno)' :
                    info.event.extendedProps.pet;

                const tooltipContent = `
                    <div style="color: #fff; background-color: ${statusColor}; padding: 5px 10px; border-radius: 4px;">
                        <strong>Pet:</strong> ${petNome}<br>
                        <strong>Veterinário:</strong> ${info.event.extendedProps.vet}<br>
                        <strong>Status:</strong> ${info.event.extendedProps.status}<br>
                        <strong>Data:</strong> ${info.event.start.toLocaleString('pt-BR', {
                day: '2-digit', month: '2-digit', year: 'numeric',
                hour: '2-digit', minute: '2-digit'
            })} - ${info.event.end.toLocaleString('pt-BR', {
                hour: '2-digit', minute: '2-digit'
            })}
                    </div>
                `;


                new bootstrap.Tooltip(info.el, {
                    title: tooltipContent,
                    html: true,
                    placement: 'top',
                    trigger: 'hover',
                    container: 'body'
                });
            },


        });

        // Render inicial
        calendarConsulta.render();

        // Render inicial
        if (document.getElementById('calendario').classList.contains('show')) {
            calendarConsulta.render();
        }

        //Resize quando trocar de tabs
        $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function() {
            calendarConsulta.updateSize();
        });


    });

    $(document).ready(function() {

        // Submit do form dentro do modal (delegated)
        $(document).on('submit', '#formConsulta', function(e) {
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
                    $('#modalGlobal').modal('hide');
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: res.message,
                        showConfirmButton: false,
                        timer: 2500
                    });
                    //carregarListaConsultas();
                    // Atualiza o calendário
                    if (calendarConsulta) {
                        calendarConsulta.refetchEvents();
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
        $(document).on('click', '.btnExcluir', '#formConsulta', function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            if (!id) return Swal.fire('Erro', 'ID da consulta não encontrado.', 'error');

            Swal.fire({
                title: 'Excluir consulta?',
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
                        url: '<?= site_url('consultas/delete') ?>/' + id,
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
                            $('#modalGlobal').modal('hide');
                            //carregarAgendamentos();
                            // Atualiza o calendário
                            if (calendarConsulta) {
                                calendarConsulta.refetchEvents();
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

    function novaConsulta() {
        let dt = new Date();
        let ano = dt.getFullYear();
        let mes = String(dt.getMonth() + 1).padStart(2, '0');
        let dia = String(dt.getDate()).padStart(2, '0');
        let hora = String(dt.getHours()).padStart(2, '0');
        let min = String(dt.getMinutes()).padStart(2, '0');

        let formatted = `${ano}-${mes}-${dia}T${hora}:${min}`;
        $('#modalGlobalContent').html('<div class="text-center p-4"><i class="fas fa-spinner fa-spin"></i> Carregando...</div>');
        $('#modalGlobal').modal('show');
        // abrir modal e preencher input
        $.get('<?= base_url("consultas/create") ?>', function(html) {
            $('#modalGlobalContent').html(html);
            $('#data_consulta').val(formatted);
        });
    }
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

    .fc-daygrid-event-dot,
    .fc-list-event-dot {
        display: none !important;
    }

    .fc .fc-button-primary {
        background-color: #3485FF !important;
        /* Desired background color */
        color: #FFFFFF !important;
        /* Desired text color */
        border-color: #3485FF !important;
        /* Desired border color */
    }
</style>

<?= $this->endSection() ?>
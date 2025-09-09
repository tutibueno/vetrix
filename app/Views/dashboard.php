<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<!-- Content Wrapper. Contains page content -->

<!-- Row: Cards Estatísticos -->
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3><?= $consultasHoje ?></h3>
                <p>Consultas Hoje</p>
            </div>
            <div class="icon">
                <i class="fas fa-calendar-day"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3><?= $consultasSemana ?></h3>
                <p>Consultas na Semana</p>
            </div>
            <div class="icon">
                <i class="fas fa-calendar-week"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3><?= $totalPets ?></h3>
                <p>Pets Cadastrados</p>
            </div>
            <div class="icon">
                <i class="fas fa-dog"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3><?= $totalTutores ?></h3>
                <p>Tutores Cadastrados</p>
            </div>
            <div class="icon">
                <i class="fas fa-user"></i>
            </div>
        </div>
    </div>
    <!-- Card Banhos Hoje -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3><?= $banhosHoje ?></h3>
                <p>Banhos & Tosas Hoje</p>
            </div>
            <div class="icon">
                <i class="fas fa-bath"></i>
            </div>
        </div>
    </div>

    <!-- Card Banhos Semana -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3><?= $banhosSemana ?></h3>
                <p>Banhos & Tosas na Semana</p>
            </div>
            <div class="icon">
                <i class="fas fa-bath"></i>
            </div>
        </div>
    </div>
</div>

<!-- Row: Gráfico + Próximas Consultas -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Consultas e Banhos & Tosas nos últimos 30 dias</h3>
            </div>
            <div class="card-body">
                <canvas id="graficoConsultas" height="150"></canvas>
            </div>
        </div>
    </div>

</div>

<div class="row">
    <!-- Consultas de Hoje -->
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">📅 Consultas de Hoje</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($consultasHojeLista)): ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($consultasHojeLista as $consulta): ?>
                            <li class="list-group-item">
                                <b><?= esc($consulta['pet_nome']) ?></b> <?= esc($consulta['flag_retorno'] == 'S' ? '(Retorno)' : '') ?> <br>
                                Tutor: <?= esc($consulta['tutor_nome']) ?> <br>
                                Vet.: <?= esc($consulta['vet_nome']) ?> <br>
                                <small class="text-muted"><?= esc($consulta['data_consulta_label']) ?></small>
                                    <span class="badge <?= esc($consulta['cor_badge']) ?>"><?= esc($consulta['status']) ?> </span>
                                
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted mb-0">Nenhuma consulta marcada para hoje.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Próximas Consultas -->
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">⏭️ Próximas Consultas</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($proximasConsultas)): ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($proximasConsultas as $consulta): ?>
                            <li class="list-group-item">
                                <b><?= esc($consulta['pet_nome']) ?></b> <?= esc($consulta['flag_retorno'] == 'S' ? '(Retorno)' : '') ?> <br>
                                Tutor: <?= esc($consulta['tutor_nome']) ?> <br>
                                Vet.: <?= esc($consulta['vet_nome']) ?> <br>
                                <small class="text-muted"><?= esc($consulta['data_consulta_label']) ?></small>
                                <p class="card-text mb-0"><small>Status:</small>
                                    <span class="badge <?= esc($consulta['cor_badge']) ?>"><?= esc($consulta['status']) ?> </span>
                                </p>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class=" text-muted mb-0">Nenhuma consulta futura agendada.
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <!-- Banhos de Hoje -->
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">🛁 Banhos & Tosas de Hoje</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($banhosHojeLista)): ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($banhosHojeLista as $banho): ?>
                            <li class="list-group-item">
                                <b><?= esc($banho['pet_nome']) ?></b><br>
                                Serviço: <?= esc($banho['servico_nome']) ?><br>
                                <small class="text-muted"><?= date('H:i', strtotime($banho['data_hora_inicio'])) ?> - <?= date('H:i', strtotime($banho['data_hora_fim'])) ?></small>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted mb-0">Nenhum banho agendado para hoje.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Próximos Banhos -->
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">⏭️ Próximos Banhos & Tosas</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($proximosBanhos)): ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($proximosBanhos as $banho): ?>
                            <li class="list-group-item">
                                <b><?= esc($banho['pet_nome']) ?></b><br>
                                Serviço: <?= esc($banho['servico_nome']) ?><br>
                                <small class="text-muted"><?= date('d/m/Y H:i', strtotime($banho['data_hora_inicio'])) ?> - <?= date('H:i', strtotime($banho['data_hora_fim'])) ?></small>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted mb-0">Nenhum banho futuro agendado.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">📆 Calendário Consultas</h5>
            </div>
            <div class="card-body">
                <div id="fullcalendarConsultas"></div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">📆 Calendário Banho & Tosa</h5>
            </div>
            <div class="card-body">
                <div id="fullCalendarBanhoTosa"></div>
            </div>
        </div>
    </div>
</div>

<!-- Row: Alertas -->
<div class="card shadow-sm mt-3">
    <div class="card-header bg-warning">
        <h5 class="mb-0">⚠️ Alertas</h5>
    </div>
    <div class="card-body">
        <?php if (!empty($alertas)): ?>
            <ul class="list-group list-group-flush">
                <?php foreach ($alertas as $alerta): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><?= $alerta['mensagem'] ?></span>
                        <a href="<?= base_url('pet/ficha/' . $alerta['pet_id']) ?>" class="btn btn-sm btn-outline-primary">
                            Ver Pet
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="text-muted mb-0">Nenhum alerta no momento.</p>
        <?php endif; ?>
    </div>
</div>



<script>
    var ctx = document.getElementById('graficoConsultas').getContext('2d');
    var graficoConsultas = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode($dias) ?>,
            datasets: [{
                    label: 'Consultas',
                    data: <?= json_encode($valoresConsultas) ?>,
                    borderColor: 'rgba(60,141,188,0.8)',
                    backgroundColor: 'rgba(60,141,188,0.4)',
                    fill: true,
                    tension: 0.3
                },
                {
                    label: 'Banhos & Tosa',
                    data: <?= json_encode($valoresBanhos) ?>,
                    borderColor: 'rgba(255,193,7,0.8)',
                    backgroundColor: 'rgba(255,193,7,0.4)',
                    fill: true,
                    tension: 0.3
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            interaction: {
                mode: 'index',
                intersect: false
            },
            scales: {
                y: {
                    beginAtZero: true,
                    stepSize: 1
                }
            }
        }
    });
</script>

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
</script>



<script>
    //Fullcalendar Banho & Tosa
    var calendarBanhoTosa;

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('fullCalendarBanhoTosa');

        calendarBanhoTosa = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            themeSystem: 'bootstrap5',
            locale: 'pt-br',
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
            selectable: true, // habilita seleção de horários
            dateClick: function(info) {
                if (calendarBanhoTosa.view.type === 'timeGridDay' || calendarBanhoTosa.view.type === 'timeGridWeek') {
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
                    $.get('<?= base_url("banhotosa/create") ?>', function(html) {
                        $('#modalGlobalContent').html(html);
                        $('#data_hora_inicio').val(formatted);
                    });
                } else {
                    calendarBanhoTosa.changeView('timeGridDay', info.dateStr);
                }
            },
            events: function(fetchInfo, successCallback, failureCallback) {
                $.getJSON("<?= site_url('banhotosa/listar-json') ?>", function(data) {
                    let eventos = data.map(b => {
                        let duracaoMinutos = Math.round((new Date(b.data_hora_fim) - new Date(b.data_hora_inicio)) / 60000);

                        // Definir cores conforme o status
                        let corFundo = '#3788d8'; // azul
                        let corBorda = '#276ba0';
                        if (b.status === 'agendado') {
                            corFundo = '#ffc30b'; // amarelo
                            corBorda = '#DEAA0D';
                        } else if (b.status === 'cancelado') {
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


            },
            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            },
            eventClick: function(info) {
                const id = info.event.id;

                $('#modalGlobalContent').html('<div class="text-center p-4"><i class="fas fa-spinner fa-spin"></i> Carregando...</div>');
                $('#modalGlobal').modal('show');
                $.get('<?= base_url("banhotosa/edit") ?>/' + id, function(html) {
                    $('#modalGlobalContent').html(html);
                });
            }
        });

        // Render inicial
        calendarBanhoTosa.render();

    });

    $(document).ready(function() {

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
                    $('#modalGlobal').modal('hide');
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: res.message,
                        showConfirmButton: false,
                        timer: 2500
                    });
                    //carregarAgendamentos();
                    // Atualiza o calendário
                    if (calendarBanhoTosa) {
                        calendarBanhoTosa.refetchEvents();
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
        $(document).on('click', '.btnExcluir', '#formBanhoTosa', function(e) {
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
                            $('#modalGlobal').modal('hide');
                            //carregarAgendamentos();
                            // Atualiza o calendário
                            if (calendarBanhoTosa) {
                                calendarBanhoTosa.refetchEvents();
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
<script>

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
</style>



<?= $this->endSection() ?>
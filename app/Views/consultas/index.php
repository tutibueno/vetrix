<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>



<!-- fullCalendar 2.2.5 -->
<!--  <script src="public/adminlte/plugins/fullcalendar/main.js"></script> -->

<!-- fullCalendar -->
<!-- <link rel="stylesheet" href="public/adminlte/plugins/fullcalendar/main.css"> -->

<script src="<?= base_url('public/fullcalendar/dist/index.global.min.js') ?>"></script>

<div class="container-fluid">
    <h1 class="mt-4">Consultas</h1>

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
    <div class="tab-content" id="consultasTabContent">

        <!-- CALENDÁRIO -->
        <div class="tab-pane fade show active" id="calendario" role="tabpanel" aria-labelledby="calendario-tab">
            <div class="card shadow rounded-2xl">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-calendar-alt"></i> Agenda de Consultas</h3>
                </div>
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>

        <!-- LISTA -->
        <div class="tab-pane fade" id="lista" role="tabpanel" aria-labelledby="lista-tab">
            <a onclick="novaConsulta()" class="btn btn-primary mb-3">
                <i class="fas fa-calendar-plus"></i> Nova Consulta
            </a>


            <div class="row">
                <?php if (!empty($consultas)): ?>
                    <?php foreach ($consultas as $c): ?>
                        <div class="col-12 mb-3">
                            <div class="card shadow-sm">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-1">
                                            <i class="fas fa-paw text-primary"></i> <?= esc($c['pet_nome']) ?>
                                        </h5>
                                        <p class="mb-1"><strong>Tutor:</strong> <?= esc($c['cliente_nome']) ?></p>
                                        <p class="mb-1"><strong>Veterinário:</strong> <?= esc($c['vet_nome']) ?></p>
                                        <p class="mb-1"><strong>Data:</strong> <?= date('d/m/Y H:i', strtotime($c['data_consulta'])) ?></p>
                                        <p class="mb-1"><strong>Status:</strong> <?= ucfirst($c['status']) ?></p>
                                    </div>
                                    <div class="d-flex gap-2">
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

<!-- Modal para criar consulta -->
<div class="modal fade" id="modalFormulario" tabindex="-1" aria-labelledby="modalFormularioLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body" id="modalContent">
                <div class="text-center p-4">Carregando...</div>
            </div>
        </div>
    </div>
</div>

<script>
    function editarConsulta(id) {
        $('#modalContent').html('<div class="text-center p-4">Carregando...</div>');
        $('#modalFormulario').modal('show');
        $.get("<?= base_url('consultas/edit') ?>/" + id, function(data) {
            $('#modalContent').html(data);
        });
    }
    function novaConsulta() {
        $('#modalContent').html('<div class="text-center p-4">Carregando...</div>');
        $('#modalFormulario').modal('show');
        $.get("<?= base_url('consultas/create') ?>", function(data) {
            $('#modalContent').html(data);
        });
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'pt-br',
            timeZone: 'UTC-3',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            navLinks: true, // clique em dias/semana
            editable: false,
            selectable: true,
            events: [
                <?php foreach ($consultas as $c): ?> {
                        id: '<?= esc($c['id']) ?>',
                        title: '<?= esc($c['pet_nome']) ?> - <?= esc($c['vet_nome']) ?>',
                        start: '<?= $c['data_consulta'] ?>',
                        end: '<?= $c['data_consulta_fim'] ?>',
                        color: '<?= $c['cor_status'] ?>',
                        extendedProps: {
                            status: '<?= ucfirst($c['status']) ?>',
                            pet: '<?= esc($c['pet_nome']) ?>',
                            vet: '<?= esc($c['vet_nome']) ?>'
                        }
                    },
                <?php endforeach; ?>
            ],
            eventClick: function(info) {
                info.jsEvent.preventDefault(); // evita navegação

                const id = info.event.id; // o id da consulta
                const url = "<?= base_url('consultas/edit') ?>/" + id;

                // Abre o modal
                $('#modalFormulario').modal('show');
                $('#modalContent').html('<div class="text-center p-4"><i class="fas fa-spinner fa-spin"></i> Carregando...</div>');

                // Carrega o form de edição via AJAX
                $.get(url, function(data) {
                    $('#modalContent').html(data);
                }).fail(function() {
                    $('#modalContent').html('<div class="alert alert-danger">Erro ao carregar a consulta.</div>');
                });
            },
            dateClick: function(info) {
                // Se já estiver na visão diária
                if (calendar.view.type === 'timeGridDay') {
                    const clickedDate = info.date; // Objeto Date
                    const formattedDate = clickedDate.toISOString().slice(0, 16); // YYYY-MM-DDTHH:MM (para input datetime-local)
                    //alert(formattedDate + ' / ' + info.date);
                    // Abre modal
                    $('#modalFormulario').modal('show');
                    $('#modalContent').html('<div class="text-center p-4">Carregando...</div>');

                    // Carrega formulário via AJAX
                    $.get("<?= base_url('consultas/create') ?>", function(data) {
                        $('#modalContent').html(data);

                        // Pré-preenche a data/hora
                        const datetimeInput = $('#modalFormulario').find('input[name="data_consulta"]');
                        if (datetimeInput.length) {
                            datetimeInput.val(formattedDate);
                        }
                    });
                } else {
                    // Caso contrário, muda para a visão diária e foca na data clicada
                    calendar.changeView('timeGridDay', info.dateStr);
                }
            },
            eventDidMount: function(info) {
                // Determina a cor de acordo com o status
                let statusColor = info.event.color;

                // Conteúdo HTML do tooltip
                const tooltipContent = `
        <div style="color: #fff; background-color: ${statusColor}; padding: 5px 10px; border-radius: 4px;">
            <strong>Pet:</strong> ${info.event.extendedProps.pet}<br>
            <strong>Veterinário:</strong> ${info.event.extendedProps.vet}<br>
            <strong>Status:</strong> ${info.event.color}<br>
            <strong>Data:</strong> ${info.event.start.toLocaleString('pt-BR', {
                day: '2-digit', month: '2-digit', year: 'numeric',
                hour: '2-digit', minute: '2-digit'
            })}<br>
            <strong>Fim:</strong> ${info.event.end.toLocaleString('pt-BR', {
                day: '2-digit', month: '2-digit', year: 'numeric',
                hour: '2-digit', minute: '2-digit'
            })}

        </div>
    `;

                // Cria tooltip com HTML
                new bootstrap.Tooltip(info.el, {
                    title: tooltipContent,
                    html: true, // permite HTML
                    placement: 'top',
                    trigger: 'hover',
                    container: 'body'
                });
            },

            dayMaxEventRows: 3
        });

        // Render inicial
        if (document.getElementById('calendario').classList.contains('show')) {
            calendar.render();
        }


    });
</script>

<style>


</style>

<?= $this->endSection() ?>
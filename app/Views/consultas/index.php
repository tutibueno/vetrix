<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<script src="<?= base_url('public/fullcalendar/dist/index.global.min.js') ?>"></script>

<div class="container-fluid">
    <h1 class="mt-4">Consultas</h1>

    <!-- Nav Tabs -->
    <ul class="nav nav-tabs mb-3" id="consultasTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="lista-tab" data-toggle="tab" href="#lista" role="tab" aria-controls="lista" aria-selected="true">
                <i class="fas fa-list"></i> Lista de Consultas
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="calendario-tab" data-toggle="tab" href="#calendario" role="tab" aria-controls="calendario" aria-selected="false">
                <i class="fas fa-calendar-alt"></i> Calendário
            </a>
        </li>
    </ul>

    <!-- Conteúdo Tabs -->
    <div class="tab-content" id="consultasTabContent">

        <!-- LISTA -->
        <div class="tab-pane fade show active" id="lista" role="tabpanel" aria-labelledby="lista-tab">
            <a href="<?= site_url('consultas/create') ?>" class="btn btn-primary mb-3">
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
                                        <a href="<?= site_url('consultas/edit/' . $c['id']) ?>" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
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

        <!-- CALENDÁRIO -->
        <div class="tab-pane fade" id="calendario" role="tabpanel" aria-labelledby="calendario-tab">
            <div class="card shadow rounded-2xl">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-calendar-alt"></i> Agenda de Consultas</h3>
                </div>
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth', // visualização inicial
            locale: 'pt-br', // idioma português
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            navLinks: true, // clique em dias/semana
            editable: false,
            selectable: true,
            events: '<?= site_url('consultas/agendaJson') ?>', // rota que retorna os eventos em JSON

            eventContent: function(arg) {
                let hora = arg.event.start.toLocaleTimeString('pt-BR', {
                    hour: '2-digit',
                    minute: '2-digit'
                });

                let fullText = `${hora} - ${arg.event.title}`;
                let color = arg.event.backgroundColor || '#3788d8'; // fallback caso não tenha cor

                return {
                    html: `<div class="fc-custom-event" title="${fullText}" style="background-color:${color}; color:white; padding:2px 4px; border-radius:4px; ">
                   <b>${hora}</b> - ${arg.event.title}
               </div>`
                };
            },
            dateClick: function(info) {
                // ação ao clicar em um dia vazio
                alert('Data selecionada: ' + info.dateStr);
            }

        });

        calendar.render();
    });

</script>

<style>
    /* Força as cores utilizando CSS variables do FullCalendar (v5/v6) */
    .fc .evt-confirmada {
        --fc-event-bg-color: #28a745;
        --fc-event-border-color: #28a745;
        --fc-event-text-color: #ffffff;
    }

    .fc .evt-pendente {
        --fc-event-bg-color: #ffc107;
        --fc-event-border-color: #ffc107;
        --fc-event-text-color: #000000;
    }

    .fc .evt-cancelada {
        --fc-event-bg-color: #dc3545;
        --fc-event-border-color: #dc3545;
        --fc-event-text-color: #ffffff;
    }

    .fc .evt-default {
        --fc-event-bg-color: #3788d8;
        --fc-event-border-color: #3788d8;
        --fc-event-text-color: #ffffff;
    }

    .fc-event-title,
    .fc-event-time,
    .fc-custom-event {
        white-space: nowrap;
        /* impede quebra de linha */
        overflow: hidden;
        /* corta o excesso */
        text-overflow: ellipsis;
        /* coloca "..." no final */
        max-width: 100%;
        /* respeita a largura da célula */
        display: block;
        font-size: 0.85rem;
        /* deixa mais compacto */
    }
</style>

<?= $this->endSection() ?>
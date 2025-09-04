<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<h1>Bem-vindo!</h1>


<!-- Content Wrapper. Contains page content -->

<script src="<?= base_url('public/fullcalendar/dist/index.global.min.js') ?>"></script>

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
</div>

<!-- Row: Gráfico + Próximas Consultas -->
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Consultas nos últimos 30 dias</h3>
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
                                <b><?= esc($consulta['pet_nome']) ?></b> —
                                Tutor: <?= esc($consulta['tutor_nome']) ?> <br>
                                Vet.: <?= esc($consulta['vet_nome']) ?> <br>
                                <small class="text-muted"><?= esc($consulta['data_consulta_label']) ?></small>
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
                                <b><?= esc($consulta['pet_nome']) ?></b> —
                                Tutor: <?= esc($consulta['tutor_nome']) ?> <br>
                                Vet.: <?= esc($consulta['vet_nome']) ?> <br>
                                <small class="text-muted"><?= esc($consulta['data_consulta_label']) ?></small>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted mb-0">Nenhuma consulta futura agendada.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">📆 Calendário</h5>
            </div>
            <div class="card-body">
                <div id="mini-calendar"></div>
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



<!-- Script Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('graficoConsultas').getContext('2d');
    var graficoConsultas = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode($dias) ?>, // Ex: ['01/09', '02/09', ...]
            datasets: [{
                label: 'Consultas',
                data: <?= json_encode($valores) ?>, // Ex: [2, 5, 3, ...]
                borderColor: 'rgba(60,141,188,0.8)',
                backgroundColor: 'rgba(60,141,188,0.4)',
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('mini-calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: 400, // tamanho reduzido
            locale: 'pt-br',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: '' // sem mudar para semana/dia
            },
            events: '<?= base_url("consultas/eventos") ?>',
            eventDisplay: 'block',
            eventColor: '#28a745',
            eventClick: function(info) {
                alert("Consulta: " + info.event.title + "\nData: " + info.event.start.toLocaleString());
            }
        });

        calendar.render();
    });
</script>



<?= $this->endSection() ?>
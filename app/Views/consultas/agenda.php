<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="card shadow rounded-2xl">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-calendar-alt"></i> Agenda de Consultas</h3>
    </div>
    <div class="card-body">
        <div id="calendar"></div>
    </div>
</div>

<script src="<?= base_url('public/fullcalendar/dist/index.global.min.js') ?>"></script>

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
            eventClick: function(info) {
                // ação ao clicar em um evento
                alert('Consulta: ' + info.event.title + '\nData: ' + info.event.start.toLocaleString());
            },
            dateClick: function(info) {
                // ação ao clicar em um dia vazio
                alert('Data selecionada: ' + info.dateStr);
            }
        });

        calendar.render();
    });
</script>

<?= $this->endSection() ?>
<div id="calendar"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'pt-br',
            editable: false,
            selectable: true,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: '<?= base_url("banho-tosa/calendarEvents") ?>',
            eventClick: function(info) {
                info.jsEvent.preventDefault();
                if (info.event.id) {
                    $.get("<?= base_url('banho-tosa/detalhes') ?>/" + info.event.id, function(data) {
                        $('#modalGlobal .modal-content').html(data);
                        $('#modalGlobal').modal('show');
                    });
                }
            },
            eventDidMount: function(info) {
                // Tooltip com mais informações
                var tooltip = new bootstrap.Tooltip(info.el, {
                    title: info.event.title +
                        "\nInício: " + info.event.start.toLocaleString() +
                        "\nFim: " + info.event.end.toLocaleString(),
                    placement: "top",
                    trigger: "hover",
                    container: "body"
                });
            },
            dateClick: function(info) {
                $.get("<?= base_url('banho-tosa/criar') ?>", {
                    data: info.dateStr
                }, function(html) {
                    $('#modalGlobal .modal-content').html(html);
                    $('#modalGlobal').modal('show');
                });
            },

        });

        calendar.render();

    });
</script>
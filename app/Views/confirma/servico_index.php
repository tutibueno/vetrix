<div class="container mt-5">
    <h3>Confirmação de Banho & Tosa</h3>
    <p>Prezado(a) <?= esc($agendamento['tutor_nome']) ?>,</p>
    <p>
        Gostaríamos de confirmar sua vinda à clínica para o serviço
        "<strong><?= esc($agendamento['nome_servico']) ?></strong>"
        do(a) pet "<strong><?= esc($agendamento['pet_nome']) ?></strong>"
        no dia <strong><?= date('d/m/Y', strtotime($agendamento['data_hora_inicio'])) ?></strong>
        às <strong><?= date('H:i', strtotime($agendamento['data_hora_inicio'])) ?></strong>.
    </p>

    <div class="mt-4">
        <a href="<?= site_url('confirma/servico/confirmar/' . $agendamento['token']) ?>" class="btn btn-success btn-lg">
            ✅ Confirmar
        </a>
        <a href="<?= site_url('confirma/servico/cancelar/' . $agendamento['token']) ?>" class="btn btn-danger btn-lg ms-2">
            ❌ Cancelar
        </a>
    </div>
</div>
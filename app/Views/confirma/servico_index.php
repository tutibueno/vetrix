<head>
    <title>Confirmação de Banho & Tosa</title>
</head>

<body class="bg-light">

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-lg border-0 rounded-4" style="max-width: 600px; width: 100%;">
            <div class="card-header bg-info text-white text-center rounded-top-4">
                <h4 class="mb-0">Confirmação de Banho & Tosa</h4>
            </div>
            <div class="card-body text-center p-4">
                <p class="fs-5">
                    Prezado(a) <strong><?= esc($agendamento['tutor_nome']) ?></strong>,
                </p>
                <p class="mb-4">
                    Gostaríamos de confirmar sua vinda à clínica para o serviço
                    "<strong><?= esc($agendamento['nome_servico']) ?></strong>"
                    do(a) pet "<strong><?= esc($agendamento['pet_nome']) ?></strong>"
                    no dia <strong><?= date('d/m/Y', strtotime($agendamento['data_hora_inicio'])) ?></strong>
                    às <strong><?= date('H:i', strtotime($agendamento['data_hora_inicio'])) ?></strong>.
                </p>

                <div class="d-flex justify-content-center gap-3">
                    <a href="<?= site_url('confirma/servico/confirmar/' . $agendamento['token']) ?>" class="btn btn-success btn-lg px-4">
                        ✔️ Confirmar
                    </a>
                    <a href="<?= site_url('confirma/servico/cancelar/' . $agendamento['token']) ?>" class="btn btn-danger btn-lg px-4">
                        ❌ Cancelar
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
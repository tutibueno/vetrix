<div class="container mt-5">
    <h3>Confirmação de Consulta</h3>
    <p>Prezado(a) <?= esc($consulta['tutor_nome']) ?>,</p>
    <p>
        Gostaríamos de confirmar sua vinda à clínica para a consulta do(a) paciente
        "<strong><?= esc($consulta['pet_nome']) ?></strong>"
        no dia <strong><?= date('d/m/Y', strtotime($consulta['data_consulta'])) ?></strong>
        às <strong><?= date('H:i', strtotime($consulta['data_consulta'])) ?></strong>.
    </p>

    <div class="mt-4">
        <a href="<?= site_url('confirma/confirmar/' . $consulta['token']) ?>" class="btn btn-success btn-lg">
            ✅ Confirmar
        </a>
        <a href="<?= site_url('confirma/cancelar/' . $consulta['token']) ?>" class="btn btn-danger btn-lg ms-2">
            ❌ Cancelar
        </a>
    </div>
</div>
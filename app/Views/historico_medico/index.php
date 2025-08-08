<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Histórico Médico</h3>
        <a href="<?= site_url('historico_medico/create/' . $pet_id) ?>" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Novo Registro
        </a>
    </div>

    <div class="card-body table-responsive p-0" style="max-height: 500px;">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Veterinário</th>
                    <th>Sintomas</th>
                    <th>Diagnóstico</th>
                    <th>Tratamento</th>
                    <th>Observações</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($historicos)): ?>
                    <?php foreach ($historicos as $h): ?>
                        <tr>
                            <td><?= date('d/m/Y', strtotime($h->data_consulta)) ?></td>
                            <td><?= esc($h->veterinario_nome ?? 'Não informado') ?></td>
                            <td><?= esc($h->sintomas) ?></td>
                            <td><?= esc($h->diagnostico) ?></td>
                            <td><?= esc($h->tratamento) ?></td>
                            <td><?= esc($h->observacoes) ?></td>
                            <td>
                                <a href="<?= site_url('historico_medico/edit/' . $h->id) ?>"
                                    class="btn btn-warning btn-sm" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?= site_url('historico_medico/delete/' . $h->id) ?>"
                                    class="btn btn-danger btn-sm" title="Excluir"
                                    onclick="return confirm('Tem certeza que deseja excluir este registro?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">Nenhum histórico médico cadastrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
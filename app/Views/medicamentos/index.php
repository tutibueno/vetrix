<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2><i class="fas fa-pills"></i> Gerenciar Medicamentos</h2>
        <div>
            <a href="<?= site_url('medicamentos/downloadCsv') ?>" class="btn btn-success">
                <i class="fas fa-download"></i> Download CSV
            </a>
        </div>
    </div>

    <!-- Upload de CSV -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <i class="fas fa-upload"></i> Subir Arquivo CSV
        </div>
        <div class="card-body">
            <form action="<?= site_url('medicamentos/uploadCsv') ?>" method="post" enctype="multipart/form-data">
                <input type="file" name="csv_file" accept=".csv" required> <br><br>
                <button type="submit" class="btn btn-primary">Upload CSV</button>
            </form>
        </div>
    </div>

    <!-- Lista de medicamentos -->
    <div class="card">
        <div class="card-header bg-secondary text-white">
            <i class="fas fa-list"></i> Lista de Medicamentos
        </div>
        <div class="card-body">
            <?php if (!empty($medicamentos)): ?>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Nome Comercial</th>
                            <th>Princípio Ativo</th>
                            <th>Forma</th>
                            <th>Categoria</th>
                            <th>Classe Terapêutica</th>
                            <th>Espécie Destino</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($medicamentos as $med): ?>
                            <tr>
                                <td><?= esc($med['nome_comercial']) ?></td>
                                <td><?= esc($med['principio_ativo']) ?></td>
                                <td><?= esc($med['forma']) ?></td>
                                <td><?= esc($med['categoria']) ?></td>
                                <td><?= esc($med['classe_terapeutica']) ?></td>
                                <td><?= esc($med['especie_destino']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-muted">Nenhum medicamento cadastrado.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
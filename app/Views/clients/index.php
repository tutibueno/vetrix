<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <h1 class="mt-4">Clientes</h1>
    <a href="<?= site_url('client/create') ?>" class="btn btn-primary mb-3">Novo Cliente</a>

    <form method="get" class="mb-3">
        <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Buscar cliente por nome ou CPF/CNPJ" value="<?= esc($search) ?>">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit">Buscar</button>
            </div>
        </div>
    </form>

    <div class="row">
        <?php foreach ($clients as $client): ?>
            <?php
            // Função rápida para mascarar CPF/CNPJ
            $doc = $client['cpf_cnpj'];
            if (strlen($doc) === 14) {
                // CPF -> 215.xxx.xxx-xx
                $doc = substr($doc, 0, 3) . '.***.***-' . substr($doc, -2);
            } elseif (strlen($doc) === 14) {
                // CNPJ -> 12.xxx.xxx/xxxx-xx
                $doc = substr($doc, 0, 3) . '.***.***/****-' . substr($doc, -2);
            }

            // Formatar data de cadastro
            $dataCadastro = isset($client['created_at'])
                ? date('d/m/Y H:i', strtotime($client['created_at']))
                : '—';
            ?>
            <div class="col-12 mb-3">
                <div class="card shadow-sm position-relative">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-1"><?= esc($client['nome']) ?></h5>
                            <p class="card-text mb-1"><strong>CPF/CNPJ:</strong> <?= esc($doc) ?></p>
                            <p class="card-text mb-1"><strong>Telefone:</strong> <?= esc($client['telefone']) ?></p>
                            <p class="card-text mb-1"><strong>Email:</strong> <?= esc($client['email']) ?></p>
                            <p class="card-text mb-1 text-muted"><small><strong>Cadastrado em:</strong> <?= esc($dataCadastro) ?></small></p>
                            <a href="<?= site_url('client/edit/' . $client['id']) ?>" class="btn btn-sm btn-warning"> <i class="fas fa-edit"></i> Editar Informações</a>

                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="mt-3">
        <?= $pager->links() ?>
    </div>
</div>

<?= $this->endSection() ?>
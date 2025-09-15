<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <h1 class="mt-4">Clientes</h1>
    <a href="<?= site_url('client/create') ?>" class="btn btn-primary mb-3">Novo Cliente</a>

    <form method="get" class="mb-3" autocomplete="off">
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

            // Data de cadastro
            $dataCadastro = isset($client['created_at'])
                ? date('d/m/Y H:i', strtotime($client['created_at']))
                : '—';

            // Pets do cliente (assumindo que você passou no controller algo como $client['pets'])
            $pets = $client['pets'] ?? [];
            ?>
            <div class="col-12 mb-3">
                <div class="card shadow-sm position-relative">
                    <div class="card-body">
                        <h5 class="card-title mb-1"><?= esc($client['nome']) ?></h5>
                        <p class="card-text mb-1"><strong>CPF/CNPJ:</strong> <?= esc($doc) ?></p>
                        <p class="card-text mb-1"><strong>Telefone:</strong> <?= esc($client['telefone']) ?></p>
                        <p class="card-text mb-1"><strong>Email:</strong> <?= esc($client['email']) ?></p>
                        <p class="card-text mb-1 text-muted"><small><strong>Cadastrado em:</strong> <?= esc($dataCadastro) ?></small></p>

                        <!-- Botão para expandir/recolher pets -->
                        <button class="btn btn-link p-0 mt-2" type="button" data-bs-toggle="collapse" data-bs-target="#pets-<?= $client['id'] ?>">
                            <i class="fas fa-paw"></i> Pets do Cliente
                        </button>

                        <!-- Lista de pets -->
                        <div class="collapse mt-2" id="pets-<?= $client['id'] ?>">
                            <?php if (!empty($pets)): ?>
                                <ul class="list-group list-group-flush">
                                    <?php foreach ($pets as $pet): ?>
                                        <?php
                                        // Formatar data de nascimento
                                        $dataNascimento = isset($pet['data_nascimento'])
                                            ? date('d/m/Y', strtotime($pet['data_nascimento']))
                                            : 'Não Informado';
                                        ?>
                                        <li class="list-group-item">
                                            <strong><?= esc($pet['nome']) ?></strong>
                                            — <?= esc($pet['especie']) ?> (<?= esc($pet['raca']) ?>)
                                            <br><small><strong>Nascimento:</strong> <?= $dataNascimento ?></small><br>
                                            <a href="<?= site_url('pet/ficha/' . $pet['id']) ?>">
                                                <i class="fas fa-eye"></i> Ver Ficha
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <p class="text-muted">Nenhum pet cadastrado.</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-end">
                        <a href="<?= site_url('client/edit/' . $client['id']) ?>" class="btn btn-sm btn-warning me-2">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <a href="<?= site_url('client/delete/' . $client['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este cliente?')">
                            <i class="fas fa-trash"></i> Excluir
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="mt-3">
        <?= $pager->links('default', 'custom') ?>
    </div>

</div>

<?= $this->endSection() ?>
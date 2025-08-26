<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h2>Dados da Clínica</h2>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <?php if ($clinica): ?>
        <div class="card">
            <div class="card-body">
                <p><strong>Nome da Clínica:</strong> <?= esc($clinica['nome_clinica']) ?></p>
                <p><strong>Razão Social:</strong> <?= esc($clinica['razao_social']) ?></p>
                <p><strong>CNPJ:</strong> <?= esc($clinica['cnpj']) ?></p>
                <p><strong>CRMV:</strong> <?= esc($clinica['crmv']) ?></p>
                <p><strong>Registro MAPA:</strong> <?= esc($clinica['registro_mapa']) ?></p>
                <p><strong>Inscrição Municipal:</strong> <?= esc($clinica['inscricao_municipal']) ?></p>
                <p><strong>Inscrição Estadual:</strong> <?= esc($clinica['inscricao_estadual']) ?></p>
                <p><strong>Endereço:</strong>
                    <?= esc($clinica['rua']) ?>, <?= esc($clinica['numero']) ?>
                    <?= $clinica['complemento'] ? ' - ' . esc($clinica['complemento']) : '' ?><br>
                    <?= esc($clinica['bairro']) ?> - <?= esc($clinica['cidade']) ?>/<?= esc($clinica['uf']) ?><br>
                    CEP: <?= esc($clinica['cep']) ?>
                </p>
                <p><strong>Telefone:</strong> <?= esc($clinica['telefone']) ?></p>
                <p><strong>Celular:</strong> <?= esc($clinica['celular']) ?></p>
                <p><strong>WhatsApp:</strong> <?= esc($clinica['whatsapp']) ?></p>
                <p><strong>Email:</strong> <?= esc($clinica['email']) ?></p>
            </div>
            <div class="card-footer">
                <a href="<?= site_url('clinica/edit') ?>" class="btn btn-primary">Editar</a>
            </div>
        </div>
    <?php else: ?>
        <p>Nenhum dado cadastrado. <a href="<?= site_url('clinica/edit') ?>">Cadastrar agora</a>.</p>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
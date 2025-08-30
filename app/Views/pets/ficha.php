<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    /* seta gira ao abrir */
    .card-header .fa-chevron-down {
        transition: transform 0.3s ease;
    }

    .card-header button[aria-expanded="true"] .fa-chevron-down {
        transform: rotate(180deg);
    }

    /* título aberto com destaque */
    .card-header button[aria-expanded="true"] {
        background-color: #e6f0ff;
        /* azul claro */
        color: #0d6efd;
        /* azul bootstrap */
        font-weight: 600;
        border-radius: 0.5rem;
    }

    .card-header button {
        transition: all 0.3s ease;
        border-radius: 0.5rem;
    }
</style>

<div class="card shadow rounded-2xl mb-4">
    <div class="card-header">
        <button class="btn btn-link w-100 text-start d-flex justify-content-between align-items-center"
            type="button" data-bs-toggle="collapse" data-bs-target="#fichaPet" aria-expanded="true">
            <h3 class="card-title mb-0">Ficha de <?= esc($pet['nome']) ?></h3>
            <i class="fas fa-chevron-down"></i>
        </button>
    </div>
    <div id="fichaPet" class="collapse show">
        <div class="card-body">
            <?php if ($pet['foto']): ?>
                <div class="mb-3 text-center">
                    <img src="<?= base_url('public/uploads/pets/' . $pet['foto']) ?>" alt="Foto do pet" class="img-thumbnail" style="max-height: 300px;">
                </div>
            <?php endif; ?>

            <p><strong>Está Vivo:</strong>
                <?= $pet['esta_vivo'] === 'sim' ? '<span class="badge bg-success">Sim</span>' : '<span class="badge bg-danger">Não</span>' ?>
            </p>
            <p><strong>Espécie:</strong> <?= esc($pet['especie']) ?></p>
            <p><strong>Raça:</strong> <?= esc($pet['raca']) ?></p>
            <p><strong>Sexo:</strong> <?= esc($pet['sexo']) ?></p>
            <p><strong>Data de Nascimento:</strong> <?= esc(date('d/m/Y', strtotime($pet['data_nascimento']))) ?></p>
            <p><strong>Tutor:</strong> <?= esc($pet['nome_tutor']) ?> - <?= esc($pet['telefone']) ?></p>
            <p><strong>Observações:</strong> <?= esc($pet['observacoes']) ?></p>
            <p><strong>Castrado:</strong> <?= ucfirst($pet['castrado']) ?></p>
            <p><strong>Peso:</strong> <?= $pet['peso'] ? number_format($pet['peso'], 2, ',', '.') . ' kg' : 'Não informado' ?></p>
            <p><strong>Pelagem:</strong> <?= $pet['pelagem'] ?: 'Não informada' ?></p>
            <p><strong>Número de Identificação:</strong> <?= $pet['numero_identificacao'] ?: 'Não informado' ?></p>
            <p><strong>Alergias:</strong> <?= $pet['alergias'] ?: 'Nenhuma' ?></p>

            <div class="mb-1">
                <button class="btn btn-primary" id="btnAdicionarAtendimento" data-pet="<?= $pet['id'] ?>">
                    <i class="fas fa-notes-medical"></i>&nbsp;&nbsp;<i class="fas fa-plus"></i>&nbsp;Atendimento
                </button>
                <button class="btn btn-primary" id="btnAdicionarVacina" data-pet="<?= $pet['id'] ?>">
                    <i class="fas fa-syringe"></i>&nbsp;&nbsp;<i class="fas fa-plus"></i>&nbsp;Vacinação
                </button>
                <button class="btn btn-primary" id="btnAdicionarPrescricao" data-pet="<?= $pet['id'] ?>">
                    <i class="fas fa-file-medical"></i>&nbsp;&nbsp;<i class="fas fa-plus"></i>&nbsp;Prescrição
                </button>
                <button class="btn btn-primary" id="btnAdicionarExame" data-pet="<?= $pet['id'] ?>">
                    <i class="fas fa-vials"></i>&nbsp;&nbsp;<i class="fas fa-plus"></i>&nbsp;Exame
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Histórico Médico -->
<div class="card shadow rounded-2xl mt-4">
    <div class="card-header">
        <button class="btn btn-link w-100 text-start d-flex justify-content-between align-items-center"
            type="button" data-bs-toggle="collapse" data-bs-target="#historico" aria-expanded="true">
            <h3 class="card-title mb-0"><i class="fas fa-notes-medical"></i>&nbsp;Histórico Médico</h3>
            <i class="fas fa-chevron-down"></i>
        </button>
    </div>
    <div id="historico" class="collapse show">
        <div class="card-body">
            <!-- conteúdo histórico -->
            <?php if (!empty($historico)): ?>
                <?php foreach ($historico as $h): ?>
                    <div class="card mb-4 border border-secondary shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-notes-medical"></i> Registro #<?= esc($h['id']) ?>&nbsp;
                            </h5>
                            <p class="text-muted mb-2">
                                <strong>Data:</strong> <?= date('d/m/Y', strtotime($h['data_consulta'])) ?><br>
                                <strong>Médico(a):</strong> <?= esc($h['veterinario_nome']) ?>
                            </p>

                            <br><strong>Anamnese:</strong></br>
                            <p><?= nl2br(esc($h['anamnese'])) ?></p>


                            <br><strong>Sinais Clínicos:</strong></br>
                            <p><?= nl2br(esc($h['sinais_clinicos'])) ?></p>



                            <br><strong>Diagnóstico:</strong></br>
                            <p><?= nl2br(esc($h['diagnostico'])) ?></p>



                            <br><strong>Observações:</strong></br>
                            <p><?= nl2br(esc($h['observacoes'])) ?></p>

                        </div>

                        <!-- Rodapé do card com ações -->
                        <div class="card-footer d-flex justify-content-end gap-2">
                            <a onclick="editarAtendimento(<?= $h['id'] ?>)" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <a href="<?= site_url('historico_medico/delete/' . $h['id']) ?>"
                                class="btn btn-sm btn-danger"
                                onclick="return confirm('Tem certeza que deseja excluir este registro?')">
                                <i class="fas fa-trash"></i> Excluir
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="alert alert-info">
                    Nenhum registro de histórico médico cadastrado para este pet.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Vacinas -->
<div class="card shadow rounded-2xl mt-4">
    <div class="card-header">
        <button class="btn btn-link w-100 text-start d-flex justify-content-between align-items-center"
            type="button" data-bs-toggle="collapse" data-bs-target="#vacinas" aria-expanded="true">
            <h3 class="card-title mb-0"><i class="fas fa-syringe"></i>&nbsp;Vacinas</h3>
            <i class="fas fa-chevron-down"></i>
        </button>
    </div>
    <div id="vacinas" class="collapse show">
        <div class="card-body">
            <!-- conteúdo vacinas -->
            <?php if (!empty($vacinas)): ?>
                <div class="row">
                    <?php foreach ($vacinas as $v): ?>
                        <div class="col-12">
                            <div class="card bg-light shadow-sm mb-3">
                                <div class="card-body">
                                    <h6 class="card-subtitle mb-2 text-success">
                                        <i class="fas fa-syringe"></i> <?= esc($v['nome_vacina']) ?>
                                    </h6>
                                    <p class="mb-1"><strong>Data:</strong> <?= date('d/m/Y', strtotime($v['data_aplicacao'])) ?></p>
                                    <p class="mb-1"><strong>Data Reforço:</strong> <?= !empty($v['data_reforco']) ? date('d/m/Y', strtotime($v['data_reforco'])) : '-' ?></p>
                                    <p class="mb-1"><strong>Observações:</strong> <?= $v['observacoes'] ?></p>
                                </div>
                                <!-- Rodapé do card com ações -->
                                <div class="card-footer d-flex justify-content-end gap-2">
                                    <a class="btn btn-sm btn-warning" onclick="editarVacina(<?= $v['id'] ?>)">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <a href="<?= base_url('vacinas/delete/' . $v['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Remover vacina?')">
                                        <i class="fas fa-trash"></i> Excluir
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="alert alert-info">Nenhuma vacina cadastrada para este pet.</div>
            <?php endif; ?>

        </div>
    </div>
</div>

<!-- Prescrições -->
<div class="card shadow rounded-2xl mt-4">
    <div class="card-header">
        <button class="btn btn-link w-100 text-start d-flex justify-content-between align-items-center"
            type="button" data-bs-toggle="collapse" data-bs-target="#prescricoes" aria-expanded="true">
            <h3 class="card-title mb-0"><i class="fas fa-file-medical"></i>&nbsp;Prescrições</h3>
            <i class="fas fa-chevron-down"></i>
        </button>
    </div>
    <div id="prescricoes" class="collapse show">
        <div class="card-body">
            <!-- conteúdo prescrições -->
            <?php if (!empty($prescricoes)): ?>
                <?php foreach ($prescricoes as $p): ?>
                    <div class="card mb-4 border border-secondary shadow-sm">
                        <div class="card-body">


                            <p class="text-muted mb-2">
                                <strong>Data:</strong> <?= date('d/m/Y', strtotime($p['data_prescricao'])) ?>
                                <br>
                                <strong>Médico Responsável:</strong> <?= esc($p['veterinario_nome']) ?>
                                <br>
                                <strong>Tipo de Receita:</strong> <?= esc($p['tipo_prescricao']) ?>
                            </p>

                            <div class="row">
                                <?php foreach ($p['medicamentos'] as $item): ?>
                                    <div class="col-md-6">
                                        <div class="card bg-light border-0 shadow-sm mb-3">
                                            <div class="card-body">
                                                <h6 class="card-subtitle mb-2 text-primary">
                                                    <i class="fas fa-pills"></i> <?= esc($item['nome_medicamento']) ?>
                                                </h6>
                                                <p class="mb-1"><strong>Posologia:</strong> <?= esc($item['posologia']) ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <div class="card-footer d-flex justify-content-end gap-2">
                                <a href="<?= base_url('prescricoes/imprimir/' . $p['id']) ?>"
                                    class="btn btn-primary btn-sm" target="_blank">
                                    <i class="fas fa-print"></i> Imprimir
                                </a>
                                <button class="btn btn-sm btn-warning" onclick="editarPrescricao(<?= $p['id'] ?>)">
                                    <i class="fas fa-edit"></i>Editar</button>
                                <button class="btn btn-sm btn-danger" onclick="excluirPrescricao(<?= $p['id'] ?>)">
                                    <i class="fas fa-trash"></i>Excluir</button>

                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="alert alert-info">
                    Nenhuma prescrição cadastrada para este pet.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Exames -->
<div class="card shadow rounded-2xl mt-4">
    <div class="card-header">
        <button class="btn btn-link w-100 text-start d-flex justify-content-between align-items-center"
            type="button" data-bs-toggle="collapse" data-bs-target="#exames" aria-expanded="true">
            <h3 class="card-title mb-0"><i class="fas fa-vials"></i>&nbsp;Exames</h3>
            <i class="fas fa-chevron-down"></i>
        </button>
    </div>
    <div id="exames" class="collapse show">
        <div class="card-body">
            <!-- conteúdo exames -->
            <?php if (!empty($exames)): ?>
                <?php foreach ($exames as $e): ?>
                    <div class="card mb-4 border border-secondary shadow-sm">
                        <div class="card-body">

                            <p class="text-muted mb-2">
                                <strong>Data da Solicitação:</strong> <?= date('d/m/Y', strtotime($e['data_solicitacao'])) ?><br>
                                <strong>Médico Responsável:</strong> <?= esc($e['veterinario_nome']) ?><br>
                                <strong>Observações:</strong> <?= esc($e['observacoes']) ?>
                            </p>

                            <!-- Itens de exames -->
                            <div class="row">
                                <?php if (!empty($e['itens'])): ?>
                                    <?php foreach ($e['itens'] as $item): ?>
                                        <div class="col-md-6">
                                            <div class="card bg-light border-0 shadow-sm mb-3">
                                                <div class="card-body">
                                                    <h6 class="card-subtitle mb-2 text-primary">
                                                        <i class="fas fa-vial"></i> <?= esc($item['nome_exame']) ?>
                                                    </h6>
                                                    <?php if (!empty($item['observacoes'])): ?>
                                                        <p class="mb-1"><strong>Obs.:</strong> <?= esc($item['observacoes']) ?></p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="col-12">
                                        <span class="badge bg-warning">Nenhum exame detalhado informado.</span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Motivos -->
                            <?php if (!empty($e['motivos'])): ?>
                                <h6 class="mt-3"><i class="fas fa-notes-medical"></i> Motivos / Suspeitas</h6>
                                <ul>
                                    <?php foreach ($e['motivos'] as $motivo): ?>
                                        <li><?= esc($motivo['motivo_suspeita']) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>

                            <!-- Botões -->
                            <div class="card-footer d-flex justify-content-end gap-2">
                                <a href="<?= base_url('exames/imprimir/' . $e['id']) ?>"
                                    class="btn btn-primary btn-sm" target="_blank">
                                    <i class="fas fa-print"></i> Imprimir
                                </a>
                                <button class="btn btn-sm btn-warning" onclick="editarExame(<?= $e['id'] ?>)">
                                    <i class="fas fa-edit"></i> Editar
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="excluirExame(<?= $e['id'] ?>)">
                                    <i class="fas fa-trash"></i> Excluir
                                </button>
                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="alert alert-info">
                    Nenhuma solicitação de exame cadastrada para este pet.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>


<div class="card shadow rounded-2xl mb-4">
    <div class="card-header">
        <h3 class="card-title mb-0">
            Ficha de <?= esc($pet['nome']) ?>
        </h3>
    </div>
    <div class="card-body">
        <!-- Container das Tabs com scroll e setinhas -->
        <div class="nav-tabs-wrapper position-relative mb-3">
            <button class="scroll-btn scroll-left d-none">&lt;</button>
            <div class="nav-tabs-container overflow-auto">
                <ul class="nav nav-tabs flex-nowrap" id="petTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="ficha-tab" data-bs-toggle="tab" data-bs-target="#ficha" type="button" role="tab">
                            Ficha
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pesos-tab" data-bs-toggle="tab" data-bs-target="#pesos" type="button" role="tab">
                            Pesos
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="historico-tab" data-bs-toggle="tab" data-bs-target="#historico" type="button" role="tab">
                            Atendimentos
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="vacinas-tab" data-bs-toggle="tab" data-bs-target="#vacinas" type="button" role="tab">
                            Vacinas
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="prescricoes-tab" data-bs-toggle="tab" data-bs-target="#prescricoes" type="button" role="tab">
                            Prescricoes
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="exames-tab" data-bs-toggle="tab" data-bs-target="#exames" type="button" role="tab">
                            Exames
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="medicamentos-tab" data-bs-toggle="tab" data-bs-target="#medicamentos" type="button" role="tab">
                            Medicamentos
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="cirurgias-tab" data-bs-toggle="tab" data-bs-target="#cirurgias" type="button" role="tab">
                            Cirurgias
                        </button>
                    </li>
                    
                </ul>
            </div>
            <button class="scroll-btn scroll-right d-none">&gt;</button>
        </div>


        <!-- Conteúdo das Tabs -->
        <div class="tab-content mt-3" id="petTabsContent">

            <!-- Aba Ficha -->
            <div class="tab-pane fade show active" id="ficha" role="tabpanel">
                <div class="row">
                    <!-- Foto do Pet -->
                    <div class="col-md-4 text-center mb-3">
                        <?php if ($pet['foto']): ?>
                            <img src="<?= base_url('public/uploads/pets/' . $pet['foto']) ?>"
                                alt="Foto do pet"
                                class="img-thumbnail rounded shadow"
                                style="max-height: 250px; object-fit: cover;">
                        <?php else: ?>
                            <div class="border rounded p-4 bg-light text-muted">
                                <i class="fas fa-paw fa-5x"></i><br>
                                Sem foto
                            </div>
                        <?php endif; ?>
                        <br>
                        <a href="<?= site_url('pet/edit/' . $pet['id']) ?>" class="btn btn-warning" data-bs-toggle="tooltip" title="Editar Pet">
                            <i class="fas fa-edit"></i> Editar Pet
                        </a>
                    </div>

                    <!-- Informações -->
                    <div class="col-md-8">
                        <p><strong>Está Vivo:</strong>
                            <?= $pet['esta_vivo'] === 'sim' ? '<span class="badge bg-success">Sim</span>' : '<span class="badge bg-danger">Não</span>' ?>
                        </p>
                        <p><strong>Espécie:</strong> <?= esc($pet['especie']) ?></p>
                        <p><strong>Raça:</strong> <?= esc($pet['raca']) ?></p>
                        <p><strong>Sexo:</strong> <?= esc($pet['sexo']) ?></p>
                        <p><strong>Data de Nascimento:</strong> <?php if (empty($pet['data_nascimento'])): ?>
                                Não Informado
                            <?php else: ?>
                                <?= date('d/m/Y', strtotime($pet['data_nascimento'])) ?>
                            <?php endif; ?></p>
                        <p><strong>Idade:</strong> <span id="idade_pet"></span></p>
                        <p><strong>Tutor:</strong> <?= esc($pet['nome_tutor']) ?> - <?= esc($pet['telefone']) ?></p>
                        <p><strong>Observações:</strong> <?= esc($pet['observacoes']) ?></p>
                        <p><strong>Castrado:</strong> <?= ucfirst($pet['castrado']) ?></p>
                        <p><strong>Peso:</strong> <?= $pesoRecente ? number_format($pesoRecente['peso_kg'], 3, ',', '.') . ' kg (último informado)' : 'Não informado' ?></p>
                        <p><strong>Pelagem:</strong> <?= $pet['pelagem'] ?: 'Não informada' ?></p>
                        <p><strong>Número de Identificação:</strong> <?= $pet['numero_identificacao'] ?: 'Não informado' ?></p>
                        <p><strong>Alergias:</strong> <?= $pet['alergias'] ?: 'Nenhuma' ?></p>
                    </div>
                </div>
            </div>

            <!-- Aba Pesos -->
            <div class="tab-pane fade" id="pesos" role="tabpanel" aria-labelledby="peso-tab">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5>Acompanhamento de Peso</h5>
                    <button class="btn btn-primary btn-sm" id="btnNovoPeso" data-pet-id="<?= esc($pet['id']) ?>">
                        <i class="fas fa-plus"></i> Novo Registro
                    </button>
                </div>
                <?= view('pets/_pesos') ?>
            </div>

            <!-- Aba Histórico -->
            <div class="tab-pane fade" id="historico" role="tabpanel">
                <button class="btn btn-primary mb-3" id="btnAdicionarAtendimento" data-pet="<?= $pet['id'] ?>">
                    <i class="fas fa-plus"></i> Atendimento
                </button>
                <?= view('pets/_historico', ['historico' => $historico]) ?>
            </div>

            <!-- Aba Vacinas -->
            <div class="tab-pane fade" id="vacinas" role="tabpanel">
                <?= view('pets/_vacinas', ['vacinas' => $vacinas]) ?>
            </div>

            <!-- Aba Prescrições -->
            <div class="tab-pane fade" id="prescricoes" role="tabpanel">
                <button class="btn btn-primary mb-3" id="btnAdicionarPrescricao" data-pet="<?= $pet['id'] ?>">
                    <i class="fas fa-plus"></i> Prescrição
                </button>
                <?= view('pets/_prescricoes', ['prescricoes' => $prescricoes]) ?>
            </div>

            <!-- Aba Exames -->
            <div class="tab-pane fade" id="exames" role="tabpanel">
                <button class="btn btn-primary mb-3" id="btnAdicionarExame" data-pet="<?= $pet['id'] ?>">
                    <i class="fas fa-plus"></i> Exame
                </button>
                <?= view('pets/_exames', ['exames' => $exames]) ?>
            </div>

            <!-- Aba Medicamentos -->
            <div class="tab-pane fade" id="medicamentos" role="tabpanel">
                <button class="btn btn-primary mb-3" id="btnAdicionarMedicamento" data-pet-id="<?= esc($pet['id']) ?>">
                    <i class="fas fa-plus"></i> Medicamento
                </button>
                <?= view('pets/_medicamentos', ['medicamentos' => $medicamentos]) ?>
            </div>

            <!-- Aba Cirurgias -->
            <div class="tab-pane fade" id="cirurgias" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5><i class="fas fa-procedures"> </i> Cirurgias Realizadas</h5>
                    <button class="btn btn-primary btn-sm" id="btnAdicionarCirurgia" data-pet-id="<?= esc($pet['id']) ?>">
                        <i class="fas fa-plus"></i> Nova Cirurgia
                    </button>
                </div>
                <?= view('pets/_cirurgias') ?>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="modalFormulario" tabindex="-1" role="dialog" aria-labelledby="modalFormularioLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="meuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="modalContent">
            <!-- Conteúdo AJAX será carregado aqui -->
        </div>
    </div>
</div>

<!-- Modal Impressão-->
<div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pré-visualização da Prescrição</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="previewContent" style="min-height:70vh; overflow:auto;">
                <!-- Conteúdo será injetado via JS -->
            </div>
            <div class="modal-footer">
                <a href="<?= site_url('prescricoes/imprimir/pdf/' . 6) ?>" target="_blank" class="btn btn-success">
                    Baixar PDF
                </a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<script>
    function calcularIdade(dataNascimento) {
        if (!dataNascimento) return "";

        const hoje = new Date();
        const nasc = new Date(dataNascimento);

        let anos = hoje.getFullYear() - nasc.getFullYear();
        let meses = hoje.getMonth() - nasc.getMonth();
        let dias = hoje.getDate() - nasc.getDate();

        if (dias < 0) {
            meses--;
            const ultimoDiaMesAnterior = new Date(hoje.getFullYear(), hoje.getMonth(), 0).getDate();
            dias += ultimoDiaMesAnterior;
        }

        if (meses < 0) {
            anos--;
            meses += 12;
        }

        if (anos > 0) {
            return `${anos} ano${anos > 1 ? 's' : ''} e ${meses} mes${meses !== 1 ? 'es' : ''}`;
        } else if (meses > 0) {
            return `${meses} mes${meses !== 1 ? 'es' : ''} e ${dias} dia${dias !== 1 ? 's' : ''}`;
        } else {
            return `${dias} dia${dias !== 1 ? 's' : ''}`;
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        const dataNascimento = "<?= $pet['data_nascimento'] ?? '' ?>";
        const idadeTexto = calcularIdade(dataNascimento);
        document.getElementById("idade_pet").textContent = idadeTexto || "-";
    });
</script>

<style>
    .nav-tabs-wrapper {
        position: relative;
    }

    .nav-tabs .nav-item {
        flex: 0 0 auto;
    }

    /* Botões de scroll */
    .scroll-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 10;
        background-color: rgba(255, 255, 255, 0.8);
        border: none;
        font-size: 1.2rem;
        cursor: pointer;
        padding: 0.25rem 0.75rem;
        border-radius: 50%;
    }

    .scroll-left {
        left: 0;
    }

    .scroll-right {
        right: 0;
    }

    .nav-tabs-container {
        overflow-x: auto;
        overflow-y: hidden;
        white-space: nowrap;
        scroll-behavior: smooth;

        /* esconder a barra de scroll */
        -ms-overflow-style: none;
        /* IE e Edge */
        scrollbar-width: none;
        /* Firefox */
    }

    .nav-tabs-container::-webkit-scrollbar {
        display: none;
        /* Chrome, Safari e Opera */
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const container = document.querySelector('.nav-tabs-container');
        const btnLeft = document.querySelector('.scroll-left');
        const btnRight = document.querySelector('.scroll-right');

        function updateButtons() {
            btnLeft.classList.toggle('d-none', container.scrollLeft === 0);
            btnRight.classList.toggle('d-none', container.scrollWidth === container.clientWidth + container.scrollLeft);
        }

        btnLeft.addEventListener('click', () => {
            container.scrollBy({
                left: -150,
                behavior: 'smooth'
            });
        });

        btnRight.addEventListener('click', () => {
            container.scrollBy({
                left: 150,
                behavior: 'smooth'
            });
        });

        container.addEventListener('scroll', updateButtons);
        window.addEventListener('resize', updateButtons);

        updateButtons(); // inicializa
    });
</script>

<?= $this->endSection() ?>
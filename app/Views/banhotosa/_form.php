<?php $errors = session('errors'); ?>
<?php $banho = $banho ?? []; ?>
<div class="modal-header bg-primary text-white">
    <h5 class="modal-title"><?= isset($banho['id']) ? 'Editar Agendamento' : 'Novo Agendamento' ?></h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
</div>
<div class="container-fluid">
    <form id="formBanhoTosa" action="<?= base_url('banhotosa/store') ?>" method="post">


        <div class="modal-body">

            <input type="hidden" name="id" value="<?= $banho['id'] ?? '' ?>">

            <div class="form-group position-relative">
                <label>Pet</label>
                <input type="hidden" name="pet_id" id="pet_id" value="<?= old('pet_id', $banho['pet_id'] ?? '') ?>">
                <input type="text" id="pet_nome"
                    class="form-control <?= isset($errors['pet_id']) ? 'is-invalid' : '' ?>"
                    placeholder="Digite o nome do pet ou do tutor"
                    value="<?= old('pet_nome', $banho['pet_nome'] ?? '') ?>"
                    autocomplete="off">
                <div class="invalid-feedback"><?= $errors['pet_id'] ?? '' ?></div>

                <!-- Lista de sugestões -->
                <div class="list-group" id="pet_suggestions"
                    style="display:none; position:absolute; width:100%; z-index:1050;"></div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <!-- Card do Tutor -->
                    <div class="card mb-3" id="card_tutor" style="display:none;">
                        <div class="card-header">Tutor</div>
                        <div class="card-body">
                            <p><strong>Nome:</strong> <span id="tutor_nome_card"></span></p>
                            <p><strong>CPF:</strong> <span id="tutor_cpf_card"></span></p>
                            <p><strong>Telefone:</strong> <span id="tutor_telefone_card"></span></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <!-- Card do Pet -->
                    <div class="card mb-3" id="card_pet" style="display:none;">
                        <div class="card-header">Pet</div>
                        <div class="card-body">
                            <p><strong>Nome:</strong> <span id="pet_nome_card"></span></p>
                            <p><strong>Espécie:</strong> <span id="pet_especie_card"></span></p>
                            <p><strong>Raça:</strong> <span id="pet_raca_card"></span></p>
                            <p><strong>Sexo:</strong> <span id="pet_sexo_card"></span></p>
                            <p><strong>Peso (Kg):</strong> <span id="pet_peso_card"></span></p>
                        </div>
                        <div class="card-footer text-end">
                            <a href="#" id="linkFichaPet" class="btn btn-sm btn-primary">
                                <i class="fas fa-file-alt"></i> Ver ficha do Pet
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Serviço -->
            <div class="form-group">
                <label>Serviço</label>
                <select name="servico_id" class="form-control <?= isset($errors['servico_id']) ? 'is-invalid' : '' ?>" required>
                    <option value="">Selecione o serviço...</option>
                    <?php foreach ($servicos as $s): ?>
                        <option value="<?= $s['id'] ?>" <?= (isset($banho['servico_id']) && $banho['servico_id'] == $s['id']) ? 'selected' : '' ?>>
                            <?= $s['nome_servico'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback"><?= $errors['servico_id'] ?? '' ?></div>
            </div>

            <!-- Data e Hora -->
            <div class="form-group">
                <label>Data e Hora</label>
                <input type="datetime-local" name="data_hora_inicio" id="data_hora_inicio" class="form-control <?= isset($errors['data_hora_inicio']) ? 'is-invalid' : '' ?>"
                    value="<?= isset($banho['data_hora_inicio']) ? date('Y-m-d\TH:i', strtotime($banho['data_hora_inicio'])) : '' ?>" required>
                <div class="invalid-feedback"><?= $errors['data_hora_inicio'] ?? '' ?></div>
            </div>

            <!-- Duração -->
            <div class="form-group">
                <label>Duração (minutos)</label>
                <input type="number" name="duracao_minutos" class="form-control <?= isset($errors['duracao_minutos']) ? 'is-invalid' : '' ?>"
                    value="<?= $banho['duracao_minutos'] ?? 60 ?>" min="30" max="480" step="15" required>
                <small class="form-text text-muted">Escolha a duração do serviço (30 a 480 minutos)</small>
                <div class="invalid-feedback"><?= $errors['duracao_minutos'] ?? '' ?></div>
            </div>

            <!-- Status -->
            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control <?= isset($errors['status']) ? 'is-invalid' : '' ?>" required>
                    <option value="agendado" <?= (isset($banho['status']) && $banho['status'] == 'agendado') ? 'selected' : '' ?>>Agendado</option>
                    <option value="confirmado" <?= (isset($banho['status']) && $banho['status'] == 'confirmado') ? 'selected' : '' ?>>Confirmado</option>
                    <option value="em_andamento" <?= (isset($banho['status']) && $banho['status'] == 'em_andamento') ? 'selected' : '' ?>>Em Andamento</option>
                    <option value="concluido" <?= (isset($banho['status']) && $banho['status'] == 'concluido') ? 'selected' : '' ?>>Concluído</option>
                    <option value="cancelado" <?= (isset($banho['status']) && $banho['status'] == 'cancelado') ? 'selected' : '' ?>>Cancelado</option>
                </select>
                <div class="invalid-feedback"><?= $errors['status'] ?? '' ?></div>
            </div>

            <!-- Observações -->
            <div class="form-group">
                <label>Observações</label>
                <textarea name="observacoes" class="form-control"><?= $banho['observacoes'] ?? '' ?></textarea>
            </div>

        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i><?= isset($banho) ? ' Atualizar' : ' Salvar' ?></button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <?php if (!empty($banho['id'])): ?>
                <button class="btn btn-danger btnExcluir" data-id=<?= $banho['id'] ?>>
                    <i class="fas fa-trash"></i> Excluir
                </button>
            <?php endif; ?>

        </div>
    </form>
</div>
<script>
    // Autocomplete Pet (Consulta)
    $('#pet_nome').on('input', function() {
        let term = $(this).val();
        if (term.length < 1) {
            $('#pet_suggestions').hide();
            return;
        }

        $.getJSON('<?= site_url("pet/buscar") ?>', {
            term: term
        }, function(data) {
            let html = '';
            data.forEach(p => {
                html += `
                <a href="#" class="list-group-item list-group-item-action"
                   data-id="${p.id}">
                   <strong>${p.nome}</strong> 
                   <small class="text-muted">(${p.especie} - ${p.raca})</small><br>
                   <small><i class="fas fa-user"></i> Tutor: ${p.tutor_nome}</small>
                   <small> | Tel: ${p.tutor_telefone}</small>
                   <small> | CPF: ${p.tutor_cpf}</small>
                </a>`;
            });

            if (html) {
                $('#pet_suggestions').html(html).show();
            } else {
                $('#pet_suggestions').hide();
            }
        });
    });

    // Selecionar Pet
    $(document).on('click', '#pet_suggestions a', function(e) {
        e.preventDefault();
        let nome = $(this).find("strong").text();
        let id = $(this).data('id');

        $('#pet_nome').val(nome);
        $('#pet_id').val(id);
        $('#pet_suggestions').hide();

        // Buscar detalhes do pet selecionado
        $.getJSON('<?= site_url("pet/detalhes") ?>/' + id, function(data) {
            if (data.error) {
                console.error(data.error);
                return;
            }

            // Exemplo: preencher campos da consulta automaticamente
            $('#especie').val(data.especie);
            $('#raca').val(data.raca);
            $('#sexo').val(data.sexo);
            $('#peso').val(data.peso);
            $('#tutor_info').text(data.tutor_nome + ' - ' + (data.tutor_telefone ?? '') + ' - ' + data.tutor_cpf);
        });
    });

    $(document).ready(function() {
        let petId = $('#pet_id').val();

        if (petId) {
            $.getJSON('<?= site_url("pet/detalhes") ?>/' + petId, function(data) {
                if (data && !data.error) {
                    $('#pet_nome').val(data.nome);
                    $('#especie').val(data.especie);
                    $('#raca').val(data.raca);
                    $('#sexo').val(data.sexo);
                    $('#peso').val(data.peso);
                    $('#tutor_nome').val(data.tutor_nome);
                    $('#tutor_telefone').val(data.tutor_telefone);
                    $('#tutor_cpf').val(data.tutor_cpf);
                    $('#linkFichaPet').attr('href', '<?= base_url("pet/ficha/") ?>' + data.id);
                }
            });
        }
    });

    // Fechar lista ao clicar fora
    $(document).click(function(e) {
        if (!$(e.target).closest('#pet_nome, #pet_suggestions').length) {
            $('#pet_suggestions').hide();
        }
    });
</script>

<script>
    function atualizarCards(data) {
        if (!data) return;

        // Preenche o card do tutor
        if (data.tutor_nome) {
            $('#tutor_nome_card').text(data.tutor_nome);
            $('#tutor_cpf_card').text(data.tutor_cpf);
            $('#tutor_telefone_card').text(data.tutor_telefone);
            $('#card_tutor').show();
        } else {
            $('#card_tutor').hide();
        }

        // Preenche o card do pet
        if (data.nome) {
            $('#pet_nome_card').text(data.nome);
            $('#pet_especie_card').text(data.especie);
            $('#pet_raca_card').text(data.raca);
            $('#pet_sexo_card').text(data.sexo);
            $('#pet_peso_card').text(data.peso);
            $('#card_pet').show();
        } else {
            $('#card_pet').hide();
        }
    }

    // Quando o usuário seleciona um pet no autocomplete
    $(document).on('click', '#pet_suggestions a', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        $('#pet_id').val(id);

        $.getJSON('<?= site_url("pet/detalhes") ?>/' + id, function(data) {
            if (data && !data.error) {
                // Preenche campos editáveis
                $('#pet_nome').val(data.nome);
                $('#especie').val(data.especie);
                $('#raca').val(data.raca);
                $('#sexo').val(data.sexo);
                $('#peso').val(data.peso);
                $('#tutor_nome').val(data.tutor_nome);
                $('#tutor_telefone').val(data.tutor_telefone);
                $('#tutor_cpf').val(data.tutor_cpf);

                // Atualiza os cards
                atualizarCards(data);
            }
        });

        $('#pet_suggestions').hide();
    });

    // Ao abrir o formulário de edição
    $(document).ready(function() {
        let petId = $('#pet_id').val();
        if (petId) {
            $.getJSON('<?= site_url("pet/detalhes") ?>/' + petId, function(data) {
                if (data && !data.error) {
                    // Preenche campos editáveis
                    $('#pet_nome').val(data.nome);
                    $('#especie').val(data.especie);
                    $('#raca').val(data.raca);
                    $('#sexo').val(data.sexo);
                    $('#peso').val(data.peso);
                    $('#tutor_nome').val(data.tutor_nome);
                    $('#tutor_telefone').val(data.tutor_telefone);
                    $('#tutor_cpf').val(data.tutor_cpf);
                    // Atualiza os cards
                    atualizarCards(data);
                }
            });
        }
    });
</script>
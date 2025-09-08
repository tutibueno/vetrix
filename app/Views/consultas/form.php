<div class="modal-header bg-primary text-white">
    <h5 class="modal-title"><i class="fas fa-calendar-plus"></i> <?= $consulta ? 'Editar Consulta' : 'Agendar Consulta' ?></h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
</div>
<div class="container-fluid">
    <form method="post" action="<?= $consulta ? site_url('consultas/update/' . $consulta['id']) : site_url('consultas/store') ?>">
        <?= csrf_field() ?>

        <div class="form-group position-relative">
            <label>Pet</label>
            <input type="hidden" name="pet_id" id="pet_id" value="<?= old('pet_id', $consulta['pet_id'] ?? '') ?>">
            <input type="text" id="pet_nome"
                class="form-control <?= isset($errors['pet_id']) ? 'is-invalid' : '' ?>"
                placeholder="Digite o nome do pet ou do tutor"
                value="<?= old('pet_nome', $pet['nome'] ?? '') ?>"
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
                    <div class="card-header">
                        Tutor
                    </div>
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
                    <div class="card-header">
                        Pet
                    </div>
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


        <div class="form-group mb-3">
            <label for="veterinario_id">Veterinário</label>
            <select name="veterinario_id" class="form-control" required>
                <option value="">Selecione...</option>
                <?php foreach ($veterinarios as $vet): ?>
                    <option value="<?= $vet['id'] ?>" <?= $consulta && $consulta['veterinario_id'] == $vet['id'] ? 'selected' : '' ?>>
                        <?= esc($vet['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="data_consulta">Data e Hora</label>
            <input type="datetime-local" name="data_consulta" class="form-control" id="data_consulta"
                value="<?= $consulta ? date('Y-m-d\TH:i', strtotime($consulta['data_consulta'])) : '' ?>" required>
        </div>

        <!-- Flag de Retorno -->
        <div class="form-group mb-3 d-flex align-items-center">
            <label class="me-3 mb-0">Retorno:&nbsp;&nbsp;</label>
            <div class="form-check form-check-inline">
                <input class="form-check-input"
                    type="radio"
                    name="flag_retorno"
                    id="retornoSim"
                    value="S"
                    <?= old('flag_retorno', $consulta['flag_retorno'] ?? 'N') === 'S' ? 'checked' : '' ?>>
                <label class="form-check-label" for="retornoSim">Sim</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input"
                    type="radio"
                    name="flag_retorno"
                    id="retornoNao"
                    value="N"
                    <?= old('flag_retorno', $consulta['flag_retorno'] ?? 'N') === 'N' ? 'checked' : '' ?>>
                <label class="form-check-label" for="retornoNao">Não</label>
            </div>
        </div>

        <div class="form-group mb-3">
            <label for="motivo">Motivo</label>
            <textarea name="motivo" class="form-control"><?= $consulta['motivo'] ?? '' ?></textarea>
        </div>

        <div class="form-group mb-3">
            <label for="observacoes">Observações</label>
            <textarea name="observacoes" class="form-control"><?= $consulta['observacoes'] ?? '' ?></textarea>
        </div>

        <div class="form-group mb-3">
            <label for="status">Status</label>
            <select name="status" class="form-control">
                <option value="agendada" <?= $consulta && $consulta['status'] == 'agendada' ? 'selected' : '' ?>>Agendada</option>
                <option value="confirmada" <?= $consulta && $consulta['status'] == 'confirmada' ? 'selected' : '' ?>>Confirmada</option>
                <option value="realizada" <?= $consulta && $consulta['status'] == 'realizada' ? 'selected' : '' ?>>Realizada</option>
                <option value="cancelada" <?= $consulta && $consulta['status'] == 'cancelada' ? 'selected' : '' ?>>Cancelada</option>
            </select>
        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Salvar</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Fechar">Cancelar</button>
            <?php if (!empty($consulta['id'])): ?>
                <a href="<?= site_url('consultas/delete/' . $consulta['id']) ?>"
                    class="btn btn-danger"
                    onclick="return confirm('Deseja realmente excluir esta consulta?');">
                    <i class="fas fa-trash"></i> Excluir
                </a>
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
            $('#linkFichaPet').attr('href', '<?= base_url("pet/ficha/") ?>' + data.id);
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

<style>
    /* Radios maiores para mobile */
    .form-check-input {
        width: 1em;
        height: 1em;
    }

    .form-check-label {
        margin-left: 0.25rem;
        font-size: 1.1em;
    }
</style>
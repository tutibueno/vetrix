<?php $errors = session('errors');
$pet = $pet ?? [];
?>

<script src="<?= base_url('public/adminlte/plugins/select2/js/select2.full.min.js') ?>"></script>

<!-- Select2 CSS -->
<link href="<?= base_url('public/adminlte/plugins/select2/css/select2.min.css') ?>" rel="stylesheet">
<link href="<?= base_url('public/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>" rel="stylesheet">

<!-- Bootstrap Datepicker CSS e JS -->
<link rel="stylesheet" href="<?= base_url('public/adminlte/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') ?>">
<script src="<?= base_url('public/adminlte/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') ?>"></script>
<script src="<?= base_url('public/adminlte/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.pt-BR.min.js') ?>"></script>


<div class="row">
    <div class="col-md-6">
        <!-- ===== Tutor ===== -->
        <div class="form-group position-relative">
            <label>Tutor (Cliente)</label>
            <input type="hidden" name="cliente_id" id="cliente_id" value="<?= old('cliente_id', $pet['cliente_id'] ?? '') ?>">
            <input type="text" id="cliente_nome" class="form-control <?= isset($errors['cliente_id']) ? 'is-invalid' : '' ?>"
                placeholder="Digite o nome do tutor" value="<?= old('cliente_nome', $cliente['nome'] ?? '') ?>" autocomplete="off">
            <div class="invalid-feedback"><?= $errors['cliente_id'] ?? '' ?></div>
            <div class="suggestions" id="cliente_suggestions" style="display:none;"></div>
        </div>

        <!-- Nome do Pet -->
        <div class="form-group">
            <label>Nome do Pet</label>
            <input type="text" name="nome" class="form-control <?= isset($errors['nome']) ? 'is-invalid' : '' ?>" value="<?= old('nome', $pet['nome'] ?? '') ?>">
            <div class="invalid-feedback"><?= $errors['nome'] ?? '' ?></div>
        </div>

        <div class="form-group">
            <label for="especie">Espécie</label>
            <select name="especie" id="especie" class="form-control" required>
                <option value="">Selecione ou digite...</option>
                <option value="Canino" <?= old('especie', $pet['especie'] ?? '') === 'Canino' ? 'selected' : '' ?>>Canino</option>
                <option value="Felino" <?= old('especie', $pet['especie'] ?? '') === 'Felino' ? 'selected' : '' ?>>Felino</option>
                <option value="Ave" <?= old('especie', $pet['especie'] ?? '') === 'Ave' ? 'selected' : '' ?>>Ave</option>
                <option value="Roedor" <?= old('especie', $pet['especie'] ?? '') === 'Roedor' ? 'selected' : '' ?>>Roedor</option>
                <option value="Réptil" <?= old('especie', $pet['especie'] ?? '') === 'Réptil' ? 'selected' : '' ?>>Réptil</option>
                <option value="Equino" <?= old('especie', $pet['especie'] ?? '') === 'Equino' ? 'selected' : '' ?>>Equino</option>
            </select>
        </div>

        <!-- Raça -->
        <div class="form-group">
            <label>Raça</label>
            <input type="text" name="raca" class="form-control" value="<?= old('raca', $pet['raca'] ?? '') ?>">
        </div>

        <!-- Sexo -->
        <div class="form-group">
            <label for="sexo">Sexo</label>
            <select name="sexo" id="sexo" class="form-control" required>
                <option value="">Selecione ou digite...</option>
                <option value="M" <?= old('sexo', $pet['sexo'] ?? 'M') === 'M' ? 'selected' : '' ?>>Macho</option>
                <option value="F" <?= old('sexo', $pet['sexo'] ?? 'F') === 'F' ? 'selected' : '' ?>>Fêmea</option>
            </select>
        </div>

        <!-- Peso -->
        <div class="form-group">
            <label>Peso (Kg)</label>
            <input type="text" name="peso" value="<?= isset($pet['peso']) ? esc($pet['peso']) : '' ?>" class="form-control" placeholder="Ex: 5.20">
        </div>

        <!-- Castrado -->
        <div class="form-group">
            <label for="castrado">Castrado</label>
            <select name="castrado" id="castrado" class="form-control" required>
                <option value="">Selecione ou digite...</option>
                <option value="sim" <?= old('castrado', $pet['castrado'] ?? 'nao') === 'sim' ? 'selected' : '' ?>>Sim</option>
                <option value="nao" <?= old('castrado', $pet['castrado'] ?? 'nao') === 'nao' ? 'selected' : '' ?>>Não</option>
            </select>
        </div>

        <div class="form-group">
            <label>Alergias</label>
            <textarea name="alergias" class="form-control"><?= isset($pet['alergias']) ? esc($pet['alergias']) : '' ?></textarea>
        </div>

        <div class="form-group">
            <label>Número de Identificação (Microchip)</label>
            <input type="text" name="numero_identificacao" value="<?= isset($pet['numero_identificacao']) ? esc($pet['numero_identificacao']) : '' ?>" class="form-control">
        </div>
    </div>

    <div class="col-md-6">


        <div class="form-group">
            <label>Pelagem</label>
            <input type="text" name="pelagem" class="form-control" value="<?= old('pelagem', $pet['pelagem'] ?? '') ?>">
        </div>

        <!-- Data de Nascimento -->
        <div class="form-group">
            <label for="data_nascimento">Data de Nascimento</label>
            <input type="text" name="data_nascimento" id="data_nascimento" class="form-control"
                value="<?= old('data_nascimento', isset($pet['data_nascimento']) ? date('d/m/Y', strtotime($pet['data_nascimento'])) : '') ?>"
                autocomplete="off" placeholder="dd/mm/aaaa">
            <small id="idadePet" class="form-text text-muted mt-1"></small>
        </div>

        <!-- Idade exibida dinamicamente -->
        <div class="form-group">
            <small id="idade_pet" class="form-text text-muted"></small>
        </div>

        <!-- Está Vivo -->
        <div class="form-group">
            <label for="esta_vivo">Está Vivo</label>
            <select name="esta_vivo" id="esta_vivo" class="form-control" required>
                <option value="">Selecione ou digite...</option>
                <option value="sim" <?= old('vivo', $pet['esta_vivo'] ?? 'sim') === 'sim' ? 'selected' : 'sim' ?>>Sim</option>
                <option value="nao" <?= old('vivo', $pet['esta_vivo'] ?? 'sim') === 'nao' ? 'selected' : '' ?>>Não</option>
            </select>
        </div>

        <div class="form-group">
            <label>Observações</label>
            <textarea name="observacoes" class="form-control"><?= old('observacoes', $pet['observacoes'] ?? '') ?></textarea>
        </div>

        <!-- Foto do Pet -->
        <div class="form-group">
            <label>Foto do Pet</label><br>

            <!-- Botão para galeria -->
            <div class="custom-file mb-2">
                <input type="file" class="custom-file-input" id="foto_galeria" name="foto" accept="image/*">
                <label class="custom-file-label" for="foto_galeria">Selecionar da galeria</label>
            </div>

            <!-- Botão para câmera (somente mobile) -->
            <div class="custom-file d-none" id="cameraWrapper">
                <input type="file" class="custom-file-input" id="foto_camera" name="foto_camera" accept="image/*" capture="environment">
                <label class="custom-file-label" for="foto_camera">
                    <i class="fas fa-camera"></i> Tirar foto agora
                </label>
            </div>
        </div>

        <?php if (!empty($pet['foto'])): ?>
            <div class="form-group">
                <label>Foto atual:</label><br>
                <img src="<?= base_url('public/uploads/pets/' . $pet['foto']) ?>" alt="Foto do pet" class="img-thumbnail" width="200">
            </div>
        <?php endif ?>
    </div>
</div>

<!-- ===== Scripts ===== -->
<script>
    $(document).ready(function() {

        // Autocomplete tutor
        $('#cliente_nome').on('input', function() {
            let term = $(this).val();
            if (term.length < 1) {
                $('#cliente_suggestions').hide();
                return;
            }
            $.getJSON('<?= site_url("client/buscar") ?>', {
                term: term
            }, function(data) {
                let html = '';
                data.forEach(c => {
                    html += `<div data-id="${c.id}">${c.nome} ${c.cpf_cnpj} ${c.telefone}</div>`;
                });
                if (html) {
                    $('#cliente_suggestions').html(html).show();
                } else {
                    $('#cliente_suggestions').hide();
                }
            });
        });

        // Selecionar tutor
        $(document).on('click', '#cliente_suggestions div', function() {
            let nome = $(this).text();
            let id = $(this).data('id');
            $('#cliente_nome').val(nome);
            $('#cliente_id').val(id);
            $('#cliente_suggestions').hide();
        });

        // Fechar suggestions se clicar fora
        $(document).click(function(e) {
            if (!$(e.target).closest('#cliente_nome, #cliente_suggestions').length) {
                $('#cliente_suggestions').hide();
            }
        });

        // Máscara de peso
        $('input[name="peso"]').mask('000.000', {
            reverse: true
        });

        $(function() {
            $('#especie').select2({
                theme: 'bootstrap4', // usa o tema do AdminLTE
                placeholder: "Selecione ou digite a espécie",
                allowClear: true,
                tags: true, // permite o usuário digitar valores novos
                width: '100%'
            });
        });

        $(function() {
            $('#sexo, #castrado, #esta_vivo').select2({
                theme: 'bootstrap4',
                placeholder: "Selecione...",
                allowClear: true,
                width: '100%'
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Atualiza label com nome do arquivo selecionado
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName || 'Selecionar arquivo');
        });

        // Detecta se é mobile
        let isMobile = /Android|iPhone|iPad|iPod|Windows Phone/i.test(navigator.userAgent);

        if (isMobile) {
            $('#cameraWrapper').removeClass('d-none');
        }
    });
</script>

<script>
    $('#formPet').on('submit', function() {
        const input = $(this).find('input[name="data_nascimento"]');
        if (input.length) {
            const parts = input.val().split('/'); // dd/mm/yyyy
            if (parts.length === 3) {
                input.val(`${parts[2]}-${parts[1]}-${parts[0]}`); // yyyy-mm-dd
            }
        }
    });
    
    $(document).ready(function() {
        // Inicializa o Datepicker
        $('#data_nascimento').datepicker({
            format: 'dd/mm/yyyy',
            endDate: '+0d', // Não permite datas futuras
            startView: 2, // Começa na visão de anos
            autoclose: true,
            todayHighlight: true,
            language: 'pt-BR'
        });

        // Função para calcular idade
        function calcularIdade(dataStr) {
            if (!dataStr) return '';
            const parts = dataStr.split('/');
            if (parts.length !== 3) return '';
            const dia = parseInt(parts[0], 10);
            const mes = parseInt(parts[1], 10) - 1; // JS: 0-11
            const ano = parseInt(parts[2], 10);

            const hoje = new Date();
            const nascimento = new Date(ano, mes, dia);

            let anos = hoje.getFullYear() - nascimento.getFullYear();
            let meses = hoje.getMonth() - nascimento.getMonth();

            if (hoje.getDate() < nascimento.getDate()) {
                meses--;
            }
            if (meses < 0) {
                anos--;
                meses += 12;
            }

            return anos + ' anos' + (meses > 0 ? ' e ' + meses + ' meses' : '');
        }

        // Atualiza idade ao mudar a data
        $('#data_nascimento').on('change', function() {
            const idade = calcularIdade($(this).val());
            $('#idadePet').text(idade ? 'Idade: ' + idade : '');
        });

        // Se já houver data preenchida (edição), calcula a idade
        const dataAtual = $('#data_nascimento').val();
        if (dataAtual) {
            $('#idadePet').text('Idade: ' + calcularIdade(dataAtual));
        }
    });
</script>

<style>
    .suggestions {
        position: absolute;
        border: 1px solid #ccc;
        background: white;
        width: 100%;
        max-height: 150px;
        overflow-y: auto;
        z-index: 1000;
    }

    .suggestions div {
        padding: 5px;
        cursor: pointer;
    }

    .suggestions div:hover {
        background: #f0f0f0;
    }
</style>
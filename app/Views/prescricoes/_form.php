<!-- Cabeçalho com título -->
<div class="modal-header bg-primary text-white">
    <h5 class="modal-title"><i class="fas fa-file-medical"></i>&nbsp;Prescrição</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<form autocomplete="off" action="<?= esc($action) ?>" method="post" id="formPrescricao">
    <?= csrf_field() ?>

    <div class="modal-body">

        <input type="hidden" name="pet_id" value="<?= esc($prescricao['pet_id'] ?? ($pet_id ?? '')) ?>">

        <div class="form-group">
            <label for="data_prescricao">Data da Prescrição</label>
            <input type="date" class="form-control" id="data_prescricao" name="data_prescricao" required
                value="<?= old('data_prescricao', $prescricao['data_prescricao'] ?? date('Y-m-d')) ?>">
        </div>

        <div class="form-group">
            <label for="veterinario_id">Veterinário</label>
            <select name="veterinario_id" id="veterinario_id" class="form-control" required>
                <option value="">Selecione...</option>
                <?php foreach ($veterinarios as $vet): ?>
                    <option value="<?= esc($vet['id']) ?>" <?= isset($prescricao) && $prescricao['veterinario_id'] == $vet['id'] ? 'selected' : '' ?>>
                        <?= esc($vet['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="tipo_prescricao">Tipo de Prescrição</label>
            <select name="tipo_prescricao" id="tipo_prescricao" class="form-control" required>
                <?php
                $tipos = ['Simples' => 'Simples', 'Controle Especial' => 'Controle Especial'];
                $tipoAtual = old('tipo_prescricao', $prescricao['tipo_prescricao'] ?? '');
                ?>
                <option value="">Selecione...</option>
                <?php foreach ($tipos as $key => $label): ?>
                    <option value="<?= esc($key) ?>" <?= $tipoAtual == $key ? 'selected' : '' ?>><?= esc($label) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="instrucoes_gerais">Instruções Gerais</label>
            <textarea name="instrucoes_gerais" id="instrucoes_gerais" class="form-control" rows="3"><?= old('instrucoes_gerais', $prescricao['instrucoes_gerais'] ?? '') ?></textarea>
        </div>

        <hr>
        <h5>Medicamentos</h5>
        <div id="medicamentos-container">
            <?php
            $meds = !empty($medicamentos) ? $medicamentos : [['nome_medicamento' => '', 'tipo_farmacia' => '', 'via' => '', 'posologia' => '', 'quantidade' => '', 'observacoes' => '']];
            foreach ($meds as $index => $med): ?>
                <div class="medicamento-item border rounded p-3 mb-3">
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-danger btn-sm btnRemoveMedicamento"><i class="fas fa-trash"></i></button>
                    </div>
                    <div class="form-group position-relative">
                        <label>Nome do Medicamento</label>
                        <input type="text" name="medicamentos[<?= $index ?>][nome_medicamento]"
                            class="form-control medicamento-nome"
                            value="<?= esc($med['nome_medicamento']) ?>" autocomplete="off" required>
                        <div class="autocomplete-results bg-white border rounded shadow-sm mt-1 position-absolute w-100"
                            style="z-index: 1000; display: none;"></div>
                    </div>
                    <!-- resto do formulário de medicamento... -->
                    <div class="form-group">
                        <label>Tipo Farmácia</label>
                        <select name="medicamentos[<?= $index ?>][tipo_farmacia]" class="form-control" required>
                            <?php $tiposFarmacia = ['Humana', 'Veterinária']; ?>
                            <option value="">Selecione...</option>
                            <?php foreach ($tiposFarmacia as $tf): ?>
                                <option value="<?= $tf ?>" <?= $med['tipo_farmacia'] == $tf ? 'selected' : '' ?>><?= $tf ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Via</label>
                        <select name="medicamentos[<?= $index ?>][via]" class="form-control" required>
                            <?php $vias = ['Oral', 'Tópico', 'Oftálmico', 'Otológico', 'Ambiente']; ?>
                            <option value="">Selecione...</option>
                            <?php foreach ($vias as $via): ?>
                                <option value="<?= $via ?>" <?= $med['via'] == $via ? 'selected' : '' ?>><?= $via ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Posologia</label>
                        <input type="text" name="medicamentos[<?= $index ?>][posologia]" class="form-control" value="<?= esc($med['posologia']) ?>" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label>Quantidade</label>
                        <input type="number" name="medicamentos[<?= $index ?>][quantidade]" class="form-control" value="<?= esc($med['quantidade']) ?>" min="1" required>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="form-group d-flex justify-content-end">
            <button type="button" class="btn btn-info mb-3" id="btnAddMedicamento">+ Adicionar Medicamento</button>
        </div>
        <div class="form-group d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Salvar Prescrição</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        let medIndex = <?= count($meds) ?>;

        // Função de autocomplete
        function attachAutocomplete($input) {
            let $results = $input.siblings(".autocomplete-results");

            $input.on("keyup", function() {
                let query = $(this).val();
                if (query.length < 2) {
                    $results.hide();
                    return;
                }

                $.getJSON("<?= site_url("medicamentos/search") ?>", {
                    term: query
                }, function(data) {
                    $results.empty();
                    if (data.length > 0) {
                        data.forEach(item => {
                            $results.append(`
                            <div class="p-2 result-item" style="cursor:pointer;">
                                <strong>${item.nome_comercial}</strong><br>
                                <small>Princípio Ativo: ${item.principio_ativo} - forma: ${item.forma}</small><br>
                                <small>Classe: ${item.classe_terapeutica}</small>
                            </div>
                        `);
                        });
                        $results.show();
                    } else {
                        $results.hide();
                    }
                });
            });

            // Clique em sugestão
            $results.on("click", ".result-item", function() {
                $input.val($(this).find("strong").text());
                $results.hide();
            });

            // Fechar se clicar fora
            $(document).on("click", function(e) {
                if (!$(e.target).closest($input).length && !$(e.target).closest($results).length) {
                    $results.hide();
                }
            });
        }

        // Ativar autocomplete nos já existentes
        $(".medicamento-nome").each(function() {
            attachAutocomplete($(this));
        });

        // Botão adicionar medicamento
        $('#btnAddMedicamento').on('click', function() {
            let novoMedicamento = `
        <div class="medicamento-item border rounded p-3 mb-3">
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-danger btn-sm btnRemoveMedicamento"><i class="fas fa-trash"></i></button>
            </div>
            <div class="form-group position-relative">
                <label>Nome do Medicamento</label>
                <input type="text" name="medicamentos[${medIndex}][nome_medicamento]" 
                       class="form-control medicamento-nome" autocomplete="off" required>
                <div class="autocomplete-results bg-white border rounded shadow-sm mt-1 position-absolute w-100" 
                     style="z-index: 1000; display:none;"></div>
            </div>
            <!-- resto do form do medicamento igual ao seu -->
            <div class="form-group">
                    <label>Tipo Farmácia</label>
                    <select name="medicamentos[${medIndex}][tipo_farmacia]" class="form-control" required>
                        <option value="">Selecione...</option>
                        <option value="Humana">Humana</option>
                        <option value="Veterinária">Veterinária</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Via</label>
                    <select name="medicamentos[${medIndex}][via]" class="form-control" required>
                        <option value="">Selecione...</option>
                        <option value="Oral">Oral</option>
                        <option value="Tópico">Tópico</option>
                        <option value="Oftálmico">Oftálmico</option>
                        <option value="Otológico">Otológico</option>
                        <option value="Ambiente">Ambiente</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Posologia</label>
                    <input type="text" name="medicamentos[${medIndex}][posologia]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Quantidade</label>
                    <input type="number" name="medicamentos[${medIndex}][quantidade]" class="form-control" min="1" required>
                </div>
        </div>`;
            $('#medicamentos-container').append(novoMedicamento);

            // ativar autocomplete no novo campo
            attachAutocomplete($(`#medicamentos-container .medicamento-item:last .medicamento-nome`));

            medIndex++;
        });

        // Remover medicamento
        $(document).on('click', '.btnRemoveMedicamento', function(e) {
            e.preventDefault(); // evita submit acidental
            e.stopPropagation(); // garante que não suba o clique
            $(this).closest('.medicamento-item').remove();
        });
    });
</script>
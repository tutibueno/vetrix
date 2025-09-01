<form id="formSolicitacaoExame"
    action="<?= isset($exame)
                ? base_url('exames/update/' . $exame['id'])
                : base_url('exames/store/' . $pet['id']) ?>"
    method="post">

    <?= csrf_field() ?>
    <div class="modal-header bg-primary text-white">
        <h5 class="modal-title"><i class="fas fa-vials"></i>&nbsp;Solicitação de Exame</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">

        <!-- Veterinário -->
        <div class="mb-3">
            <label class="form-label">Veterinário Responsável</label>
            <select name="veterinario_id" class="form-control" required>
                <option value="">-- Selecione --</option>
                <?php foreach ($veterinarios as $v): ?>
                    <option value="<?= $v['id'] ?>"
                        <?= isset($exame) && $exame['veterinario_id'] == $v['id'] ? 'selected' : '' ?>>
                        <?= esc($v['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Data da solicitação -->
        <div class="mb-3">
            <label class="form-label">Data da Solicitação</label>
            <input type="date" name="data_solicitacao" class="form-control"
                value="<?= isset($exame) ? esc($exame['data_solicitacao']) : date('Y-m-d') ?>" required>
        </div>

        <!-- Observações gerais -->
        <div class="mb-3">
            <label class="form-label">Observações</label>
            <textarea name="observacoes" class="form-control" rows="2"></textarea>
        </div>

        <hr>

        <!-- ===== Exames ===== -->
        <div class="mb-3">
            <h6><i class="fas fa-vial"></i> Exames</h6>
            <div id="exames-list">
                <?php if (!empty($exame['exames'])): ?>
                    <?php foreach ($exame['exames'] as $i => $ex): ?>
                        <div class="exame-item mb-2 border p-2 rounded d-flex flex-column flex-sm-row align-items-sm-center justify-content-between">
                            <div class="flex-grow-1 me-sm-2">
                                <input type="text" name="exames[<?= $i ?>][nome_exame]" class="form-control mb-1" placeholder="Nome do Exame" value="<?= esc($ex['nome_exame']) ?>" required>
                                <input type="text" name="exames[<?= $i ?>][observacoes]" class="form-control" placeholder="Observações" value="<?= esc($ex['observacoes']) ?>">
                            </div>
                            <button type="button" class="btn btn-danger btn-sm mt-2 mt-sm-0 remove-exame"><i class="fas fa-trash"></i></button>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <button type="button" class="btn btn-sm btn-secondary mt-2" id="addExame"><i class="fas fa-plus"></i> Adicionar Exame</button>
        </div>

        <hr>

        <!-- ===== Motivos / Suspeitas ===== -->
        <div class="mb-3">
            <h6><i class="fas fa-question-circle"></i> Motivos / Suspeitas</h6>
            <div id="motivos-list">
                <?php if (!empty($exame['motivos'])): ?>
                    <?php foreach ($exame['motivos'] as $i => $m): ?>
                        <div class="input-group mb-2 motivo-item">
                            <input type="text" name="motivos[<?= $i ?>][motivo_suspeita]" class="form-control" placeholder="Motivo/Suspeita" value="<?= esc($m['motivo_suspeita']) ?>">
                            <button type="button" class="btn btn-danger remove-motivo"><i class="fas fa-trash"></i></button>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <button type="button" class="btn btn-sm btn-secondary mt-2" id="addMotivo"><i class="fas fa-plus"></i> Adicionar Motivo</button>
        </div>

    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary">Salvar Solicitação</button>
    </div>
</form>
<script>
    (function() {
        const form = document.getElementById('formSolicitacaoExame');
        if (!form) return;

        const examesList = form.querySelector('#exames-list');
        const motivosList = form.querySelector('#motivos-list');
        const addExameBtn = form.querySelector('#addExame');
        const addMotivoBtn = form.querySelector('#addMotivo');

        // índices baseados no que já veio da view (edição) 
        let exameIndex = examesList.querySelectorAll('.exame-item').length;
        let motivoIndex = motivosList.querySelectorAll('.motivo-item').length;

        // Se não houver nenhuma linha, cria 1 padrão de cada
        if (exameIndex === 0) addExameRow();
        if (motivoIndex === 0) addMotivoRow();

        // Handlers
        if (addExameBtn) addExameBtn.addEventListener('click', function(e) {
            e.preventDefault();
            addExameRow();
        });
        if (addMotivoBtn) addMotivoBtn.addEventListener('click', function(e) {
            e.preventDefault();
            addMotivoRow();
        });

        examesList.addEventListener('click', function(e) {
            const btn = e.target.closest('.remove-exame');
            if (!btn) return;
            const row = btn.closest('.exame-item');
            row?.remove();
        });

        motivosList.addEventListener('click', function(e) {
            const btn = e.target.closest('.remove-motivo');
            if (!btn) return;
            const row = btn.closest('.motivo-item');
            row?.remove();
        });

        // Funções auxiliares
        function addExameRow() {
            const div = document.createElement('div');
            div.className = 'exame-item mb-2 border p-2 rounded d-flex flex-column flex-sm-row align-items-sm-center justify-content-between';
            div.innerHTML = `
        <div class="flex-grow-1 me-sm-2">
            <input type="text" name="exames[${exameIndex}][nome_exame]" class="form-control mb-1" placeholder="Nome do Exame" required>
            <input type="text" name="exames[${exameIndex}][observacoes]" class="form-control" placeholder="Observações">
        </div>
        <button type="button" class="btn btn-danger btn-sm mt-2 mt-sm-0 remove-exame"><i class="fas fa-trash"></i></button>
    `;
            examesList.appendChild(div);
            exameIndex++;
        }

        function addMotivoRow() {
            const div = document.createElement('div');
            div.className = 'input-group mb-2 motivo-item';
            div.innerHTML = `
            <input type="text" name="motivos[${motivoIndex}][motivo_suspeita]" class="form-control" placeholder="Motivo/Suspeita">
            <button type="button" class="btn btn-danger remove-motivo"><i class="fas fa-trash"></i></button>
        `;
            motivosList.appendChild(div);
            motivoIndex++;
        }
    })();
</script>
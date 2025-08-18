<form action="<?= isset($exame)
                    ? base_url('exames/update/' . $exame['id'])
                    : base_url('exames/store/' . $pet['id']) ?>"
    method="post">

    <?= csrf_field() ?>
    <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Solicitação de Exame</h5>
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

        <!-- ================== EXAMES ================== -->
        <h5>Exames</h5>
        <table class="table table-bordered" id="tabelaExames">
            <thead class="table-light">
                <tr>
                    <th>Nome do Exame</th>
                    <th>Observações</th>
                    <th style="width: 50px;">Ação</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="text" name="exames[0][nome_exame]" class="form-control" required></td>
                    <td><input type="text" name="exames[0][observacoes]" class="form-control"></td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-danger remove-exame">×</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <button type="button" class="btn btn-sm btn-success" id="addExame">+ Adicionar Exame</button>

        <hr>

        <!-- ================== MOTIVOS ================== -->
        <h5>Motivos / Suspeitas</h5>
        <table class="table table-bordered" id="tabelaMotivos">
            <thead class="table-light">
                <tr>
                    <th>Motivo / Suspeita</th>
                    <th style="width: 50px;">Ação</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="text" name="motivos[0][motivo]" class="form-control" required></td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-danger remove-motivo">×</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <button type="button" class="btn btn-sm btn-success" id="addMotivo">+ Adicionar Motivo</button>

    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary">Salvar Solicitação</button>
    </div>
</form>
<script>
    let exameIndex = 1;
    let motivoIndex = 1;

    // Adicionar exame
    document.getElementById('addExame').addEventListener('click', function() {
        let tabela = document.querySelector('#tabelaExames tbody');
        let row = `
      <tr>
        <td><input type="text" name="exames[${exameIndex}][nome_exame]" class="form-control" required></td>
        <td><input type="text" name="exames[${exameIndex}][observacoes]" class="form-control"></td>
        <td class="text-center">
          <button type="button" class="btn btn-sm btn-danger remove-exame">×</button>
        </td>
      </tr>`;
        tabela.insertAdjacentHTML('beforeend', row);
        exameIndex++;
    });

    // Remover exame
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-exame')) {
            e.target.closest('tr').remove();
        }
    });

    // Adicionar motivo
    document.getElementById('addMotivo').addEventListener('click', function() {
        let tabela = document.querySelector('#tabelaMotivos tbody');
        let row = `
      <tr>
        <td><input type="text" name="motivos[${motivoIndex}][motivo]" class="form-control" required></td>
        <td class="text-center">
          <button type="button" class="btn btn-sm btn-danger remove-motivo">×</button>
        </td>
      </tr>`;
        tabela.insertAdjacentHTML('beforeend', row);
        motivoIndex++;
    });

    // Remover motivo
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-motivo')) {
            e.target.closest('tr').remove();
        }
    });
</script>
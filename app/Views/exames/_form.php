<form action="<?= esc($action) ?>" method="post">

    <div class="card card-primary">
        <div class="card-body">

            <!-- Cabeçalho com título -->
            <div class="modal-header">
                <h5 class="modal-title" id="tituloModalExames">Solicitação de Exames</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            <input type="hidden" name="pet_id" value="<?= $pet_id ?>">

            <div class="mb-3">
                <label for="observacoes_gerais" class="form-label">Observações Gerais</label>
                <textarea class="form-control" name="observacoes_gerais" id="observacoes_gerais"></textarea>
            </div>

            <button type="submit" class="btn btn-success">Salvar Solicitação</button>
        </div>
    </div>
</form>
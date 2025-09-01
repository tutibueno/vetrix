<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container">
    <h2>Adicionar Medicamentos à Prescrição</h2>
    <p><strong>Prescrição:</strong> <?= esc($prescricao['id']) ?> - Pet: <?= esc($prescricao['pet_id']) ?></p>

    <form action="<?= site_url('prescricoes/' . $prescricao['id'] . '/medicamentos/store') ?>" method="post">
        <table class="table" id="medicamentosTable">
            <thead>
                <tr>
                    <th>Nome do Medicamento</th>
                    <th>Tipo Receita</th>
                    <th>Tipo Farmácia</th>
                    <th>Via</th>
                    <th>Posologia</th>
                    <th>Quantidade</th>
                    <th>Observações</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="text" name="medicamentos[0][nome_medicamento]" class="form-control" required></td>
                    <td>
                        <select name="medicamentos[0][tipo_receita]" class="form-control" required>
                            <option value="">Selecione</option>
                            <option value="Simples">Simples</option>
                            <option value="Fórmula Manipulada">Fórmula Manipulada</option>
                        </select>
                    </td>
                    <td>
                        <select name="medicamentos[0][tipo_farmacia]" class="form-control" required>
                            <option value="">Selecione</option>
                            <option value="Humana">Humana</option>
                            <option value="Veterinária">Veterinária</option>
                        </select>
                    </td>
                    <td>
                        <select name="medicamentos[0][via]" class="form-control" required>
                            <option value="">Selecione</option>
                            <option value="Oral">Oral</option>
                            <option value="Tópico">Tópico</option>
                            <option value="Oftálmico">Oftálmico</option>
                            <option value="Otológico">Otológico</option>
                            <option value="Ambiente">Ambiente</option>
                        </select>
                    </td>
                    <td><input type="text" name="medicamentos[0][posologia]" class="form-control"></td>
                    <td><input type="number" name="medicamentos[0][quantidade]" class="form-control"></td>
                    <td><input type="text" name="medicamentos[0][observacoes]" class="form-control"></td>
                    <td><button type="button" class="btn btn-danger removeMedicamento">X</button></td>
                </tr>
            </tbody>
        </table>

        <button type="button" id="addMedicamento" class="btn btn-primary">Adicionar Medicamento</button>
        <button type="submit" class="btn btn-success">Salvar Medicamentos</button>
    </form>
</div>

<script>
    let count = 1;
    document.getElementById('addMedicamento').addEventListener('click', function() {
        const table = document.getElementById('medicamentosTable').getElementsByTagName('tbody')[0];
        const newRow = table.rows[0].cloneNode(true);
        newRow.querySelectorAll('input, select').forEach(function(input) {
            const name = input.getAttribute('name');
            input.setAttribute('name', name.replace(/\[\d+\]/, '[' + count + ']'));
            input.value = '';
        });
        table.appendChild(newRow);
        count++;
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('removeMedicamento')) {
            const row = e.target.closest('tr');
            if (document.querySelectorAll('#medicamentosTable tbody tr').length > 1) {
                row.remove();
            }
        }
    });
</script>

<?= $this->endSection() ?>
<div class="container mt-4">

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table id="tabelaCirurgias" class="table table-striped mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Pet</th>
                        <th>Data</th>
                        <th>Observações</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($cirurgias)): ?>
                        <?php foreach ($cirurgias as $c): ?>
                            <tr>
                                <td><?= esc($c['id']) ?></td>
                                <td><?= esc($c['pet_nome']) ?></td>
                                <td><?= date('d/m/Y', strtotime($c['data_cirurgia'])) ?></td>
                                <td><?= esc($c['observacoes']) ?></td>
                                <td class="text-end">
                                    <a href="<?= site_url('cirurgias/show/' . $c['id']) ?>"
                                        class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?= site_url('cirurgias/edit/' . $c['id']) ?>"
                                        class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?= site_url('cirurgias/delete/' . $c['id']) ?>"
                                        class="btn btn-sm btn-danger"
                                        onclick="return confirm('Tem certeza que deseja excluir?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted">Nenhuma cirurgia encontrada.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {

        function carregarCirurgias(pet_id) {
            fetch("<?= site_url('cirurgias/list/') ?>" + pet_id)
                .then(response => response.json())
                .then(data => {
                    let tbody = document.querySelector("#tabelaCirurgias tbody");
                    tbody.innerHTML = "";

                    if (data.length > 0) {
                        data.forEach(c => {
                            // Concatenar nomes das cirurgias
                            let nomesCirurgias = c.detalhes.map(d => `"${d.nome_cirurgia}"`).join(", ");

                            let tr = document.createElement("tr");

                            tr.innerHTML = `
                        <td>${c.id}</td>
                        <td>${c.pet_nome ?? '-'}</td>
                        <td>${new Date(c.data_cirurgia).toLocaleDateString('pt-BR')}</td>
                        <td>
                            <strong>Veterinário:</strong> ${c.vet_nome ?? '-'}<br>
                            <strong>Observações:</strong> ${c.observacoes ?? ''}<br>
                            <small class="text-muted">Cirurgias: ${nomesCirurgias}</small>
                        </td>
                        <td class="text-end">
                            <a href="<?= site_url('cirurgias/show/') ?>${c.id}" 
                               class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="<?= site_url('cirurgias/edit/') ?>${c.id}" 
                               class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="<?= site_url('cirurgias/delete/') ?>${c.id}" 
                               class="btn btn-sm btn-danger" 
                               onclick="return confirm('Tem certeza que deseja excluir?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    `;

                            tbody.appendChild(tr);
                        });

                        // Evento visualizar
                        document.querySelectorAll(".btnShow").forEach(btn => {
                            btn.addEventListener("click", function() {
                                let id = this.getAttribute("data-id");
                                $("#modalGlobal").modal("show")
                                    .find(".modal-content")
                                    .load("<?= site_url('cirurgias/show/') ?>" + id);
                            });
                        });

                        // Evento editar
                        document.querySelectorAll(".btnEdit").forEach(btn => {
                            btn.addEventListener("click", function() {
                                let id = this.getAttribute("data-id");
                                $("#modalGlobal").modal("show")
                                    .find(".modal-content")
                                    .load("<?= site_url('cirurgias/edit/') ?>" + id);
                            });
                        });

                        // Evento excluir
                        document.querySelectorAll(".btnDelete").forEach(btn => {
                            btn.addEventListener("click", function() {
                                let id = this.getAttribute("data-id");
                                Swal.fire({
                                    title: "Tem certeza?",
                                    text: "Essa ação não poderá ser desfeita!",
                                    icon: "warning",
                                    showCancelButton: true,
                                    confirmButtonText: "Sim, excluir!",
                                    cancelButtonText: "Cancelar"
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $.get("<?= base_url('cirurgias/delete') ?>/" + id, function() {
                                            Swal.fire("Excluído!", "Registro removido.", "success");
                                            carregarCirurgias(<?= $pet['id'] ?>);
                                        }).fail(() => {
                                            Swal.fire("Erro", "Não foi possível excluir o registro.", "error");
                                        });
                                    }
                                });
                            });
                        });

                    } else {
                        tbody.innerHTML = `<tr><td colspan="5" class="text-center text-muted">Nenhuma cirurgia encontrada.</td></tr>`;
                    }
                })
                .catch(error => {
                    console.error("Erro ao carregar cirurgias:", error);
                });
        }

        // carregar ao abrir aba Peso
        $('button[data-bs-target="#cirurgias"]').on('shown.bs.tab', function() {
            carregarCirurgias(<?= $pet['id'] ?>);
        });

        // Adicionar nova cirurgia (abre modal global)
        $(document).on('click', '#btnAdicionarCirurgia', function() {
            let petId = $(this).data('pet-id');
            $('#modalGlobalContent').html('<div class="p-3 text-center"><i class="fas fa-spinner fa-spin"></i> Carregando...</div>');
            $('#modalGlobal').modal('show');

            $.get("<?= base_url('cirurgias/create') ?>/" + petId, function(html) {
                $('#modalGlobalContent').html(html);
            });
        });

        // Editar
        $(document).on('click', '.btnEditarCirurgia', function() {
            let id = $(this).data('id');
            $('#modalGlobalContent').html('<div class="p-3 text-center"><i class="fas fa-spinner fa-spin"></i> Carregando...</div>');
            $('#modalGlobal').modal('show');
            $.get("<?= base_url('cirurgias/edit') ?>/" + id, function(html) {
                $('#modalGlobalContent').html(html);
                //if (typeof initECC === 'function') initECC(); // inicializa ECC
            });
        });

        // Atualizar lista após salvar
        $(document).on('submit', '#formCirurgia', function(e) {
            e.preventDefault();
            let form = $(this);
            $.post(form.attr('action'), form.serialize(), function() {
                $('#modalGlobal').modal('hide');
                carregarCirurgias(<?= $pet['id'] ?>); // Corrigido: recarregar cirurgias, não pesos
                showToast('success', 'Cirurgia registrada com sucesso!', '');
            }).fail(() => {
                Swal.fire("Erro", "Não foi possível salvar o registro.", "error");
            });
        });

    });
</script>
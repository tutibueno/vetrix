<div class="container mt-4">

    <div id="listaCirurgias" class="row g-3">
        <!-- Cards de cirurgias serão carregados aqui via JS -->
    </div>
</div>

<script>
    $(document).ready(function() {

        function carregarCirurgias(pet_id) {
            fetch("<?= site_url('cirurgias/list/') ?>" + pet_id)
                .then(res => res.json())
                .then(data => {
                    const container = $("#listaCirurgias");
                    container.html("");

                    if (data.length > 0) {
                        data.forEach(c => {
                            const dtFmt = formatarDataBR(c.data_cirurgia);
                            let detalhesHtml = "";
                            if (c.detalhes && c.detalhes.length > 0) {
                                c.detalhes.forEach(d => {
                                    detalhesHtml += `
                                    <div class="bg-light border rounded p-2 mb-2">
                                        <strong>Nome:</strong> ${d.nome_cirurgia}<br>
                                        <strong>Materiais/Implantes:</strong> ${d.materiais}<br>
                                        <strong>Complicações:</strong> ${d.complicacoes}
                                    </div>`;
                                });
                            } else {
                                detalhesHtml = `<div class="text-muted">Nenhum detalhe registrado.</div>`;
                            }

                            let cardHtml = `
                            <div class="col-12">
                                <div class="card shadow-sm">
                                    <div class="card-header">
                                        <strong>${dtFmt}</strong><br>
                                        Veterinário: ${c.vet_nome ?? '-'}
                                    </div>
                                    <div class="card-body">
                                        <p>${c.observacoes ?? ''}</p>
                                        <h6 class="mt-3 mb-2">Detalhes da Cirurgia</h6>
                                        ${detalhesHtml}
                                    </div>
                                    <div class="card-footer text-end">
                                        <button class="btn btn-sm btn-warning" onclick="abrirModal('<?= site_url('cirurgias/edit/') ?>', ${c.id})">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="excluirCirurgia(${c.id})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;
                            container.append(cardHtml);
                        });
                    } else {
                        container.html(`<div class="col-12 text-center text-muted">Nenhuma cirurgia encontrada.</div>`);
                    }
                })
                .catch(err => console.error("Erro ao carregar cirurgias:", err));
        }

        // carregar ao abrir aba Cirurgias
        $('button[data-bs-target="#cirurgias"]').on('shown.bs.tab', function() {
            carregarCirurgias(<?= $pet['id'] ?>);
        });

        // Abrir modal para adicionar cirurgia
        $(document).on('click', '#btnAdicionarCirurgia', function() {
            let petId = $(this).data('pet-id');
            $('#modalContent').html('<div class="p-3 text-center"><i class="fas fa-spinner fa-spin"></i> Carregando...</div>');
            $('#modalFormulario').modal('show');

            $.get("<?= base_url('cirurgias/create') ?>/" + petId, function(html) {
                $('#modalContent').html(html);
            });
        });

        // Abrir modal para editar/visualizar cirurgia
        window.abrirModal = function(url, id) {
            $('#modalContent').html('<div class="p-3 text-center"><i class="fas fa-spinner fa-spin"></i> Carregando...</div>');
            $('#modalFormulario').modal('show');
            $.get(url + id, function(html) {
                $('#modalContent').html(html);
            });
        };

        // Excluir cirurgia
        window.excluirCirurgia = function(id) {
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
        };

        // Atualizar lista após salvar
        $(document).on('submit', '#formCirurgia', function(e) {
            e.preventDefault();
            let form = $(this);
            $.post(form.attr('action'), form.serialize(), function() {
                $('#modalFormulario').modal('hide');
                carregarCirurgias(<?= $pet['id'] ?>);
                showToast('success', 'Cirurgia registrada com sucesso!', '');
            }).fail(() => {
                Swal.fire("Erro", "Não foi possível salvar o registro.", "error");
            });
        });

    });

    // Corrige a data (sem perder 1 dia por causa do fuso)
    function formatarDataBR(dateString) {
        if (!dateString) return '';
        const partes = dateString.split('-'); // [YYYY, MM, DD]
        return `${partes[2]}/${partes[1]}/${partes[0]}`; // dd/mm/yyyy
    }
</script>
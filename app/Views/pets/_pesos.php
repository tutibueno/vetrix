<div class="mb-4">
    <canvas id="graficoPeso" style="max-height: 300px;"></canvas>
</div>

<div id="pesoCards">

</div>

<script>
    let graficoPeso = null;

    // Array de descrições da Escala de Condição Corporal (ECC) direto no JS
    const escalaDescricao = {
        "1": "Muito magro – Caquético, ossos visíveis, sem gordura palpável",
        "2": "Magro – Ossos evidentes, pouca massa muscular",
        "3": "Abaixo do ideal – Costelas fáceis de ver, pouca cobertura de gordura",
        "4": "Magro leve – Costelas palpáveis com pouca gordura, cintura evidente",
        "5": "Ideal – Costelas palpáveis sem excesso de gordura, boa proporção",
        "6": "Levemente acima do peso – Costelas palpáveis com leve excesso de gordura",
        "7": "Sobrepeso – Costelas difíceis de sentir, acúmulo de gordura abdominal",
        "8": "Obeso – Depósitos significativos de gordura, cintura pouco visível",
        "9": "Muito obeso – Obesidade severa, sem cintura, abdômen proeminente"
    };

    function carregarPesos() {
        $.getJSON("<?= site_url('pesos/list/' . $pet['id']) ?>")
            .done(function(data) {
                let html = '';
                let labels = [];
                let pesos = [];

                if (!data || data.length === 0) {
                    html = `<div class="col-12"><div class="alert alert-info text-center">Nenhum registro de peso encontrado.</div></div>`;
                } else {
                    data.forEach(p => {
                        // Formata data no formato dd/mm/yyyy
                        const dtFmt = formatarDataBR(p.data_registro);

                        labels.push(dtFmt);
                        pesos.push(parseFloat(p.peso_kg));

                        // Descrição ECC
                        let eccDesc = '';
                        if (p.escala_condicao_corporal && escalaDescricao[p.escala_condicao_corporal]) {
                            eccDesc = `${p.escala_condicao_corporal}/9 <br> ${escalaDescricao[p.escala_condicao_corporal]}`;
                        }

                        html += `
                        <div class="col-12">
                            <div class="card shadow-sm mb-3">
                                <div class="card-body">
                                    <p class="card-text mb-1"><b>Data:</b> ${dtFmt} (com ${p.idade} de idade)</p>
                                    <p class="card-text mb-1"><b>Peso:</b> ${parseFloat(p.peso_kg).toFixed(3)} kg</p>
                                    ${eccDesc ? `<p class="card-text mb-1"><b>Escala Condição Corporal:</b> ${eccDesc}</p>` : ''}
                                    ${p.observacoes ? `<p class="card-text mb-1"><b>Observações:</b> ${p.observacoes}</p>` : ''}
                                </div>
                                <div class="card-footer d-flex justify-content-end gap-2">
                                    <button class="btn btn-sm btn-info btnEditarPeso" data-id="${p.id}">
                                        <i class="fas fa-edit"></i> Editar
                                    </button>
                                    <button class="btn btn-sm btn-danger btnExcluirPeso" data-id="${p.id}">
                                        <i class="fas fa-trash"></i> Excluir
                                    </button>
                                </div>
                            </div>
                        </div>`;
                    });
                }
                $("#pesoCards").html(html);

                // Atualiza gráfico
                if (graficoPeso) {
                    graficoPeso.destroy();
                }

                const ctx = document.getElementById('graficoPeso').getContext('2d');
                graficoPeso = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels.reverse(),
                        datasets: [{
                            label: 'Peso (kg)',
                            data: pesos.reverse(),
                            borderColor: '#007bff',
                            backgroundColor: 'rgba(0, 123, 255, 0.2)',
                            fill: true,
                            tension: 0.3,
                            pointRadius: 5,
                            pointHoverRadius: 7
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        aspectRatio: 1.2,
                        plugins: {
                            legend: {
                                display: true
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.parsed.y.toFixed(3) + ' kg';
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true // Ensure it doesn't force a 0 start
                            }
                        }

                    }
                });
            })
            .fail(function() {
                $("#pesoCards").html(`<div class="col-12"><div class="alert alert-danger text-center">Erro ao carregar registros de peso.</div></div>`);
            });
    }
</script>

<script>
    // Função auxiliar para escapar HTML (evita XSS)
    function escapeHtml(text) {
        if (text === null || text === undefined) return '';
        return String(text)
            .replace(/&/g, '&amp;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');
    }
</script>

<script>
    $(document).ready(function() {

        // carregar ao abrir aba Peso
        $('button[data-bs-target="#pesos"]').on('shown.bs.tab', function() {
            carregarPesos(<?= $pet['id'] ?>);
        });

        // Novo registro
        $(document).on('click', '#btnNovoPeso', function() {
            let petId = $(this).data('pet-id');
            $('#modalGlobalContent').html('<div class="p-3 text-center"><i class="fas fa-spinner fa-spin"></i> Carregando...</div>');
            $('#modalGlobal').modal('show');
            $.get("<?= base_url('pesos/create') ?>/" + petId, function(html) {
                $('#modalGlobalContent').html(html);
                if (typeof initECC === 'function') initECC(); // inicializa ECC
            });
        });

        // Editar
        $(document).on('click', '.btnEditarPeso', function() {
            let id = $(this).data('id');
            $('#modalGlobalContent').html('<div class="p-3 text-center"><i class="fas fa-spinner fa-spin"></i> Carregando...</div>');
            $('#modalGlobal').modal('show');
            $.get("<?= base_url('pesos/edit') ?>/" + id, function(html) {
                $('#modalGlobalContent').html(html);
                if (typeof initECC === 'function') initECC(); // inicializa ECC
            });
        });

        // Excluir
        $(document).on('click', '.btnExcluirPeso', function() {
            let id = $(this).data('id');
            Swal.fire({
                title: "Excluir registro?",
                text: "Essa ação não poderá ser desfeita.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sim, excluir",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.get("<?= base_url('pesos/delete') ?>/" + id, function() {
                        Swal.fire("Excluído!", "Registro removido.", "success");
                        carregarPesos(<?= $pet['id'] ?>);
                    }).fail(() => {
                        Swal.fire("Erro", "Não foi possível excluir o registro.", "error");
                    });
                }
            });
        });

        // Atualizar lista após salvar
        $(document).on('submit', 'form[action*="pesos/store"], form[action*="pesos/update"]', function(e) {
            e.preventDefault();
            let form = $(this);
            $.post(form.attr('action'), form.serialize(), function() {
                $('#modalGlobal').modal('hide');
                carregarPesos(<?= $pet['id'] ?>);
                showToast('success', 'Peso registrado com sucesso!', '')
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
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? 'Admin' ?></title>
    <link rel="stylesheet" href="<?= base_url('adminlte/plugins/fontawesome-free/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('adminlte/dist/css/adminlte.min.css') ?>">

    <!-- JS Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    <!-- Scripts -->
    <script src="<?= base_url('adminlte/plugins/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('adminlte/dist/js/adminlte.min.js') ?>"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- jQuery Mask Plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>



</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <?= $this->include('layouts/navbar') ?>
        <?= $this->include('layouts/sidebar') ?>

        <div class="content-wrapper">
            <?= $this->renderSection('content') ?>
        </div>

        <?= $this->include('layouts/footer') ?>

    </div>


    <script>
        $(document).ready(function() {
            // Máscaras
            $('input[name="cpf_cnpj"]').mask('000.000.000-00', {
                reverse: true
            });
            $('input[name="telefone"]').mask('(00) 00000-0000');
            $('input[name="cep"]').mask('00000-000');

            // Mudança de CPF para CNPJ dinamicamente (opcional)
            $('input[name="cpf_cnpj"]').on('input', function() {
                const val = $(this).val().replace(/\D/g, '');
                if (val.length > 11) {
                    $(this).mask('00.000.000/0000-00', {
                        reverse: true
                    });
                } else {
                    $(this).mask('000.000.000-00', {
                        reverse: true
                    });
                }
            });

            // Auto preencher endereço via ViaCEP
            $('input[name="cep"]').on('blur', function() {
                let cep = $(this).val().replace(/\D/g, '');
                if (cep.length === 8) {
                    $.getJSON(`https://viacep.com.br/ws/${cep}/json/`, function(data) {
                        if (!("erro" in data)) {
                            $('input[name="rua"]').val(data.logradouro);
                            $('input[name="bairro"]').val(data.bairro);
                            $('input[name="cidade"]').val(data.localidade);
                            $('input[name="estado"]').val(data.uf);
                        }
                    });
                }
            });
        });
    </script>

    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            let nome = document.querySelector('[name="nome"]');
            let cpf_cnpj = document.querySelector('[name="cpf_cnpj"]');
            let telefone = document.querySelector('[name="telefone"]');

            if (!nome.value.trim() || !cpf_cnpj.value.trim() || !telefone.value.trim()) {
                e.preventDefault();
                alert('Por favor, preencha os campos obrigatórios: Nome, CPF/CNPJ, Telefone, etc.');
            }
        });
    </script>



</body>

</html>
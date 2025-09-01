<div class="row">
    <div class="col-md-6 mb-3">
        <label>Nome da Clínica *</label>
        <input type="text" name="nome_clinica" class="form-control" value="<?= esc($clinica['nome_clinica'] ?? '') ?>" required>
    </div>
    <div class="col-md-6 mb-3">
        <label>CRMV</label>
        <input type="text" name="crmv" class="form-control" value="<?= esc($clinica['crmv'] ?? '') ?>">
    </div>
    <div class="col-md-6 mb-3">
        <label>Razão Social</label>
        <input type="text" name="razao_social" class="form-control" value="<?= esc($clinica['razao_social'] ?? '') ?>">
    </div>
    <div class="col-md-6 mb-3">
        <label>CNPJ</label>
        <input type="text" id="cnpj" name="cnpj" class="form-control" value="<?= esc($clinica['cnpj'] ?? '') ?>">
    </div>
    <div class="col-md-6 mb-3">
        <label>Registro MAPA</label>
        <input type="text" name="registro_mapa" class="form-control" value="<?= esc($clinica['registro_mapa'] ?? '') ?>">
    </div>
    <div class="col-md-6 mb-3">
        <label>Inscrição Municipal</label>
        <input type="text" name="inscricao_municipal" class="form-control" value="<?= esc($clinica['inscricao_municipal'] ?? '') ?>">
    </div>
    <div class="col-md-6 mb-3">
        <label>Inscrição Estadual</label>
        <input type="text" name="inscricao_estadual" class="form-control" value="<?= esc($clinica['inscricao_estadual'] ?? '') ?>">
    </div>
    <div class="col-md-4 mb-3">
        <label>CEP</label>
        <input type="text" name="cep" class="form-control" value="<?= esc($clinica['cep'] ?? '') ?>">
    </div>
    <div class="col-md-8 mb-3">
        <label>Rua</label>
        <input type="text" name="rua" class="form-control" value="<?= esc($clinica['rua'] ?? '') ?>">
    </div>
    <div class="col-md-2 mb-3">
        <label>Número</label>
        <input type="text" name="numero" class="form-control" value="<?= esc($clinica['numero'] ?? '') ?>">
    </div>
    <div class="col-md-4 mb-3">
        <label>Complemento</label>
        <input type="text" name="complemento" class="form-control" value="<?= esc($clinica['complemento'] ?? '') ?>">
    </div>
    <div class="col-md-6 mb-3">
        <label>Bairro</label>
        <input type="text" name="bairro" class="form-control" value="<?= esc($clinica['bairro'] ?? '') ?>">
    </div>
    <div class="col-md-6 mb-3">
        <label>Cidade</label>
        <input type="text" name="cidade" class="form-control" value="<?= esc($clinica['cidade'] ?? '') ?>">
    </div>
    <div class="col-md-2 mb-3">
        <label>UF</label>
        <input type="text" name="uf" class="form-control" maxlength="2" value="<?= esc($clinica['uf'] ?? '') ?>">
    </div>
    <div class="col-md-4 mb-3">
        <label>Telefone</label>
        <input type="text" name="telefone" class="form-control" value="<?= esc($clinica['telefone'] ?? '') ?>">
    </div>
    <div class="col-md-4 mb-3">
        <label>Celular</label>
        <input type="text" name="celular" class="form-control" value="<?= esc($clinica['celular'] ?? '') ?>">
    </div>
    <div class="col-md-4 mb-3">
        <label>WhatsApp</label>
        <input type="text" name="whatsapp" class="form-control" value="<?= esc($clinica['whatsapp'] ?? '') ?>">
    </div>
    <div class="col-md-6 mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="<?= esc($clinica['email'] ?? '') ?>">
    </div>
</div>

<script>
    $(document).ready(function() {
        // Máscaras
        $('input[name="cnpj"]').mask('00.000.000/0000-00', {
            reverse: true
        });
        $('input[name="telefone"]').mask('(00) 00000-0000');
        $('input[name="celular"]').mask('(00) 00000-0000');
        $('input[name="whatsapp"]').mask('(00) 00000-0000');
        $('input[name="cep"]').mask('00000-000');

        // Auto preencher endereço via ViaCEP
        $('input[name="cep"]').on('blur', function() {
            let cep = $(this).val().replace(/\D/g, '');
            if (cep.length === 8) {
                $.getJSON(`https://viacep.com.br/ws/${cep}/json/`, function(data) {
                    if (!("erro" in data)) {
                        $('input[name="rua"]').val(data.logradouro);
                        $('input[name="bairro"]').val(data.bairro);
                        $('input[name="cidade"]').val(data.localidade);
                        $('input[name="uf"]').val(data.uf);
                    }
                });
            }
        });
    });
</script>
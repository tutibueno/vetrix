<?php
// $clinica deve ser passado pelo controller
?>
<footer class="bg-dark text-white mt-5 py-4">
    <div class="container text-center">
        <p class="mb-1">
            <?= esc($clinica['rua']) ?>, nº <?= esc($clinica['numero']) ?>
            <?= !empty($clinica['complemento']) ? ', ' . esc($clinica['complemento']) : '' ?><br>
            <?= esc($clinica['bairro']) ?> - <?= esc($clinica['cidade']) ?>/<?= esc($clinica['uf']) ?> <br>
            CEP: <?= esc($clinica['cep']) ?>
        </p>

        <p class="mb-1">
            <?php if (!empty($clinica['telefone'])): ?>
                ☎ <?= esc($clinica['telefone']) ?><br>
            <?php endif; ?>
            <?php if (!empty($clinica['celular'])): ?>
                📱 <?= esc($clinica['celular']) ?><br>
            <?php endif; ?>
            <?php if (!empty($clinica['whatsapp'])): ?>
                <a href="https://wa.me/55<?= preg_replace('/\D/', '', $clinica['whatsapp']) ?>"
                    class="text-white text-decoration-none" target="_blank">
                    💬 WhatsApp: <?= esc($clinica['whatsapp']) ?>
                </a><br>
            <?php endif; ?>
        </p>

        <?php if (!empty($clinica['email'])): ?>
            <p class="mb-0">📧 <?= esc($clinica['email']) ?></p>
        <?php endif; ?>
    </div>
</footer>

</html>
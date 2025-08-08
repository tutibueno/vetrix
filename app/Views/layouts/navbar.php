<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Botão do menu -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Navbar à direita -->
    <ul class="navbar-nav ml-auto">
        <?php if (session()->get('logged_in')): ?>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('logout') ?>">Sair</a>
            </li>
        <?php endif; ?>
    </ul>
</nav>
<!-- /.navbar -->
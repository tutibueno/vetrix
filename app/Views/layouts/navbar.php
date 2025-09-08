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

        <!-- Configurações Dropdown -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-cog"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-header">Configurações</span>
                <div class="dropdown-divider"></div>
                <a href="<?= base_url('clinica') ?>" class="dropdown-item">
                    <i class="fas fa-hospital mr-2"></i> Clínica
                </a>
                <div class="dropdown-divider"></div>
                <a href="<?= base_url('users') ?>" class="dropdown-item">
                    <i class="fas fa-users mr-2"></i> Usuários
                </a>
                <div class="dropdown-divider"></div>
                <a href="<?= base_url('veterinarios') ?>" class="dropdown-item">
                    <i class="fas fa-user-md mr-2"></i> Veterinários
                </a>

                <div class="dropdown-divider"></div>
                <a href="<?= base_url('servicos') ?>" class="dropdown-item">
                    <i class="fas fa-cut nav-icon"></i> Serviços Banho & Tosa
                </a>

                <div class="dropdown-divider"></div>
                <a href="<?= base_url('medicamentos') ?>" class="dropdown-item">
                    <i class="fas fa-pills"></i> Gerenciar Medicamentos
                </a>

                <div class="dropdown-divider"></div>
                <a class="dropdown-item disabled" href="#">
                    <i class="fas fa-database mr-2"></i> Backup
                </a>

                <div class="dropdown-divider"></div>
                <a class="dropdown-item disabled" href="#">
                    <i class="fas fa-sliders-h mr-2"></i> Preferências
                </a>

            </div>
        </li>

        <?php if (session()->get('user')): ?>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('logout') ?>">Sair</a>
            </li>
        <?php endif; ?>
    </ul>
</nav>
<!-- /.navbar -->
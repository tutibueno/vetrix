<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Logo -->
    <a href="<?= base_url() ?>" class="brand-link">
        <img src="<?= base_url(); ?>public/logo.png" alt="Logo"
            class="brand-image img-circle elevation-3" style="opacity: 1">
        <span class="brand-text font-weight-light">Vetrix</span>

    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= base_url(); ?>public/adminlte/dist/img/dog-avatar.jpg" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?= session('user_name') ?></a>
            </div>
        </div>

        <!-- Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview">

                <!-- Adicione mais itens conforme necessário -->
                <?php if (session()->get('logged_in')): ?>

                    <li class="nav-header">INÍCIO</li>

                    <li class="nav-item">
                        <a href="<?= base_url() ?>" class="nav-link <?= uri_string() === '' ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Painel</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('client') ?>" class="nav-link <?= uri_string() === 'client' ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Clientes</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('pet') ?>" class="nav-link <?= uri_string() === 'pet' ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-dog"></i>
                            <p>Pets / Pacientes</p>
                        </a>
                    </li>

                    <!-- Outros itens do menu -->

                    <li class="nav-header">AGENDAMENTOS&nbsp;&nbsp;<i class="fas fa-calendar-alt"></i></li>

                    <li class="nav-item">
                        <a href="<?= base_url('consultas') ?>" class="nav-link <?= service('uri')->getSegment(1) == 'consultas' ? 'active' : '' ?>">
                            <i class="fas fa-stethoscope nav-icon"></i>
                            <p>Consultas</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('banhotosa') ?>" class="nav-link <?= service('uri')->getSegment(1) == 'banhotosa' ? 'active' : '' ?>">
                            <i class="fas fa-shower nav-icon"></i>
                            <p>Banho & Tosa</p>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
    <!-- /.sidebar -->
</aside>
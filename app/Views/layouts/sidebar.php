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
                    <li class="nav-item">
                        <a href="<?= base_url() ?>" class="nav-link <?= uri_string() === '' ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Início</p>
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
                            <p>Pets</p>
                        </a>
                    </li>

                    <!-- Outros itens do menu -->

                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>
                                Configurações
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('clinica') ?>" class="nav-link">
                                    <i class="fas fa-clinic-medical mr-2"></i>
                                    <p>Clínica</p>
                                    <span class="right badge badge-info">Clínica</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('users') ?>" class="nav-link">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>Usuários</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('veterinarios') ?>" class="nav-link">
                                    <i class="nav-icon fas fa-user-md"></i>
                                    <p>
                                        Veterinários
                                    </p>
                                </a>
                            </li>

                        </ul>
                    </li>


                <?php endif; ?>
            </ul>
        </nav>
    </div>
    <!-- /.sidebar -->
</aside>
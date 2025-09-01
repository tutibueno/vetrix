<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="<?= base_url('public/favicon.ico') ?>">
    <title><?= $title ?? 'Admin' ?></title>
    <link rel="stylesheet" href="<?= base_url('public/adminlte/plugins/fontawesome-free/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/adminlte/dist/css/adminlte.min.css') ?>">

    <!-- JS Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    <!-- Scripts -->
    <script src="<?= base_url('public/adminlte/plugins/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('public/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('public/adminlte/dist/js/adminlte.min.js') ?>"></script>



    <!-- jQuery Mask Plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>



</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <?= $this->include('layouts/navbar') ?>
        <?= $this->include('layouts/sidebar') ?>

        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    <?= view('layouts/alerts') ?>
                    <?= $this->renderSection('content') ?>
                </div>
                <!-- /.container-fluid -->
            </section>
        </div>
        <?= $this->include('layouts/footer') ?>
    </div>

    <script>
        const alertDurations = {
            'success-alert': 3000,
            'error-alert': 6000,
            'warning-alert': 4500
        };

        Object.entries(alertDurations).forEach(([className, duration]) => {
            const alert = document.querySelector(`.${className}`);
            if (alert) {
                setTimeout(() => {
                    alert.classList.remove('show'); // inicia o fade
                    setTimeout(() => alert.remove(), 500); // remove do DOM após fade
                }, duration);
            }
        });
    </script>

</body>

</html>
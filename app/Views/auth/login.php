<!DOCTYPE html>
<html lang="pt-BR">



<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('public/favicon.ico') ?>">
    <link rel="stylesheet" href="<?= base_url('public/adminlte/plugins/fontawesome-free/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/adminlte/dist/css/adminlte.min.css') ?>">
</head>

<body class="hold-transition login-page">
    <?= view('layouts/alerts') ?>
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="#" class="h1"><b>V</b>etrix</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Faça login para iniciar</p>

                <form action="<?= base_url('login') ?>" method="post">
                    <div class="input-group mb-3">
                        <input type="text" name="username" class="form-control" placeholder="Usuário">
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-user"></span></div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Senha">
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-lock"></span></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8"></div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Entrar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="<?= base_url('public/adminlte/plugins/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('public/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('public/adminlte/dist/js/adminlte.min.js') ?>"></script>
</body>

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

</html>
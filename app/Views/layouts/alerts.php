<?php if (session()->get('success')): ?>
    <div class="alert alert-success alert-dismissible fade show auto-dismiss success-alert" role="alert">
        <?= esc(session()->get('success')) ?>
        
    </div>
<?php endif; ?>

<?php if (session()->get('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show auto-dismiss error-alert" role="alert">
        <?= esc(session()->get('error')) ?>
        
    </div>
<?php endif; ?>

<?php if (session()->get('errors')): ?>
    <div class="alert alert-warning alert-dismissible fade show auto-dismiss warning-alert" role="alert">
        <ul class="mb-0">
            <?php foreach (session()->get('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
        
    </div>
<?php endif; ?>
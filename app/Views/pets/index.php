<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h1 class="mt-4">Pets / Pacientes</h1>

<form method="get" class="mb-3">
  <div class="input-group">
    <input type="text" name="search" class="form-control" placeholder="Buscar por nome do pet ou tutor" value="<?= esc($search) ?>">
    <div class="input-group-append">
      <button class="btn btn-outline-secondary" type="submit">Buscar</button>
    </div>
  </div>
</form>

<a href="<?= site_url('pet/create') ?>" class="btn btn-primary mb-4">
  <i class="fas fa-plus"></i> Novo Pet/Paciente
</a>

<div class="row">
  <?php foreach ($pets as $pet): ?>
    <div class="col-md-4 col-sm-6 mb-4">
      <a href="<?= site_url('pet/ficha/' . $pet['id']) ?>" class="text-decoration-none text-dark">
        <div class="card shadow-sm h-100 pet-card">
          <div class="card-header text-center bg-light">
            <?php if (!empty($pet['foto'])): ?>
              <img src="<?= base_url('public/uploads/pets/' . $pet['foto']) ?>"
                class="img-fluid rounded-circle"
                style="width:100px; height:100px; object-fit:cover;"
                alt="Foto do pet">
            <?php else: ?>
              <i class="fas fa-paw fa-6x text-muted"></i>
            <?php endif; ?>
          </div>
          <div class="card-body text-center">
            <!-- Nome + Sexo -->
            <h5 class="card-title d-block w-100 mb-1">
              <?= esc($pet['nome']) ?>
              <?php if ($pet['sexo'] == 'M'): ?>
                <span class="ml-2 text-primary">
                  <i class="fas fa-mars"></i>
                </span>
              <?php else: ?>
                <span class="ml-2 text-danger">
                  <i class="fas fa-venus"></i>
                </span>
              <?php endif ?>
            </h5>

            <!-- Espécie + Raça -->
            <p class="text-muted mb-2">
              <?= esc($pet['especie']) ?><br>
              -<?= esc($pet['raca']) ?>
            </p>

            <!-- Tutor -->
            <p class="mb-0">
              <strong>Tutor:</strong> <?= esc($pet['tutor']) ?> <?= esc($pet['telefone']) ?>
            </p>
          </div>
          <div class="card-footer text-center d-flex justify-content-center gap-2">
            <!-- Editar -->
            <a href="<?= site_url('pet/edit/' . $pet['id']) ?>" class="btn btn-sm btn-outline-warning" data-bs-toggle="tooltip" title="Editar Pet">
              <i class="fas fa-edit"> Editar</i>
            </a>

            <!-- Ficha -->
            <a href="<?= site_url('pet/ficha/' . $pet['id']) ?>" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="Abrir Ficha">
              <i class="fas fa-notes-medical"> Ficha</i>
            </a>

          </div>
        </div>
      </a>
    </div>
  <?php endforeach; ?>
</div>

<div class="mt-3">
  <?= $pager->links() ?>
</div>

<style>
  .pet-card {
    transition: transform 0.2s, box-shadow 0.2s;
  }

  .pet-card:hover {
    transform: translateY(-5px);
    box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
  }

  /* Badge custom para fêmea */
  .badge-pink {
    background-color: #e83e8c;
    color: #fff;
  }
</style>

<script>
  // Inicializa tooltips do Bootstrap
  document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.forEach(function(tooltipTriggerEl) {
      new bootstrap.Tooltip(tooltipTriggerEl)
    })
  });
</script>

<?= $this->endSection() ?>
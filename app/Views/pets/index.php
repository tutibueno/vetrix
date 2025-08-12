<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
  <h1 class="mt-4">Pets</h1>

  <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session('success') ?></div>
  <?php endif; ?>

  <form method="get" class="mb-3">
    <div class="input-group">
      <input type="text" name="search" class="form-control" placeholder="Buscar por nome do pet ou tutor" value="<?= esc($search) ?>">
      <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="submit">Buscar</button>
      </div>
    </div>
  </form>

  <a href="<?= site_url('pet/create') ?>" class="btn btn-primary mb-3">Novo Pet</a>

  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th>Nome</th>
        <th>Espécie</th>
        <th>Raça</th>
        <th>Sexo</th>
        <th>Tutor</th>
        <th>Foto</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($pets as $pet): ?>
        <tr>
          <td><?= esc($pet['nome']) ?></td>
          <td><?= esc($pet['especie']) ?></td>
          <td><?= esc($pet['raca']) ?></td>
          <td><?= $pet['sexo'] == 'M' ? 'Macho' : 'Fêmea' ?></td>
          <td><?= esc($pet['tutor']) ?></td>
          <td>
            <?php if (!empty($pet['foto'])): ?>
              <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#fotoModal<?= $pet['id'] ?>">
                <i class="fas fa-image"></i>
              </button>

              <!-- Modal -->
              <div class="modal fade" id="fotoModal<?= $pet['id'] ?>" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Foto do Pet</h5>
                      <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body text-center">
                      <img src="<?= base_url('uploads/pets/' . $pet['foto']) ?>" class="img-fluid rounded" alt="Foto do pet">
                    </div>
                  </div>
                </div>
              </div>
            <?php else: ?>
              <span class="text-muted">–</span>
            <?php endif ?>
          </td>
          <td>
            <a href="<?= site_url('pet/edit/' . $pet['id']) ?>" class="btn btn-warning btn-sm">Editar</a>
            <!-- <a href="<?= site_url('pet/delete/' . $pet['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Deseja realmente excluir este pet?')">Excluir</a> -->
            <a href="<?= site_url('pet/ficha/' . $pet['id']) ?>" class="btn btn-sm btn-primary">
              <i class="fas fa-notes-medical"></i> Ficha
            </a>
          </td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>

  <div class="mt-3">
    <?= $pager->links() ?>
  </div>
</div>

<?= $this->endSection() ?>
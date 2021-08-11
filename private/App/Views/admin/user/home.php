<div class="card shadow">
  <div class="card-header border-0">
    <div class="d-flex flex-column-sm mx--3 align-items-center-md">
      <div class="mx-3 flex-fill d-flex align-items-center">
        <h3 class="mb-0 mb-2-sm text-uppercase fw-800">Semua Pengguna</h3>
      </div>
      <div class="mx-3">
        <div class="mx--1 d-flex">
          <div class="mx-1 flex-fill">
            <div class="form-group mb-0">
              <div class="input-group input-group-sm input-group-alternative">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1"><span class="fas fa-search"></span></span>
                </div>
                <input type="text" class="form-control" placeholder="Cari" id="search-datatables">
              </div>
            </div>
          </div>
          <div class="mx-1 d-flex">
            <a href="<?= App\Core\Web::url('admin.user.add'); ?>" class="btn btn-sm btn-primary d-flex align-items-center"><span class="fas fa-plus"></span><span class="d-none d-md-inline-block ml-1">Tambah Pengguna</span></a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <table class="table datatables align-items-center table-flush">
    <thead class="thead-light">
      <tr>
        <th width="1%" scope="col">#</th>
        <th scope="col">Username</th>
        <th scope="col">Nama Lengkap</th>
        <th width="1%" scope="col">Jenis Kelamin</th>
        <th width="1%" scope="col">No Ponsel</th>
        <th width="1%" scope="col">Email</th>
        <th width="1%" scope="col">Grup Pengguna</th>
        <th width="1%" scope="col">Alat</th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1;
      foreach ($data as $d) { ?>
        <tr>
          <td><?= $no; ?></td>
          <td><?= $d['user_username'] ?></td>
          <td><?= trim($d['user_first_name'] . ' ' . $d['user_last_name']); ?></td>
          <td>
            <?php if ($d['user_gender'] !== '0') : ?>
              <span class="badge <?= $d['user_gender'] === '1' ? 'badge-primary' : 'badge-danger' ?>"><i class="<?= $d['user_gender'] === '1' ? 'fas fa-male' : 'fas fa-female' ?>"></i> <?= $d['user_gender'] === '1' ? 'Laki-laki' : 'Perempuan' ?></span>
            <?php elseif ($d['user_gender'] === '0') : ?>
              <span>-</span>
            <?php endif ?>
          </td>
          <td><?= $d['user_phone']; ?></td>
          <td><?= $d['user_email']; ?></td>
          <td>
            <?php foreach ($d['user_groups_name'] as $n) : ?>
              <span class="badge badge-success"><i class="fas fa-certificate"></i> <?= $n; ?></span>
            <?php endforeach; ?>
          </td>
          <td>
            <a title='Edit data' href="<?= App\Core\Web::url('admin.user.edit.' . md5($d['user_id'])) ?>" class="btn btn-secondary btn-sm shadow-none"><i class="fas fa-pencil-alt text-warning"></i></a>
            <button type="button" title='Hapus data' class="btn btn-secondary btn-sm shadow-none" data-toggle="modal" data-target="#modalHapus-<?= md5($d['user_id']) ?>"><i class="fas fa-eraser text-danger"></i></button>
          </td>
        </tr>
        <!-- Modal -->
        <div class="modal fade" id="modalHapus-<?= md5($d['user_id']) ?>" tabindex="-1" role="dialog" aria-labelledby="labelModalHapus-<?= md5($d['user_id']) ?>" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="labelModalHapus-<?= md5($d['user_id']) ?>">Peringatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <h3 class="m-0 font-weight-bold">Yakin ingin Menghapus data?</h3>
              </div>
              <div class="modal-footer">
                <form action="<?= App\Core\Web::url('admin.user.delete') ?>" method="post">
                  <?= App\Core\Web::key_field() ?>
                  <input type="hidden" name="user_id" value="<?= md5($d['user_id']) ?>">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- Modal -->
      <?php $no++;
      } ?>
    </tbody>
  </table>
</div>
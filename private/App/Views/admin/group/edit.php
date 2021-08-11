<form action="<?= App\Core\Web::url('admin.group.update.' . md5($data['user_group_id'])) ?>" method="POST">
  <div class="row">
    <div class="col-md-8">
      <div class="card shadow mb-3">
        <div class="card-header bg-transparent">
          <div class="row align-items-center">
            <h1 class="fas fa-users ml-3 mb-0"></h1>
            <div class="col">
              <h6 class="text-uppercase text-muted ls-1 mb-1">Grup Pengguna</h6>
              <h5 class="h3 mb-0">Edit grup pengguna</h5>
            </div>
          </div>
        </div>
        <div class="card-body">
          <?= App\Core\Web::key_field() ?>
          <h6 class="heading-small text-muted mb-4">Informasi Grup Pengguna</h6>
          <div class="pl-lg-4">
            <div class="form-group">
              <label class="form-control-label" for="user_group_name">Nama grup pengguna<span class="text-danger">*</span></label>
              <input type="text" maxlength="50" id="user_group_name" name='user_group_name' value="<?= $data['user_group_name'] ?>" class="form-control" placeholder="Nama grup pengguna">
            </div>
            <div class="form-group">
              <label class="form-control-label" for="user_group_description">Deskripsi grup pengguna</label>
              <textarea rows="4" maxlength="150" name="user_group_description" id="user_group_description" class="form-control" placeholder="Isilah dengan singkat dan jelas (maks. 150 karakter)"><?= $data['user_group_description'] ?></textarea>
            </div>
          </div>
          <hr class="my-4">
          <h6 class="heading-small text-muted mb-4">Izin Pengguna</h6>
          <div class="pl-lg-4">
            <div class="card mb-3 multi-check">
              <div class="card-header py-2">
                <div class="row align-items-center">
                  <div class="col-6">
                    <h3 class="mb-0">Izin akses<span class="text-danger">*</span></h3>
                  </div>
                  <div class="col-6 text-right">
                    <a href="#" class="btn btn-sm btn-secondary mb-2 mb-md-0 shadow-none multi-check-none"><i class="far fa-square"></i> Batalkan semua</a>
                    <a href="#" class="btn btn-sm btn-primary shadow-none multi-check-all"><i class="far fa-check-square"></i> Pilih semua</a>
                  </div>
                </div>
              </div>
              <div class="card-body bg-secondary" style="height: 150px; overflow: auto;">
                <?php $no = 1; ?>
                <?php foreach ($data['controllers'] as $p) : ?>
                  <div class="custom-control custom-checkbox <?= count($data['controllers']) === $no ? '' : 'mb-3' ?>">
                    <input type="checkbox" class="custom-control-input" name="user_group_access[]" <?= in_array($p, $data['user_group_access']) ? 'checked' : '' ?> value="<?= $p ?>" id="user_group_access_<?= $no ?>">
                    <label class="custom-control-label" for="user_group_access_<?= $no ?>"><?= $p ?></label>
                  </div>
                  <?php $no++; ?>
                <?php endforeach; ?>
              </div>
            </div>
            <div class="card mb-3 multi-check">
              <div class="card-header py-2">
                <div class="row align-items-center">
                  <div class="col-6">
                    <h3 class="mb-0">Izin mengubah<span class="text-danger">*</span></h3>
                  </div>
                  <div class="col-6 text-right">
                    <a href="#" class="btn btn-sm btn-secondary mb-2 mb-md-0 shadow-none multi-check-none"><i class="far fa-square"></i> Batalkan semua</a>
                    <a href="#" class="btn btn-sm btn-primary shadow-none multi-check-all"><i class="far fa-check-square"></i> Pilih semua</a>
                  </div>
                </div>
              </div>
              <div class="card-body bg-secondary" style="height: 150px; overflow: auto;">
                <?php $no = 1; ?>
                <?php foreach ($data['controllers'] as $p) : ?>
                  <div class="custom-control custom-checkbox <?= count($data['controllers']) === $no ? '' : 'mb-3' ?>">
                    <input type="checkbox" class="custom-control-input" name="user_group_modify[]" <?= in_array($p, $data['user_group_modify']) ? 'checked' : '' ?> value="<?= $p ?>" id="user_group_modify_<?= $no ?>">
                    <label class="custom-control-label" for="user_group_modify_<?= $no ?>"><?= $p ?></label>
                  </div>
                  <?php $no++; ?>
                <?php endforeach; ?>
              </div>
            </div>
            <div class="card mb-0 multi-check">
              <div class="card-header py-2">
                <div class="row align-items-center">
                  <div class="col-6">
                    <h3 class="mb-0">Izin publikasi<span class="text-danger">*</span></h3>
                  </div>
                  <div class="col-6 text-right">
                    <a href="#" class="btn btn-sm btn-secondary mb-2 mb-md-0 shadow-none multi-check-none"><i class="far fa-square"></i> Batalkan semua</a>
                    <a href="#" class="btn btn-sm btn-primary shadow-none multi-check-all"><i class="far fa-check-square"></i> Pilih semua</a>
                  </div>
                </div>
              </div>
              <div class="card-body bg-secondary" style="height: 150px; overflow: auto;">
                <?php $no = 1; ?>
                <?php foreach ($data['controllers'] as $p) : ?>
                  <div class="custom-control custom-checkbox <?= count($data['controllers']) === $no ? '' : 'mb-3' ?>">
                    <input type="checkbox" class="custom-control-input" name="user_group_publish[]" <?= in_array($p, $data['user_group_publish']) ? 'checked' : '' ?> value="<?= $p ?>" id="user_group_publish_<?= $no ?>">
                    <label class="custom-control-label" for="user_group_publish_<?= $no ?>"><?= $p ?></label>
                  </div>
                  <?php $no++; ?>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow mb-3">
        <div class="card-body">
          <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="status1" name="status" value="1" <?= $data['status'] === '1' ? 'checked' : '' ?> class="custom-control-input">
            <label class="custom-control-label" for="status1">Aktifkan</label>
          </div>
          <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="status2" name="status" value="0" <?= $data['status'] === '0' ? 'checked' : '' ?> class="custom-control-input">
            <label class="custom-control-label" for="status2">Non-aktifkan</label>
          </div>
        </div>
        <div class="card-footer">
          <a href="<?= App\Core\Web::url('admin.group') ?>" class="btn btn-secondary btn-sm shadow-none"><i class="fas fa-long-arrow-alt-left"></i> Kembali</a>
          <button type='submit' class="btn btn-primary btn-sm shadow-none"><i class="fas fa-save"></i> Simpan</button>
        </div>
      </div>
    </div>
  </div>
</form>
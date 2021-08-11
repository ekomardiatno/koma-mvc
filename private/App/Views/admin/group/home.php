<div class="card shadow">
  <div class="card-header border-0">
    <div class="d-flex flex-column-sm mx--3 align-items-center-md">
      <div class="mx-3 flex-fill d-flex align-items-center">
        <h3 class="mb-0 mb-2-sm text-uppercase fw-800">Grup Pengguna</h3>
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
            <a href="<?= App\Core\Web::url('admin.group.add'); ?>" class="btn btn-sm btn-primary d-flex align-items-center shadow-none"><span class="fas fa-plus"></span><span class="d-none d-md-inline-block ml-1">Tambah Grup</span></a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <table class="table datatables align-items-center table-flush">
    <thead class="thead-light">
      <tr>
        <th width="1%" scope="col">#</th>
        <th scope="col">Nama Grup Pengguna</th>
        <th max-width="40%" scope="col">Deskripsi Grup Pengguna</th>
        <th width="1%" scope="col">Status</th>
        <th width="1%" scope="col">Alat</th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1;
      foreach ($data as $d) { ?>
        <tr>
          <td><?= $no; ?></td>
          <td><?= $d['user_group_name']; ?></td>
          <td><?= $d['user_group_description'] != '' ? $d['user_group_description'] : '-'; ?></td>
          <td>
            <label class="custom-toggle custom-toggle-sm mb-0">
              <input type="checkbox" data-id="<?= md5($d['user_group_id']) ?>" class="status-changer" <?= $d['status'] === '1' ? 'checked' : '' ?>>
              <span class="custom-toggle-slider rounded-circle" data-label-off="OFF" data-label-on="ON"></span>
            </label>
          </td>
          <td>
            <a title='Edit data' href="<?= App\Core\Web::url('admin.group.edit.' . md5($d['user_group_id'])) ?>" class="btn btn-secondary btn-sm shadow-none"><i class="fas fa-pencil-alt text-warning"></i></a>
            <button type="button" title='Hapus data' class="btn btn-secondary btn-sm shadow-none" data-toggle="modal" data-target="#modalHapus-<?= md5($d['user_group_id']) ?>"><i class="fas fa-eraser text-danger"></i></button>
          </td>
        </tr>
        <!-- Modal -->
        <div class="modal fade" id="modalHapus-<?= md5($d['user_group_id']) ?>" tabindex="-1" role="dialog" aria-labelledby="labelModalHapus-<?= md5($d['user_group_id']) ?>" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="labelModalHapus-<?= md5($d['user_group_id']) ?>">Peringatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <h3 class="m-0 font-weight-bold">Yakin ingin Menghapus data?</h3>
              </div>
              <div class="modal-footer">
                <form action="<?= App\Core\Web::url('admin.group.delete') ?>" method="post">
                  <?= App\Core\Web::key_field() ?>
                  <input type="hidden" name="user_group_id" value="<?= md5($d['user_group_id']) ?>">
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

<script>
  $('body').on('click', '.status-changer', function(e) {
    e.preventDefault()
    e.stopPropagation()
    $(this).prop('disabled', true)
    $.ajax({
        method: 'post',
        url: '<?= App\Core\Web::url('admin.group.status-changer') ?>',
        data: {
          _key: '<?= getenv('APP_KEY') ?>',
          user_group_id: $(this).attr('data-id'),
          status: $(this).is(':checked') ? '1' : '0'
        }
      })
      .then(res => {
        res = JSON.parse(res)
        if (res.status === 'OK') {
          res.data.status === '1' ? $(this).prop('checked', true) : $(this).prop('checked', false)
          flashMessage('ni ni-check-bold', '<b>Berhasil!</b> Data telah diperbarui', 'success', 'top', 'center')
        } else {
          flashMessage('ni ni-fat-remove', '<b>Gagal!</b> Ada kesalahan, perbaiki isian dan coba lagi', 'danger', 'top', 'center')
        }
        $(this).prop('disabled', false)
      })
  })
</script>
<form enctype="multipart/form-data" action="<?= App\Core\Web::url('admin.user.post') ?>" id='add-user' method="POST">
  <div class="row">
    <div class="col-md-8">
      <div class="card shadow mb-3">
        <div class="card-header bg-transparent">
          <div class="row align-items-center">
            <h1 class="fas fa-user ml-3 mb-0"></h1>
            <div class="col">
              <h6 class="text-uppercase text-muted ls-1 mb-1">Pengguna</h6>
              <h5 class="h3 mb-0">Tambah pengguna</h5>
            </div>
          </div>
        </div>
        <div class="card-body">
          <?= App\Core\Web::key_field() ?>
          <h6 class="heading-small text-muted mb-4">Informasi Pengguna</h6>
          <div class="pl-lg-4">
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="input-username">Nama pengguna<span class="text-danger">*</span></label>
                  <input type="text" id="input-username" required class="form-control" placeholder="Nama pengguna" name='user_username' value="<?= $flash_data['user_username'] ?>">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="input-email">Email address<span class="text-danger">*</span></label>
                  <input type="email" id="input-email" required class="form-control" placeholder="nama@domain.com" name='user_email' value="<?= $flash_data['user_email'] ?>">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="input-first-name">Nama depan<span class="text-danger">*</span></label>
                  <input type="text" id="input-first-name" required class="form-control" placeholder="Nama depan" name='user_first_name' value="<?= $flash_data['user_first_name'] ?>">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="input-last-name">Nama belakang<span class="text-danger">*</span></label>
                  <input type="text" id="input-last-name" required class="form-control" placeholder="Nama belakang" name="user_last_name" value="<?= $flash_data['user_last_name'] ?>">
                </div>
              </div>
              <div class="col-lg-12">
                <div class="form-group mb-0">
                  <label class="form-control-label">Jenis kelamin<span class="text-danger">*</span></label>
                  <div>
                    <div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" required id="user_gender_0" value='0' name="user_gender" class="custom-control-input" <?= $flash_data['user_gender'] === '0' ? 'checked' : '' ?>>
                      <label class="custom-control-label" for="user_gender_0">Tidak memilih</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" required id="user_gender_1" value='1' name="user_gender" class="custom-control-input" <?= $flash_data['user_gender'] === '1' ? 'checked' : '' ?>>
                      <label class="custom-control-label" for="user_gender_1">Laki-laki</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" required id="user_gender_2" value='2' name="user_gender" class="custom-control-input" <?= $flash_data['user_gender'] === '2' ? 'checked' : '' ?>>
                      <label class="custom-control-label" for="user_gender_2">Perempuan</label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <hr class="my-4">
          <h6 class="heading-small text-muted mb-4">Informasi Kontak</h6>
          <div class="pl-lg-4">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label" for="input-phone">Nomor Ponsel<span class="text-danger">*</span></label>
                  <input id="input-phone" class="form-control" required placeholder="082219299071" name='user_phone' type="text" value="<?= $flash_data['user_phone'] ?>">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label" for="input-address">Alamat</label>
                  <input id="input-address" class="form-control" placeholder="Tulis Nama Jalan, Gedung, No. Rumah/Unit, Blok, RT/RW, dll" name='user_address' type="text" value="<?= $flash_data['user_address'] ?>">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label" for="input-city">Propinsi</label>
                  <input type="text" id="input-city" class="form-control" placeholder="Propinsi" name='user_province' value="<?= $flash_data['user_province'] ?>">
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label" for="input-country">Kota/Kabupaten</label>
                  <input type="text" id="input-country" class="form-control" placeholder="Kota/Kabupaten" name='user_city' value="<?= $flash_data['user_city'] ?>">
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label" for="input-country">Kode Pos</label>
                  <input type="number" id="input-postal-code" class="form-control" placeholder="Kode Pos" name='user_postal_code' value="<?= $flash_data['user_postal_code'] ?>">
                </div>
              </div>
            </div>
          </div>
          <hr class="my-4">
          <h6 class="heading-small text-muted mb-4">Media sosial</h6>
          <div class="pl-lg-4">
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="input-instagram">Instagram</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text text-xs pr-1" id="input-instagram"><i class="fab fa-instagram mr-1"></i><span>instagram.com/</span></span>
                    </div>
                    <input type="text" class="form-control text-xs" style="padding-bottom:.750rem" placeholder="username" name='user_instagram' aria-label="input-instagram" aria-describedby="input-instagram" value="<?= $flash_data['user_instagram'] ?>">
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="input-facebook">Facebook</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text text-xs pr-1" id="input-facebook"><i class="fab fa-facebook mr-1"></i><span>fb.com/</span></span>
                    </div>
                    <input type="text" class="form-control text-xs" style="padding-bottom:.750rem" placeholder="username" name='user_facebook' aria-label="input-facebook" aria-describedby="input-facebook" value="<?= $flash_data['user_facebook'] ?>">
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="input-twitter">Twitter</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text text-xs pr-1" id="input-twitter"><i class="fab fa-twitter mr-1"></i><span>twitter.com/</span></span>
                    </div>
                    <input type="text" class="form-control text-xs" style="padding-bottom:.750rem" placeholder="username" name='user_twitter' aria-label="input-twitter" aria-describedby="input-twitter" value="<?= $flash_data['user_twitter'] ?>">
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="input-linkedin">Linkedin</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text text-xs pr-1" id="input-linkedin"><i class="fab fa-linkedin mr-1"></i><span>linkedin.com/in/</span></span>
                    </div>
                    <input type="text" class="form-control text-xs" style="padding-bottom:.750rem" placeholder="username" name='user_linkedin' aria-label="input-linkedin" aria-describedby="input-linkedin" value="<?= $flash_data['user_linkedin'] ?>">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card shadow mb-3">
        <div class="card-body">
          <div class="form-group">
            <label class="form-control-label" for="input-profile-picture">Foto pengguna<span class="text-danger">*</span></label>
            <div class="input-foto-wrapper">
              <div class="input-foto">
                <div class="preview-foto">
                </div>
              </div>
              <input type="file" id="input-profile-picture" required name="user_picture">
              <p class="mt-1 text-xs mb-0 text-right font-italic">Ukuran file maks. 1 mb (1024 kb)</p>
            </div>
          </div>
          <div class="form-group">
            <label class="form-control-label" for="input-id-number">Nomor kartu identitas<span class="text-danger">*</span></label>
            <input type="text" id="input-id-number" required class="form-control" placeholder="Nomor identitas" name='user_id_number' value="<?= $flash_data['user_id_number'] ?>">
          </div>
          <div class="form-group">
            <label class="form-control-label" for="input-id-picture">Foto kartu identitas<span class="text-danger">*</span></label>
            <div class="input-foto-wrapper">
              <div class="input-foto">
                <div class="preview-foto">
                </div>
              </div>
              <input type="file" id="input-id-picture" required name="user_id_picture">
            </div>
            <p class="mt-1 text-xs mb-0 text-right font-italic">Ukuran file maks. 1 mb (1024 kb)</p>
          </div>
        </div>
      </div>
      <div class="card shadow mb-3">
        <div class="card-body">
          <div class="form-group mb-0">
            <label class="form-control-label">Grup pengguna</label>
            <div class="d-flex flex-wrap mx--2 mb--3">
              <?php foreach ($data['user_group'] as $i => $u) : ?>
                <div class="custom-control custom-checkbox mb-3 mx-2">
                  <input type="checkbox" class="custom-control-input" name="user_groups[]" value="<?= $u['user_group_id'] ?>" id="user_groups_<?= $i ?>">
                  <label class="custom-control-label" for="user_groups_<?= $i ?>"><?= $u['user_group_name'] ?></label>
                </div>
              <?php endforeach ?>
            </div>
          </div>
        </div>
      </div>
      <div class="card shadow mb-3">
        <div class="card-header">
          <h4 class="mb-0">Kata sandi</h4>
        </div>
        <div class="card-body">
          <div class="form-group">
            <label class="form-control-label" for='user_password'>Kata sandi<span class="text-danger">*</span></label>
            <input type='password' id="user_password" required class="form-control" name='user_password' placeholder="Kata sandi" value="<?= $flash_data['user_password'] ?>">
          </div>
          <div class="form-group mb-0">
            <label class="form-control-label" for='re_user_password'>Ulangi kata sandi<span class="text-danger">*</span></label>
            <input type='password' id="re_user_password" required class="form-control" placeholder="Ulangi kata sandi" value="<?= $flash_data['user_password'] ?>">
          </div>
        </div>
      </div>
      <div class="card shadow mb-3">
        <div class="card-body">
          <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" required id="status1" name="status" value="1" required class="custom-control-input" <?= $flash_data['status'] === '1' ? 'checked' : '' ?>>
            <label class="custom-control-label" for="status1">Aktifkan</label>
          </div>
          <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" required id="status2" name="status" value="0" required class="custom-control-input" <?= $flash_data['status'] === '0' ? 'checked' : '' ?>>
            <label class="custom-control-label" for="status2">Non-aktifkan</label>
          </div>
        </div>
        <div class="card-footer">
          <a href="<?= App\Core\Web::url('admin.user') ?>" class="btn btn-secondary btn-sm shadow-none"><i class="fas fa-long-arrow-alt-left"></i> Kembali</a>
          <button type='button' class="btn btn-primary btn-sm shadow-none" data-toggle="modal" data-target="#submitmodal"><i class="fas fa-save"></i> Simpan</button>
          <!-- Modal -->
          <div class="modal fade" id="submitmodal" tabindex="-1" role="dialog" aria-labelledby="labelsubmitmodal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="labelsubmitmodal">Peringatan</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <h3 class="m-0 font-weight-bold">Apakah semua data sudah benar?</h3>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-primary">Ya, simpan</button>
                </div>
              </div>
            </div>
          </div>
          <!-- Modal -->
        </div>
      </div>
    </div>
  </div>
</form>
<script>
  let form = $('#add-user')
  let input = form.find('.form-control')
  input.on('keyup', function() {
    isReady($(this).parents('form'))
  })
  isReady(form)

  function isReady(form) {
    let filled = 0
    let required = form.find('input[required]')
    let newPass = form.find('[id=user_password]')
    let reNewPass = form.find('[id=re_user_password]')
    required.each(function() {
      this.value != '' ? filled += 1 : null
    })
    if (filled < required.length || newPass.val() !== '' && newPass.val() !== reNewPass.val()) {
      form.find('button[data-target="#submitmodal"]').prop('disabled', true)
      return false
    }
    form.find('button[data-target="#submitmodal"]').prop('disabled', false)
    return true
  }

  form.on('submit', function(e) {
    if (!isReady($(this))) {
      e.preventDefault()
    }
  })


  let timeOut
  form.find('[id=re_user_password]').on('keyup', function() {
    console.log($(this).parents('.form-group').prev('.form-group').find('input').val())
    clearTimeout(timeOut)
    $(this).parents('.form-group').find('.msg').remove()
    timeOut = setTimeout(function() {
      if ($(this).val() !== '' && $(this).val() !== $(this).parents('.form-group').prev('.form-group').find('input').val()) {
        $(this).parents('.form-group').append('<p class="msg small text-danger mb-0 mt-1 font-italic">Kata sandi tidak cocok</p>')
      }
    }.bind(this), 500)
  })

  form.find('button[type=submit]').on('click', function() {
    if (!isReady($(this))) {
      e.preventDefault()
      flashMessage('ni ni-fat-remove', 'Gagal! Periksa kembali form', '', '', '')
    }
  })
</script>
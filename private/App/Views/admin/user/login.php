<div class="row justify-content-center">
  <div class="col-lg-5 col-md-7">
    <div class="card shadow border-0">
      <div class="card-body px-lg-5 py-lg-5">
        <div class="text-center text-muted mb-4">
          <h4 class="fw-800 mt-0 mb-1 text-uppercase">Selamat datang</h4>
          <small>Masukan username dan password untuk masuk</small>
        </div>
        <form action="<?= App\Core\Web::url('admin.user.login'); ?>" method="POST" role="form">
          <?= App\Core\Web::key_field() ?>
          <div class="form-group mb-3">
            <div class="input-group input-group-alternative">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="ni ni-single-02"></i></span>
              </div>
              <input class="form-control" required placeholder="Username" name="user_username" type="text">
            </div>
          </div>
          <div class="form-group">
            <div class="input-group input-group-alternative">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
              </div>
              <input class="form-control" required placeholder="Password" name="user_password" type="password">
            </div>
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-primary my-4">Masuk</button>
          </div>
        </form>
      </div>
    </div>
    <!-- <div class="row mt-3">
      <div class="col-12 text-right">
        <a href="<?= App\Core\Web::url('admin.register'); ?>" class="text-light"><small>Buat akun baru</small></a>
      </div>
    </div> -->
  </div>
</div>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="shortcut icon" href="<?= App\Core\Web::assets('brand/favicon.png', 'images'); ?>" type="image/x-icon">

  <title><?= $title != '' ? $title . ' | ' . getenv('APP_NAME') : getenv('APP_NAME') ?></title>
  <meta content="<?= $desc; ?>" name="description" />
  <base href="<?= App\Core\Web::url('admin') ?>">

  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
  <link rel="stylesheet" href="<?= App\Core\Web::assets('nucleo.css', 'css') ?>">
  <link rel="stylesheet" href="<?= App\Core\Web::assets('bootstrap-datepicker.min.css', 'css') ?>">
  <link rel="stylesheet" href="<?= App\Core\Web::assets('Chart.min.css', 'css') ?>">
  <link rel="stylesheet" href="<?= App\Core\Web::assets('nouislider.min.css', 'css') ?>">
  <link rel="stylesheet" href="<?= App\Core\Web::assets('animate.min.css', 'css') ?>">
  <link rel="stylesheet" href="<?= App\Core\Web::assets('dataTables.bootstrap4.min.css', 'css') ?>">
  <link rel="stylesheet" href="<?= App\Core\Web::assets('responsive.bootstrap4.min.css', 'css') ?>">
  <link rel="stylesheet" href="<?= App\Core\Web::assets('argon.min.css', 'css') ?>">
  <link rel="stylesheet" href="<?= App\Core\Web::assets('all.min.css', 'css') ?>">

  <script src="<?= App\Core\Web::assets('jquery.min.js', 'js') ?>"></script>
  <script src="<?= App\Core\Web::assets('bootstrap.bundle.min.js', 'js') ?>"></script>
  <script src="<?= App\Core\Web::assets('nouislider.min.js', 'js') ?>"></script>
  <script src="<?= App\Core\Web::assets('bootstrap-datepicker.min.js', 'js') ?>"></script>
  <script src="<?= App\Core\Web::assets('bootstrap-notify.min.js', 'js') ?>"></script>
  <script src="<?= App\Core\Web::assets('jquery.dataTables.min.js', 'js') ?>"></script>
  <script src="<?= App\Core\Web::assets('dataTables.bootstrap4.min.js', 'js') ?>"></script>
  <script src="<?= App\Core\Web::assets('dataTables.responsive.min.js', 'js') ?>"></script>
  <script src="<?= App\Core\Web::assets('responsive.bootstrap4.min.js', 'js') ?>"></script>
  <script src="<?= App\Core\Web::assets('flash-message.min.js', 'js') ?>"></script>
  <script src="<?= App\Core\Web::assets('input-foto.js', 'js') ?>"></script>
  <script src="<?= App\Core\Web::assets('argon.min.js', 'js') ?>"></script>

<body>
  <nav class="navbar navbar-vertical fixed-left fixed-top navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
      <!-- Toggler -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- Brand -->
      <a class="navbar-brand" href="<?= App\Core\Web::url('admin'); ?>">
        <img src="<?= App\Core\Web::assets('brand/blue.png', 'images'); ?>" class="navbar-brand-img" alt="...">
      </a>
      <!-- User -->
      <ul class="nav align-items-center d-md-none">
        <li class="nav-item dropdown">
          <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="media align-items-center">
              <span class="avatar avatar-sm rounded-circle">
                <img alt="Image placeholder" src="<?= App\Core\Web::assets('user-thumb.png', 'images'); ?>">
              </span>
            </div>
          </a>
          <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
            <div class=" dropdown-header noti-title">
              <h6 class="text-overflow m-0">Hai, <?= trim(App\Helpers\Auth::user('user_first_name')) ?>!</h6>
            </div>
            <a href="<?= App\Core\Web::url('admin.profil.edit'); ?>" class="dropdown-item">
              <i class="ni ni-circle-08"></i>
              <span>Ubah Profil</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="<?= App\Core\Web::url('admin.user.logout'); ?>" class="dropdown-item">
              <i class="ni ni-user-run"></i>
              <span>Logout</span>
            </a>
          </div>
        </li>
      </ul>
      <!-- Collapse -->
      <div class="collapse navbar-collapse" id="sidenav-collapse-main">
        <!-- Collapse header -->
        <div class="navbar-collapse-header d-md-none">
          <div class="row">
            <div class="col-6 collapse-brand">
              <a href="<?= App\Core\Web::url('admin'); ?>">
                <img src="<?= App\Core\Web::assets('brand/blue.png', 'images'); ?>">
              </a>
            </div>
            <div class="col-6 collapse-close">
              <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                <span></span>
                <span></span>
              </button>
            </div>
          </div>
        </div>
        <!-- Navigation -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="<?= App\Core\Web::url('admin'); ?>">
              <i class="fas fa-home"></i> Beranda
            </a>
          </li>
          <li class="nav-item  nav-item-group">
            <a class="nav-link" href="#">
              <i class="fas fa-users"></i> Pengguna
            </a>
            <ul>
              <li>
                <a href="<?= App\Core\Web::url('admin.user') ?>" class="">Semua Pengguna</a>
              </li>
              <li>
                <a href="<?= App\Core\Web::url('admin.group') ?>" class="">Grup Pengguna</a>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="main-content">
    <!-- Top navbar -->
    <nav class="navbar navbar-expand navbar-dark bg-primary px-0" id="navbar-main">
      <div class="container-fluid">
        <!-- User -->
        <ul class="navbar-nav align-items-center d-none d-md-flex ml-auto mr--3">
          <li class="nav-item dropdown">
            <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <div class="media align-items-center">
                <span class="avatar avatar-sm rounded-circle">
                  <img alt="Image placeholder" src="<?= App\Helpers\Mod::getImageThumb(App\Helpers\Auth::user('user_picture'), 'sm') ?: App\Core\Web::assets('user-thumb.png', 'images'); ?>">
                </span>
                <div class="media-body ml-2 d-none d-md-block">
                  <span class="mb-0 text-sm  font-weight-bold"><?= trim(App\Helpers\Auth::user('user_first_name') . ' ' . App\Helpers\Auth::user('user_last_name')); ?></span>
                </div>
              </div>
            </a>
            <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
              <div class="dropdown-header notif-title">
                <h6 class="text-overflow m-0">Hai, <?= trim(App\Helpers\Auth::user('user_first_name')) ?></h6>
              </div>
              <a href="<?= App\Core\Web::url('admin.profil.edit'); ?>" class="dropdown-item">
                <i class="ni ni-circle-08"></i>
                <span>Ubah Profil</span>
              </a>
              <div class="dropdown-divider"></div>
              <a href="<?= App\Core\Web::url('admin.user.logout'); ?>" class="dropdown-item">
                <i class="ni ni-user-run"></i>
                <span>Logout</span>
              </a>
            </div>
          </li>
        </ul>
      </div>
    </nav>

    <!-- <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    </div> -->

    <div class="header bg-primary pb-8 pt-3">
    </div>
    <div class="container-fluid mt--8">
      <div class="row align-items-center">
        <?php
        if ($breadcrumb !== null) :
        ?>
          <div class="col mb-3">
            <?php
            if ($title !== '') :
            ?>
              <h6 class="h2 text-white d-inline-block mb-2 mb-lg-0 breadcrumb-title mr-md-3"><?= $title ?></h6>
            <?php
            endif
            ?>
            <nav aria-label="breadcrumb" class="d-block d-lg-inline-block">
              <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                <li class="breadcrumb-item"><a href="<?= App\Core\Web::url('admin') ?>"><i class="fas fa-home"></i></a></li>
                <?php
                $breadcrumbLength = count($breadcrumb);
                $number = 1;
                foreach ($breadcrumb as $b) :
                ?>
                  <li class="breadcrumb-item <?= $breadcrumbLength === $number ? 'active' : '' ?>" <?= $breadcrumbLength === $number ? 'aria-current="page"' : '' ?>>
                    <?= $breadcrumbLength !== $number ? '<a href="' . App\Core\Web::url($b[0]) . '">' . $b[1] . '</a>' : $b[1] ?>
                  </li>
                <?php
                  $number++;
                endforeach
                ?>
              </ol>
            </nav>
          </div>
        <?php
        endif
        ?>
      </div>
      <div class="row">
        <div class="col-md-12">

          <!-- Content -->
          <?php require_once $content; ?>
          <!-- End Content -->

        </div>
      </div>
    </div>

    <footer class="footer">
      <div class="row align-items-center justify-content-lg-between">
        <div class="col-lg">
          <div class="copyright text-center text-lg-left mb-1 mb-lg-0">
            &copy; 2019 <a href="<?= App\Core\Web::url() ?>" class="font-weight-bold ml-1" target="_blank"><?= getenv('APP_NAME') ?></a>
          </div>
        </div>
        <div class="col-lg">
          <div class="copyright text-center text-lg-right">
            Powered by <span class="font-weight-bold">KOMA MVC</span>
          </div>
        </div>
      </div>
    </footer>
  </div>

  <?php
  $msg = App\Helpers\Flasher::flash();
  if ($msg != null) {
  ?>
    <script>
      $(function() {
        flashMessage("<?= $msg['icon'] ?>", "<?= $msg['msg'] ?>", "<?= $msg['type'] ?>", "<?= $msg['y'] ?>", "<?= $msg['x'] ?>")
      })
    </script>
  <?php } ?>


  <script>
    let baseHref = $('base').attr('href')
    let windowUrl = window.location.href
    $('#sidenav-collapse-main .navbar-nav .nav-item').each(function() {
      let navLink = $(this).children('.nav-link')
      let aHref = navLink.attr('href')
      if (baseHref !== aHref) {
        aHref = aHref.replace(baseHref, '')
        if (windowUrl.indexOf(aHref) === baseHref.length) {
          navLink.addClass('active')
        }
      } else if (aHref !== '#' && windowUrl === aHref) {
        navLink.addClass('active')
      }
    })

    $('#sidenav-collapse-main .navbar-nav .nav-item-group ul a').each(function() {
      let aHref = $(this).attr('href')
      if (baseHref !== aHref) {
        aHref = aHref.replace(baseHref, '')
        if (windowUrl.indexOf(aHref) === baseHref.length) {
          $(this).addClass('selected')
          $(this).parents('.nav-item-group').addClass('showed')
          $(this).parents('.nav-item-group').find('.nav-link').addClass('active')
        }
      } else if (aHref !== '#' && aHref === windowUrl) {
        $(this).addClass('selected')
        $(this).parents('.nav-item-group').addClass('showed')
        $(this).parents('.nav-item-group').find('.nav-link').addClass('active')
      }
    })

    $('#sidenav-collapse-main .navbar-nav .nav-item-group .nav-link').on('click', function(e) {
      e.preventDefault()
      if ($(this).parents('.nav-item-group').attr('class').indexOf('showed') <= -1) {
        $(this).parents('.nav-item-group').find('ul').slideDown(300, function() {
          $(this).parents('.nav-item-group').addClass('showed')
        })
      } else {
        $(this).parents('.nav-item-group').find('ul').slideUp(300, function() {
          $(this).parents('.nav-item-group').removeClass('showed')
        })
      }
    })
  </script>

  <script>
    $('.datatables').each(function() {
      $.fn.DataTable.ext.pager.numbers_length = 4;
      let datatables = $(this).DataTable({
        responsive: true,
        pageLength: 10,
        lengthChange: false,
        // searching: false,
        language: {
          emptyTable: "Data tidak tersedia",
          info: "_START_ - _END_ dari _TOTAL_ data",
          infoEmpty: "",
          search: "Cari ",
          infoFiltered: "",
          zeroRecords: "Kata kunci tidak ditemukan",
          paginate: {
            first: '<span class="fas fa-angle-double-left"></span>',
            last: '<span class="fas fa-angle-double-right"></span>',
            previous: '<span class="fas fa-angle-left"></span>',
            next: '<span class="fas fa-angle-right"></span>'
          }
        }
      })
      $(this).parents('.card').find('#search-datatables').on("keyup", function() {
        datatables.search(this.value).draw()
      })
    })
  </script>

  <script>
    $('.datepicker').each(function() {
      let datepicker = $(this).datepicker({
        disableTouchKeyboard: true,
        autoclose: false,
        format: 'yyyy-mm-dd'
      })
      if ($(this).val() === '') {
        datepicker.datepicker("setDate", new Date())
      }
    })
  </script>

  <script>
    $('.multi-check').each(function() {
      let $this = $(this)
      let dataSelect = $this.attr('data-select')
      $this.find('.multi-check-all').on('click', function(e) {
        e.preventDefault()
        $this.find('input[type=checkbox]').prop('checked', true)
      })
      $this.find('.multi-check-none').on('click', function(e) {
        e.preventDefault()
        $this.find('input[type=checkbox]').prop('checked', false)
      })
    })
  </script>

</body>

</html>
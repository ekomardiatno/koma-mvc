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
  <div class="main-content bg-light">
    <div class="container pt-5">
      <div class="row justify-content-center align-items-center">
        <div class="col-md-6">

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
        flashMessage('<?= $msg['icon']; ?>', '<?= $msg['msg']; ?>', '<?= $msg['type']; ?>', '<?= $msg['y']; ?>', '<?= $msg['x']; ?>')
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
        if(windowUrl.indexOf(aHref) === baseHref.length) {
          navLink.addClass('active')
        }
      } else if (aHref !== '#' && windowUrl === aHref) {
        navLink.addClass('active')
      }
    })

    $('#sidenav-collapse-main .navbar-nav .nav-item-group ul a').each(function () {
      let aHref = $(this).attr('href')
      if (baseHref !== aHref) {
        aHref = aHref.replace(baseHref, '')
        if(windowUrl.indexOf(aHref) === baseHref.length) {
          $(this).addClass('selected')
          $(this).parents('.nav-item-group').addClass('showed')
          $(this).parents('.nav-item-group').find('.nav-link').addClass('active')
        }
      } else if(aHref !== '#' && aHref === windowUrl) {
        $(this).addClass('selected')
        $(this).parents('.nav-item-group').addClass('showed')
        $(this).parents('.nav-item-group').find('.nav-link').addClass('active')
      }
    })

    $('#sidenav-collapse-main .navbar-nav .nav-item-group .nav-link').on('click', function (e) {
      e.preventDefault()
      if($(this).parents('.nav-item-group').attr('class').indexOf('showed') <= -1) {
        $(this).parents('.nav-item-group').find('ul').slideDown(300, function () {
          $(this).parents('.nav-item-group').addClass('showed')
        })
      } else {
        $(this).parents('.nav-item-group').find('ul').slideUp(300, function () {
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
    $('.multi-check').each(function () {
      let $this = $(this)
      let dataSelect = $this.attr('data-select')
      $this.find('.multi-check-all').on('click', function (e) {
        e.preventDefault()
        $this.find('input[type=checkbox]').prop('checked', true)
      })
      $this.find('.multi-check-none').on('click', function (e) {
        e.preventDefault()
        $this.find('input[type=checkbox]').prop('checked', false)
      })
    })
  </script>

</body>

</html>
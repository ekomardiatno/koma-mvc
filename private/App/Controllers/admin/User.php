<?php

use App\Libraries\PermissionController;
use App\Helpers\Flasher;
use App\Helpers\Auth;
use App\Helpers\Mod;

class User extends PermissionController
{

  public function index()
  {
    $this->_web->title('Pengguna');
    $this->_web->breadcrumb([
      [
        'admin.user', 'Semua Pengguna'
      ]
    ]);

    $get_user = $this->model('User')->get_with_group(null, 'RESUlT_ARRAY');
    if (!$get_user['status']) return printf($get_user['error_msg']);
    $this->_web->view('admin.user.home', $get_user['data']);
  }

  public function add()
  {

    $this->_web->title('Tambah Pengguna');
    $this->_web->breadcrumb([
      [
        'admin.user', 'Semua Pengguna'
      ],
      [
        'admin.user.add', 'Tambah Pengguna'
      ]
    ]);
    $get_user_group = $this->model('UserGroup')->get_active(null, 'user_group_id,user_group_name');
    if (!$get_user_group['status']) return printf($get_user_group['error_msg']);
    $data['user_group'] = $get_user_group['data'];
    $this->_web->view('admin.user.add', $data);
  }

  public function post()
  {
    $primary_id = $this->making_primary_id('u', 'core_user', 'user_id');
    $post = $this->request()->post;
    $post['user_groups'] = serialize($post['user_groups']);
    $raw_password = $post['user_password'];
    $files = $this->request()->files;
    $post = array_merge($post, $primary_id);
    $path_upload = 'uploads/images/user/' . $primary_id['user_id'] . '/';
    $uploading_image = $this->upload_images($files, $path_upload);
    if (isset($uploading_image['uploaded']['user_picture']) && isset($uploading_image['uploaded']['user_id_picture'])) {
      $post = array_merge($post, [
        'user_picture' => $uploading_image['uploaded']['user_picture']['file'],
        'user_id_picture' => $uploading_image['uploaded']['user_id_picture']['file'],
      ]);
      $post['user_password'] = Mod::hash($post['user_password']);
      $save = $this->model('User')->save($post);
      if ($save['status']) {
        Flasher::setFlash('<b>Berhasil!</b> Data telah ditambahkan', 'success', 'ni ni-check-bold');
        return $this->redirect('admin.user');
      } else {
        Flasher::setFlash('<b>Failed!</b> ' . $save['error_msg'], 'danger', 'ni ni-fat-remove');
      }
    } else if ($uploading_image['target']['user_picture']['status'] === 'SIZE_NOT_ALLOWED' || $uploading_image['target']['user_id_picture']['status'] === 'SIZE_NOT_ALLOWED') {
      Flasher::setFlash('<b>Gagal!</b> Beberapa gambar memiliki ukuran terlalu besar', 'danger', 'ni ni-fat-remove');
    } else if ($uploading_image['target']['user_picture']['status'] === 'ERROR_FILE' || $uploading_image['target']['user_id_picture']['status'] === 'ERROR_FILE') {
      Flasher::setFlash('<b>Gagal!</b> Beberapa gambar tidak dapat diupload', 'danger', 'ni ni-fat-remove');
    } else if ($uploading_image['target']['user_picture']['status'] === 'NOT_ACCEPTED_TYPE' || $uploading_image['target']['user_id_picture']['status'] === 'NOT_ACCEPTED_TYPE') {
      Flasher::setFlash('<b>Gagal!</b> Beberapa tipe gambar tidak diterima', 'danger', 'ni ni-fat-remove');
    } else {
      Flasher::setFlash('<b>Gagal!</b> Ada kesalahan, perbaiki isian dan coba lagi', 'danger', 'ni ni-fat-remove');
    }
    if ($uploading_image['uploaded']) {
      foreach ($uploading_image['uploaded'] as $uploaded) {
        $this->delete_image_uploaded([$uploaded['file']]);
      }
    }
    $post['user_password'] = $raw_password;
    Flasher::setData($post);
    $this->redirect('admin.user.add');
  }

  public function edit($id)
  {
    $get_user = $this->model('User')->get($id, null, 'ROW_ARRAY');

    if (!$get_user['status']) return printf($get_user['error_msg']);
    $data = $get_user['data'];
    $data['user_groups'] = unserialize($data['user_groups']);
    $get_user_group = $this->model('UserGroup')->get_active(null, 'user_group_id,user_group_name');
    if (!$get_user_group['status']) return printf($get_user_group['error_msg']);
    $data['user_group'] = $get_user_group['data'];
    $this->_web->title('Edit pengguna');
    $this->_web->breadcrumb([
      [
        'admin.user', 'Semua Pengguna'
      ],
      [
        'admin.user.edit.' . $data['user_id'], 'Edit Pengguna'
      ]
    ]);
    $this->_web->view('admin.user.edit', $data);
  }

  public function update($id)
  {
    $post = $this->request()->post;
    $files = $this->request()->files;
    if ($post['user_password'] === '') unset($post['user_password']);
    $path_upload = 'uploads/images/user/' . $id . '/';
    $uploading = $this->upload_images($files, $path_upload);
    foreach ($uploading['uploaded'] as $key => $uploaded) {
      $post[$key] = $uploaded['file'];
    }

    $fields = [];
    $pictures = null;
    if (isset($post['user_picture'])) $fields[] = 'user_picture';
    if (isset($post['user_id_picture'])) $fields[] = 'user_id_picture';
    if (count($fields) > 0) {
      $get_pictures = $this->model('User')->get($id, $fields, 'ROW_ARRAY');
      if (!$get_pictures['status']) return printf($get_pictures['error_msg']);
      $pictures = $get_pictures['data'];
    }
    $post['user_groups'] = serialize($post['user_groups']);
    $save = $this->model('User')->save($post, $id);
    if ($save['status']) {
      if ($pictures !== null) {
        $this->delete_image_uploaded($pictures);
      }
      if (md5(Auth::user('user_id')) === $id) {
        foreach ($_SESSION['auth'] as $key => $value) {
          if (isset($post[$key])) {
            $_SESSION['auth'][$key] = $key === 'user_groups' ? unserialize($post[$key]) : $post[$key];
          }
        }
      }
      Flasher::setFlash('<b>Berhasil!</b> Data telah diperbarui', 'success', 'ni ni-check-bold');
    } else {
      foreach ($uploading['uploaded'] as $key => $uploaded) {
        $post[$key] = $uploaded['file'];
      }
      Flasher::setFlash('<b>Failed!</b> ' . $save['error_msg'], 'danger', 'ni ni-fat-remove');
    }

    $this->redirect('admin.user.edit.' . $id);
  }

  public function delete()
  {
    $post = $this->request()->post;
    $get_pictures = $this->model('User')->get($post['user_id'], 'user_picture,user_id_picture', 'ROW_ARRAY');
    if (!$get_pictures['status']) return printf($get_pictures['error_msg']);
    $pictures = $get_pictures['data'];
    $delete = $this->model('User')->delete($post['user_id']);
    if ($delete['status']) {
      $this->delete_image_uploaded($pictures);
      Flasher::setFlash('<b>Berhasil!</b> Data terhapus', 'success', 'ni ni-check-bold');
    } else {
      Flasher::setFlash('<b>Failed!</b> ' . $delete['error_msg'], 'danger', 'ni ni-fat-remove');
    }
    if (Auth::user('user_id') !== $post['user_id']) {
      $this->redirect('admin.user');
    } else {
      $this->logout();
    }
  }

  public function login()
  {

    $post = $this->request()->post;
    if (!isset($post['user_username'])) {
      $this->_web->layout('login');
      $this->_web->view('admin.user.login');
    } else {
      $user = $this->model('User');
      $get_user = $user->get_with_group($post['user_username']);
      if (!$get_user['status']) return printf($get_user['error_msg']);
      $data = $get_user['data'];
      if (!$data) {
        Flasher::setFlash('Pengguna tidak ditemukan', 'danger', 'ni ni-fat-remove');
        $this->redirect('admin.user.login');
      } else if ($data['status'] !== '1') {
        Flasher::setFlash('Pengguna di-nonaktifkan', 'danger', 'ni ni-fat-remove');
        $this->redirect('admin.user.login');
      } else {
        if (password_verify($post['user_password'], $data['user_password'])) {
          unset($data['status']);
          unset($data['user_password']);
          extract($data);
          $_SESSION['auth']  = $data;
          $_SESSION['auth']['has_logged_in']  = true;

          Flasher::setFlash('<b>Login berhasil</b>. Selamat datang di Halaman Admin', 'success', 'ni ni-check-bold');
          $url = Auth::getUrl();
          if ($url != null) {
            $this->redirect($url);
          } else {
            $this->redirect('admin');
          }
        } else {
          Flasher::setFlash('Kombinasi username dan password tidak tepat', 'danger', 'ni ni-fat-remove');
          $this->redirect('admin.user.login');
        }
      }
    }
  }

  public function logout()
  {
    if (isset($_SESSION['auth'])) {

      unset($_SESSION['auth']);

      Flasher::setFlash('Anda sudah keluar.', 'success', 'ni ni-check-bold');
    }

    $this->redirect('admin.user.login');
  }
}

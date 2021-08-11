<?php

namespace App\Controllers;

use App\Libraries\PermissionController;
use App\Helpers\Flasher;

class Group extends PermissionController
{

  public function index()
  {
    $this->_web->title('Group Pengguna');
    $this->_web->breadcrumb([
      [
        'admin.group', 'Group Pengguna'
      ]
    ]);

    $get_user_group = $this->model('UserGroup')->get();
    if(!$get_user_group['status']) return printf($get_user_group['error_msg']);
    $this->_web->view('admin.group.home', $get_user_group['data']);
  }

  public function add()
  {
    $this->_web->title('Tambah Group Pengguna');
    $this->_web->breadcrumb([
      [
        'admin.group', 'Group Pengguna'
      ],
      [
        'admin.group.add', 'Tambah Group Pengguna'
      ]
    ]);

    $data['controllers'] = $this->get_controllers();

    $this->_web->view('admin.group.add', $data);
  }

  public function post()
  {
    $primary_id = $this->making_primary_id('g', 'core_user_group', 'user_group_id');
    if(!$primary_id) {
      Flasher::setFlash('<b>Failed!</b> Couldn\'t make the primary id', 'danger', 'ni ni-fat-remove');
    } else {
      $post = $this->request()->post;
      $post = array_merge($post, $primary_id);
      $post['user_group_access'] = isset($post['user_group_access']) ? serialize($post['user_group_access']) : serialize([]);
      $post['user_group_modify'] = isset($post['user_group_modify']) ? serialize($post['user_group_modify']) : serialize([]);
      $post['user_group_publish'] = isset($post['user_group_publish']) ? serialize($post['user_group_publish']) : serialize([]);
      $save = $this->model('UserGroup')->save($post);
      if ($save['status']) {
        Flasher::setFlash('<b>Berhasil!</b> Data tersimpan', 'success', 'ni ni-check-bold');
      } else {
        Flasher::setFlash('<b>Failed!</b> ' . $save['error_msg'], 'danger', 'ni ni-fat-remove');
      }
    }
    $this->redirect('admin.group');
  }

  public function edit($id)
  {


    $get_user_group = $this->model('UserGroup')->get($id, null, 'ROW_ARRAY');
    if(!$get_user_group['status']) return printf($get_user_group['error_msg']);
    $data_user_group = $get_user_group['data'];
    $this->_web->title('Edit Group Pengguna');
    $this->_web->breadcrumb([
      [
        'admin.group', 'Group Pengguna'
      ],
      [
        'admin.group.edit', 'Edit ' . $data_user_group['user_group_name']
      ]
    ]);
    $data_user_group['user_group_access'] = $data_user_group['user_group_access'] ? unserialize($data_user_group['user_group_access']) : [];
    $data_user_group['user_group_modify'] = $data_user_group['user_group_modify'] ? unserialize($data_user_group['user_group_modify']) : [];
    $data_user_group['user_group_publish'] = $data_user_group['user_group_publish'] ? unserialize($data_user_group['user_group_publish']) : [];
    $data_user_group['controllers'] = $this->get_controllers();
    $this->_web->view('admin.group.edit', $data_user_group);
  }

  public function update($id)
  {

    $post = $this->request()->post;
    $post['user_group_access'] = isset($post['user_group_access']) ? serialize($post['user_group_access']) : serialize([]);
    $post['user_group_modify'] = isset($post['user_group_modify']) ? serialize($post['user_group_modify']) : serialize([]);
    $post['user_group_publish'] = isset($post['user_group_publish']) ? serialize($post['user_group_publish']) : serialize([]);
    $save = $this->model('UserGroup')->save($post, $id);
    if ($save['status']) {
      Flasher::setFlash('<b>Berhasil!</b> Data telah diperbarui', 'success', 'ni ni-check-bold');
    } else {
      Flasher::setFlash('<b>Failed!</b> ' . $save['error_msg'], 'danger', 'ni ni-fat-remove');
    }
    $this->redirect('admin.group.edit.' . $id);
  }

  private function get_controllers()
  {
    $ignore = [
      'Home',
      'admin/Home',
      'admin/Profil'
    ];
    $path = [__DIR__ . '/../../Controllers/*'];
    $files = [];
    while (count($path) != 0) {
      $next = array_shift($path);

      foreach (glob($next) as $file) {
        if (is_dir($file)) {
          $path[] = $file . '/*';
        }

        if (is_file($file)) {
          $files[] = $file;
        }
      }
    }
    sort($files);
    $controllers = [];

    foreach ($files as $file) {
      $controller_file = substr($file, strlen(__DIR__ . '/../../Controllers/'));
      $controller_file = substr($controller_file, 0, strrpos($controller_file, '.'));
      if (!in_array($controller_file, $ignore)) {
        $controllers[] = $controller_file;
      }
    }
    return $controllers;
  }

  public function status_changer()
  {
    $this->is_ajax();
    $post = $this->request()->post;
    $id = $post['user_group_id'];
    unset($post['user_group_id']);
    $save = $this->model('UserGroup')->save($post, $id);
    if ($save['status']) {
      echo json_encode([
        'status' => 'OK',
        'data' => [
          'status' => $post['status']
        ]
      ]);
    } else {
      echo json_encode([
        'status' => 'NOT_OK',
        'msg' => $save['error_msg']
      ]);
    }
  }

  public function delete()
  {
    $post = $this->request()->post;
    $delete = $this->model('UserGroup')->delete($post['user_group_id']);
    if ($delete['status']) {
      Flasher::setFlash('<b>Berhasil!</b> Data terhapus', 'success', 'ni ni-check-bold');
    } else {
      Flasher::setFlash('<b>Failed!</b> ' . $delete['error_msg'], 'danger', 'ni ni-fat-remove');
    }
    $this->redirect('admin.group');
  }
}

<?php
use App\Libraries\AuthController;
use App\Helpers\Auth;

class Profil extends AuthController
{
  
  public function __construct()
  {
    parent::__construct();
  }
  public function edit()
  {

    $user_username = Auth::user('user_username');
    $params = [
      [
        'column' => 'user_username',
        'value' => $user_username
      ]
    ];
    $get_user = $this->model('User')->get_by($params, null, 'ROW_ARRAY');
    if(!$get_user['status']) {
      printf($get_user['error_msg']); exit;
    }
    $data = $get_user['data'];
    
    $this->_web->title('Ubah Profil');
    $this->_web->breadcrumb([
      ['admin.profil.edit', 'Ubah profil']
    ]);
    $this->_web->view('admin.profil.edit', $data);
  }

}

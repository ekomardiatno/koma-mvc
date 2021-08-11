<?php

namespace App\Libraries;

use App\Wrapper\Controller;
use App\Helpers\Auth;
use App\Core\Web;
use App\Wrapper\Database;

class AuthController extends Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->_web->layout('dashboard');
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    if (!Auth::user('has_logged_in') && $url !== Web::url('admin.user.login')) {
      $url = str_replace(getenv('APP_URL'), '', $url);
      $url = str_replace('/', '.', $url);
      Auth::setUrl($url);
      $this->redirect('admin.user.login');
    } else if ($url === Web::url('admin.user.login') && Auth::user('has_logged_in')) {
      $this->redirect('admin');
    }
  }
  public function making_primary_id($append = '', $table_name, $primary_key)
  {
    $_db = Database::getInstance();
    $sql = 'SELECT ' . $primary_key . ' FROM ' . $table_name .' ORDER BY ' . $primary_key . ' DESC LIMIT 1';
    $lastest = $_db->query($sql, 'ROW_ARRAY');
    if(!$lastest['status']) {
      $data = false;
    } else {
      $lastest = $lastest['data'];
      $data[$primary_key] = $append . str_pad(intval(preg_replace("/[^0-9]/","",$lastest[$primary_key])) + 1, (10 - strlen($append)), '0', STR_PAD_LEFT);
    }
    return $data;
  }
}

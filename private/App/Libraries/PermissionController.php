<?php
namespace App\Libraries;
use App\Libraries\AuthController;
use App\Helpers\Auth;

class PermissionController extends AuthController
{

  public function __construct()
  {
    parent::__construct();
    if(Auth::user('user_groups')) {
      $user_m = $this->model('UserGroup');
      $user_groups = $user_m->group_user_loggedin();
      extract($user_groups);
      $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
      $class_name = get_class($this);
      $reflector = new \ReflectionClass($class_name);
      $full_path_controller_file = $reflector->getFileName();
      $controller = substr($full_path_controller_file, strlen(realpath(__DIR__ . '/../Controllers/')) + 1);
      $controller = substr($controller, 0, strrpos($controller, '.'));
      $controller = str_replace('\\', '/', $controller);
      $cut_url = str_replace($_ENV['APP_URL'] . strtolower($controller), '', $url);
      $cut_url = substr($cut_url, 1);
      $method = explode('/', $cut_url)[0];
      if (($method === 'edit' || $method === 'update' || $method === 'delete') && method_exists(explode('/', $controller)[count(explode('/', $controller)) - 1], $method) || method_exists(explode('/', $controller)[count(explode('/', $controller)) - 1], 'MODIFY_' . $method)) {
        if (!in_array($controller, $user_group_modify)) {
          $this->_web->view('error.403'); exit;
        }
      } else if (($method === 'post' || $method === 'add') && method_exists(explode('/', $controller)[count(explode('/', $controller)) - 1], $method) || method_exists(explode('/', $controller)[count(explode('/', $controller)) - 1], 'PUBLISH_' . $method)) {
        if (!in_array($controller, $user_group_publish)) {
          $this->_web->view('error.403'); exit;
        }
      } else if (($method === 'index' && method_exists(explode('/', $controller)[count(explode('/', $controller)) - 1], $method)) || !method_exists(explode('/', $controller)[count(explode('/', $controller)) - 1], $method) || method_exists(explode('/', $controller)[count(explode('/', $controller)) - 1], 'ACCESS_' . $method)) {
        if (!in_array($controller, $user_group_access)) {
          $this->_web->view('error.403');
          die;
        };
      }
    }
  }
  
}

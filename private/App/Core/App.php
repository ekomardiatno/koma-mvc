<?php

/**
 * Created by Eko Mardiatno.
 * Copyright 2018 KOMA MVC. All Right Reserved.
 * Instagram @komafx
 * Licensed under MIT (https://github.com/ekomardiatno/koma-mvc/blob/master/LICENSE)
 */

namespace App\Core;

use App\Core\Aes;

class App extends Aes
{
  public $license_status = 'invalid';
  public static $license_info = [];
  private $controller = 'Home';
  private $method = 'index';
  private $params = [];
  private $controller_dir = __DIR__ . '/../Controllers/';
  private $error_dir = __DIR__ . '/../Views/error/';
  private $layout_dir = __DIR__ . '/../Views/layout/';
  private $chiper_method = 'aes-256-cbc';
  public function __construct()
  {
    $iv = $this->iv();
    $chipertext = $this->chipertext();
    $hash = $this->hash();
    $plaintext = openssl_decrypt(base64_decode($chipertext), $this->chiper_method, $hash, 0, $iv);
    $plaintext = hex2bin($plaintext);
    $app = explode('//', $plaintext);
    self::$license_info = $app;
    if (count($app) > 1) {
      $now = date_create(date('Y-m-d'));
      $expired = substr(end($app), 0, 4) . '-' . substr(end($app), 4, 2) . '-' . substr(end($app), 6, 2);
      $expired = date_create(date($expired));
      $diff = date_diff($now, $expired);
      $diff = intval($diff->format("%R%a"));
      if ($diff < 0) {
        $this->license_status = 'expired';
      } else if($diff >= 0) {
        $this->license_status = 'valid';
      } else {
        array_pop($app);
        foreach ($app as $i => $a) {
          switch ($i) {
            case 0:
              $i = $_SERVER['HTTP_HOST'];
              break;
            case 1:
              $i = getenv('APP_NAME');
              break;
            case 2:
              $i = getenv('APP_AUTHOR');
              break;
          }
          if ($a !== $i) {
            $this->license_status = 'invalid';
            break;
          }
        }
      }
    } else {
      $this->license_status = 'invalid';
    }
  }

  public function route()
  {
    $request_key = '';
    if (isset($_POST['_key'])) {
      $request_key = $_POST['_key'];
      unset($_POST['_key']);
    }

    if ($_POST) {
      $_POST = $this->encrypt(json_encode($_POST), $request_key);
    }

    if ($_FILES) {
      $_FILES = $this->encrypt(json_encode($_FILES), $request_key);
    }

    $get = $this->parseURL();

    $url = $get['url'];

    if ($get['sub_dir'] != '') {

      $this->controller_dir = $this->controller_dir . $get['sub_dir'] . '/';
    }

    if (isset($url[0])) {

      $url[0] = ucfirst($url[0]);
      if (strpos($url[0], '-')) {
        $str_explode = explode('-', $url[0]);
        $url[0] = '';
        foreach ($str_explode as $s) {
          $url[0] .= ucfirst($s) . '_';
        }
        $url[0] = substr($url[0], 0, -1);
      }
      if (file_exists($this->controller_dir . $url[0] . '.php')) {
        $this->controller = $url[0];
        unset($url[0]);
      } else {
        $content = $this->error_dir . '404.php';
        $title = '404';
        $desc = 'Page not found';
        return require_once $this->layout_dir . 'error.php';
      }
    }

    switch ($this->license_status) {
      case 'invalid':
        $title = '401';
        $desc = 'Unauthorized access';
        $content = $this->error_dir . 'invalid.php';
        return require_once $this->layout_dir . 'error.php';
        break;
      case 'expired':
        $title = '401';
        $desc = 'Unauthorized access';
        $content = $this->error_dir . 'expired.php';
        return require_once $this->layout_dir . 'error.php';
        break;
      default:
        require_once $this->controller_dir . $this->controller . '.php';
    }

    if (class_exists($this->controller)) {
      $this->controller = new $this->controller;
    } else if (class_exists('App\Controllers\\' . $this->controller)) {
      $this->controller = 'App\Controllers\\' . $this->controller;
      $this->controller = new $this->controller;
    }


    if (isset($url[1])) {
      if (method_exists($this->controller, str_replace('-', '_', $url[1]))) {
        $this->method = str_replace('-', '_', $url[1]);
        unset($url[1]);
      } else if (method_exists($this->controller, 'ACCESS_' . str_replace('-', '_', $url[1]))) {
        $this->method = 'ACCESS_' . str_replace('-', '_', $url[1]);
        unset($url[1]);
      } else if (method_exists($this->controller, 'MODIFY_' . str_replace('-', '_', $url[1]))) {
        $this->method = 'MODIFY_' . str_replace('-', '_', $url[1]);
        unset($url[1]);
      } else if (method_exists($this->controller, 'PUBLISH_' . str_replace('-', '_', $url[1]))) {
        $this->method = 'PUBLISH_' . str_replace('-', '_', $url[1]);
        unset($url[1]);
      }
    }

    if (!empty($url)) {

      $this->params = array_values($url);
    }

    call_user_func_array([$this->controller, $this->method], $this->params);
  }

  private function parseURL()
  {

    if (isset($_GET['url'])) {

      $url = explode('/', filter_var(trim($_GET['url']), FILTER_SANITIZE_URL));
      $sub_dir = '';

      if (is_dir($this->controller_dir . $url[0])) {

        $sub_dir = $url[0];
        unset($url[0]);
      }

      if (!empty($url)) {

        $url = array_values($url);
      }

      return ['sub_dir' => $sub_dir, 'url' => $url];
    }
  }

  private function hash()
  {
    return substr(hash('sha256', getenv('APP_PASSWORD'), true), 0, 32);
  }

  private function iv()
  {
    $ivlen = openssl_cipher_iv_length($this->chiper_method);
    $hex = substr(getenv('APP_KEY'), 0, $ivlen * 2);
    if (ctype_xdigit($hex)) {
      $iv = hex2bin($hex);
    } else {
      $iv = '';
    }
    return $iv;
  }

  private function chipertext()
  {
    $ivlen = openssl_cipher_iv_length($this->chiper_method);
    return substr(getenv('APP_KEY'), $ivlen * 2);
  }
}

<?php

/**
 * Created by Eko Mardiatno.
 * Copyright 2018 KOMA MVC. All Right Reserved.
 * Instagram @komafx
 * Licensed under MIT (https://github.com/ekomardiatno/koma-mvc/blob/master/LICENSE)
 */

namespace App\Wrapper;

use App\Core\Web;
use App\Core\Request;
use App\Helpers\Mod;

class Controller
{

    private $model_dir = __DIR__ . '/../Models/';
    protected $_web;

    public function __construct()
    {
        $this->_web = Web::getInstance();
    }

    public function model($file)
    {
        if (file_exists($this->model_dir . $file . '.php')) {
            require_once $this->model_dir . $file . '.php';
            $file = 'App\Models\\' . $file;
            return new $file;
        } else {
            echo 'Model as named by <i>' . $file . '</i> not exist';
            die;
        }
    }

    public function redirect($url = '')
    {
        $url = $url !== '' ? str_replace('.', '/', $url) : $url;
        header('location: ' . getenv('APP_URL') . $url);
    }

    public function request()
    {
        return new Request;
    }

    public function is_ajax()
    {
        if (!(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')) {
            echo 'it\'s an AJAX request so do something';
            die;
        }
    }

    public function upload_images($files, $path_upload = 'upload/images/', $max_size = 1024, $sizes = ['sm'], $types = ['image/jpeg', 'image/png'])
    {

        $dir = '';
        for ($i = 0; $i < count(explode('/', $path_upload)) - 1; $i++) :
            $dir .= explode('/', $path_upload)[$i] . '/';
            if (!file_exists(substr($dir, 0, -1))) :
                mkdir(substr($dir, 0, -1));
            endif;
        endfor;

        $foto = [];
        $target_length = 0;
        $index = 1;
        foreach ($files as $key => $v) {
            if (!is_array($v['name'])) {
                $stacking = $this->stacking_pictures('upld-img-' . date('Ymd') . '-' . date('His') . '-' . $index, $v, $path_upload, $types, $max_size);
                $foto[$key]['status'] = $stacking['status_string'];
                if($stacking['status']) {
                    $foto[$key]['file'] = $stacking['stacked']['file'];
                    $foto[$key]['tmp'] = $stacking['stacked']['tmp'];
                }
                $index++;
            } else {
                foreach ($v['name'] as $i => $n) {
                    $file_info = [
                        'type' => $v['type'][$i],
                        'error' => $v['error'][$i],
                        'name' => $n,
                        'size' => $v['size'][$i],
                        'tmp_name' => $v['tmp_name'][$i]
                    ];
                    $stacking = $this->stacking_pictures('upld-img-' . date('Ymd') . '-' . date('His') . '-' . $index, $file_info, $path_upload, $types, $max_size);
                    $foto[$key][$i]['status'] = $stacking['status_string'];
                    if($stacking['status']) {
                        $foto[$key][$i]['file'] = $stacking['stacked']['file'];
                        $foto[$key][$i]['tmp'] = $stacking['stacked']['tmp'];
                    }
                    $index++;
                }
            }
        }

        $uploaded = [];
        foreach ($foto as $key => $file) {
            if (isset($file['status'])) {
                if($file['status'] === 'READY') {
                    $do_upload_images = $this->do_upload_images($file['tmp'], $file['file'], $sizes);
                    if ($do_upload_images) {
                        $file['status'] = 'UPLOADED';
                        $uploaded[$key] = $file;
                    }
                }
            } else {
                foreach ($file as $i => $f) {
                    if($f['status'] === 'READY') {
                        $do_upload_images = $this->do_upload_images($f['tmp'], $f['file'], $sizes);
                        if ($do_upload_images) {
                            $f['status'] = 'UPLOADED';
                            $uploaded[$key][] = $f;
                        }
                    }
                }
            }
        }

        return [
            'target' => $foto,
            'uploaded' => $uploaded
        ];
    }

    public function delete_image_uploaded($file, $sizes = ['sm'])
    {
        foreach ($file as $foto) {
            if(!is_array($foto)) {
                foreach ($sizes as $size) {
                    if (Mod::getImageThumb($foto, $size)) {
                        unlink(Mod::getImageThumb($foto, $size));
                    }
                    if (file_exists($foto)) {
                        unlink($foto);
                    }
                }
                $dir = substr($foto, 0, strrpos($foto, '/'));
                if(is_readable($dir)) {
                    if(count(scandir($dir)) === 2) {
                        rmdir($dir);
                    }
                }
            } else {
                foreach($foto as $value) {
                    foreach($sizes as $size) {
                        if (Mod::getImageThumb($value, $size)) {
                            unlink(Mod::getImageThumb($value, $size));
                        }
                        if (file_exists($value)) {
                            unlink($value);
                        }
                    }
                    $dir = substr($value, 0, strrpos($value, '/'));
                    if(is_readable($dir)) {
                        if(count(scandir($dir)) === 2) {
                            rmdir($dir);
                        }
                    }
                }
            }
        }
    }

    private function do_upload_images($tmp, $target, $sizes)
    {
        $targetname = substr($target, strrpos($target, '/') + 1);
        move_uploaded_file($tmp, $target);
        foreach ($sizes as $size) {
            if (file_exists($target)) {
                if(!Mod::uploadImageThumb($target, substr($targetname, 0, strrpos($targetname, '.')), substr($targetname, strrpos($targetname, '.')), $size)) {
                    unlink($target);
                }
            }
        }
        if (file_exists($target)) {
            return true;
        }
        return false;
    }

    private function stacking_pictures($filename, $file_info, $path_upload, $types, $max_size)
    {
        $type = $file_info['type'];
        $error = $file_info['error'];
        $name = $file_info['name'];
        $size = $file_info['size'] / 1000;
        if ($file_info['tmp_name'] === '') {
            return [
                'status' => false,
                'status_string' => 'EMPTY'
            ];
        }
        if (in_array($type, $types) && !$error && $size <= $max_size) {
            $name = $filename . substr($name, strrpos($name, '.'));
            return [
                'status' => true,
                'status_string' => 'READY',
                'stacked' => [
                    'file' => $path_upload . $name,
                    'tmp' => $file_info['tmp_name']
                ]
            ];
        } else if (!in_array($type, $types)) {
            return [
                'status' => false,
                'status_string' => 'NOT_ACCEPTED_TYPE'
            ];
        } else if ($size > $max_size) {
            return [
                'status' => false,
                'status_string' => 'SIZE_NOT_ALLOWED'
            ];
        } else {
            return [
                'status' => false,
                'status_string' => 'ERROR_FILE'
            ];
        }
    }
}

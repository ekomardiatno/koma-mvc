<?php

/**
 * Created by Eko Mardiatno.
 * Copyright 2018 KOMA MVC. All Right Reserved.
 * Instagram @komafx
 * Licensed under MIT (https://github.com/ekomardiatno/koma-mvc/blob/master/LICENSE)
 */
namespace App\Helpers;

class Mod
{

    public static function dateID($a)
    {

        $now = date('Y-m-d H:i:s');
        $past = $a;
        $date_now = date_create(substr($now, 0, 4) . '-' . substr($now, 5, 2) . '-' . substr($now, 8, 2));
        $date_past = date_create(substr($past, 0, 4) . '-' . substr($past, 5, 2) . '-' . substr($past, 8, 2));
        $diff = date_diff($date_past, $date_now);
        $diff = intval($diff->format('%R%a'));

        $y = substr($a, 0, 4);
        $m = substr($a, 5, 2);
        $d = substr($a, 8, 2);
        $t = substr($a, 11, 5);

        if ($m == '01') {
            $m = 'Jan';
        } else if ($m == '02') {
            $m = 'Feb';
        } else if ($m == '03') {
            $m = 'Mar';
        } else if ($m == '04') {
            $m = 'Apr';
        } else if ($m == '05') {
            $m = 'Mei';
        } else if ($m == '06') {
            $m = 'Jun';
        } else if ($m == '07') {
            $m = 'Jul';
        } else if ($m == '08') {
            $m = 'Agu';
        } else if ($m == '09') {
            $m = 'Sep';
        } else if ($m == '10') {
            $m = 'Okt';
        } else if ($m == '11') {
            $m = 'Nov';
        } else if ($m == '12') {
            $m = 'Des';
        }

        switch($diff) {
            case 0:
                $now = date_create($now);
                $past = date_create($past);
                $diff = date_diff($past, $now);
                $diff_i = intval($diff->format('%R%i'));
                $diff_h = intval($diff->format('%R%H'));
                $diff_i = $diff_i + $diff_h * 60 ;
                if($diff_i <= 0) {
                    return 'Baru saja';
                } else if($diff_i < 60){
                    return $diff_i . ' menit yang lalu';
                } else if($diff_h <= 10){
                    return $diff_h . ' jam yang lalu';
                } else {
                    return 'Hari ini' . ($t ? ', ' . $t : '');
                }
            case 1:
                return 'Kemarin' . ($t ? ', ' . $t : '');
            default:
                return $d . ' ' . $m . ' ' . $y . ($t ? ', ' . $t : '');
        }
    }

    public static function hash($password)
    {

        $option = [
            'cost' => 10
        ];

        return password_hash($password, PASSWORD_DEFAULT, $option);
    }

    public static function uploadImageThumb($file, $name, $type, $size)
    {

        
        $path_upload = substr($file, 0, strrpos($file, '/')) . '/';

        switch ($size) {
            case 'lg':
                $set_width = getenv('IMAGE_LG_SIZE');
                break;
            case 'md':
                $set_width = getenv('IMAGE_MD_SIZE');
                break;
            case 'sm':
                $set_width = getenv('IMAGE_SM_SIZE');
                break;
            case 'xs':
                $set_width = getenv('IMAGE_XS_SIZE');
                break;
            case 'xxs':
                $set_width = getenv('IMAGE_XXS_SIZE');
                break;
        }

        list($width, $height) = getimagesize($file);

        $scale = $width / $set_width;

        
        if($width > $set_width) {
            $get_width = $width / $scale;
            $get_height = $height / $scale;
        } else {
            $get_width = $width;
            $get_height = $height;
        }

        $image_resize = imagecreatetruecolor($get_width, $get_height);
        $image_source = null;

        switch ($type) {
            case '.jpg':
                $image_source = imagecreatefromjpeg($file);
                break;
            case '.png':
                $image_source = imagecreatefrompng($file);
                break;
            case '.jpeg':
                $image_source = imagecreatefromjpeg($file);
                break;
        }
        imagecopyresized($image_resize, $image_source, 0, 0, 0, 0, $get_width, $get_height, $width, $height);

        $target = $path_upload . $name . '-' . $size . $type;

        switch ($type) {
            case '.jpg':
                imagejpeg($image_resize, $target);
                break;
            case '.png':
                imagepng($image_resize, $target);
                break;
            case '.jpeg':
                imagejpeg($image_resize, $target);
                break;
        }

        imagedestroy($image_resize);
        imagedestroy($image_source);

        if(file_exists($target)) {
            return true;
        }
        return false;
    }

    public static function getImageThumb($file, $size)
    {
        $file = substr_replace($file, '-' . $size, strrpos($file, '.'), 0);
        if(file_exists($file)) {
            return $file;
        }
        return false;
    }
}

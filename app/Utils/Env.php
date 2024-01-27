<?php
 
namespace App\Utils;

class Env {
    private static $path = '/.env';

    public static function load($directory){
        if(!file_exists($directory . self::$path)){
          return false;
        }
    
        $file = file($directory . self::$path);
        foreach($file as $file_lines){
          putenv(trim($file_lines));
        }
      }
}
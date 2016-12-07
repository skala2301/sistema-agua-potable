<?php


spl_autoload_register(function($class)
{
    $file =  APPPATH .  "complement/" . strtr($class, '\\', '/').'.php';
    if (file_exists($file)) {
        require $file;
        return true;
    }
});
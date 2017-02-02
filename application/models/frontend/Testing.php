<?php

/**
 * Created by PhpStorm.
 * User: rolando
 * Date: 10-03-16
 * Time: 09:56 PM
 */


class Testing extends CI_Model
{

    protected $dir_             = __DIR__;

    public function __construct()
    {
        parent::__construct();
    }

    public function k ()
    {
        "hola muindo desde aca";
    }

}
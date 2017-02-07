<?php


if(!function_exists("set_database_query")){

    function set_database_query($table , $prefix , $query ){
        return str_replace($prefix , $table  , $query);
    }

}
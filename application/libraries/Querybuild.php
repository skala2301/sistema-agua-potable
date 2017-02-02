<?php

/**-------------------------------------------------------------------------
 * @author Rolignu <rolignu90@gmail.com>
 * @version global 1.1.1
 * -------------------------------------------------------------------------
 **/

class Querybuild extends CI_Loader
{

    /**
     * QUERY BUILD IS A CLONE LIBRARY BASED IN CI_DATABASE
     * THIS LIBRARY MAKES EASIER TO MAKE CALLS BASED DATA INSTRUCTIONS DO SO saving us DEFAULT
     **/

    protected $last_query = "";

    protected $class      = NULL;

    /**
     * this only a construct relax man
     **/
    public function __construct()
    {
        $this->class = &get_instance();
        $this->class->load->database();
    }

    /**
     * @version 1.1.1
     * @todo query handler
     *
     *      uso de handler
     *
     *          esta funcion acepta un parametro funcion lambda
     *
     *          ejemplo  function() use ($object) {}
     *
     *  $object = variable donde debe de contener un stdclass
     *
     *              $object->query = ""
     *              $object->table = ""
     *              $object->params = "" | string | array | [ param1 , param2 , param3 ...]
     *
     *   $query = $this->instance
    ->querybuild
    ->GetQueryHandler(function() use ($objects  ){
    return [str_replace("[table]" , $objects->table , $objects->query ) , $objects->params];
     * });
     *
     * @param lambda |  function() $handler
     * @return stdClass  (object) [  query => string , params => bool , count => int  ]
     **/
    public function GetQueryHandler($handler) : stdClass
    {

        if(!is_callable($handler)){
            return (object) [ "query" =>null, "params" => true , "count" => 0  ];
        }

        $data       =     $handler();
        $str        =     $data[0];
        $params     =     $data[1] ?? null;

        $this->last_query = $str;

        if(is_null($params))
        {
            return (object ) [ "query" => $str  , "params" => false  ];
        }
        else if(is_string($params))
        {
            $str = str_replace("#1" , $params , $str);
            return (object) [ "query" => $str , "params" => true , "count" => 1 ];
        }
        else if (is_array($params))
        {
            $i = 1;
            foreach($params as $p )
            {
                $str = str_replace("#$i" , $p , $str);
                $i++;
            }

            return (object) [ "query" => $str , "params" => true , "count" => $i  ];

        }

        return (object) [ "query" =>null, "params" => true , "count" => 0 ];

    }


    /**
     * @todo get las query build string
     * @version 1.0.0
     * @return string / las query to instance
     **/
    public function GetLastQuery()
    {
        return $this->last_query;
    }


    /**
     * @todo get result to a query command
     * @version 1.1.0
     * @param string $query a query to call
     * @param array  $params a array data params to pass
     * @return mixed / object
     **/
    public function query($query , $params = [] )
    {
        if(is_null($query) || empty($query))
        {
            return (object)[];
        }


        if(count($params) == 0)
        {

            return $this->class
                ->db
                ->query($query)
                ->result();
        }
        else{
            return $this->class
                ->db
                ->query($query, $params)
                ->result();
        }
    }


    /**
     * @todo a simple update function to query
     * @version 1.0.0
     * @params array $params
     * @params string $table
     * @params array/string $where
     **/
    public function update($params , $table , $where)
    {
        return $this->class->db->update($table , $params , $where);
    }

}
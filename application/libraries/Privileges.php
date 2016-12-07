<?php

class Privileges extends User
{


    protected $privs_    = NULL;

    protected $nav      = NULL;

    protected $table    = NULL;

    protected $table1   = NULL;

    protected $class    = NULL;

    protected $tokens   = [
        ",",
        "|",
        "&",
        '%'
    ];

    protected $sql = [
        "exec"      => "SELECT privs as 'privs' FROM [table] WHERE location LIKE ? OR route LIKE ?",
        "rol"       => "SELECT [table1].id as 'rol' FROM [table1] WHERE name LIKE ?",
        "get"       => "SELECT [table1].id , [table1].name FROM [table1]"
    ];

    public function __construct($params = NULL)
    {

        $this->privs_ = $params['privs'] ?? NULL;
        $this->nav = $params['navs'] ?? NULL;

        parent::__construct();

        $this->class    = &get_instance();
        $this->class->load->database();
        $this->table    = $this->class->db->dbprefix("nav");
        $this->table1   = $this->class->db->dbprefix("rols");
    }

    public function compute($privs = NULL, $navs  = NULL)
    {
        if ($privs != null) $this->privs_ = $privs;

        $builder    = str_replace("[table]" , $this->table , $this->sql['exec']);

        $state      = $this->class
                            ->db
                            ->query($builder , [$navs , $navs])
                            ->result();


        if(count($state) !== 0)
            $this->nav = $state[0]->privs ?? NULL;

        return $this;
    }


    public function result()
    {

        //si no hay donde comparar entonces se va un true de un solo
        if (is_null($this->nav) && is_null($this->privs_)) {
            return TRUE;
        }




        //instancia
        parent::privileges(false); // instanciamos los privilegios del usuario

        //privilegios del usuario
        $parent = parent::get_parent();         //privilegios padre
        $child = parent::get_childs(0);

        //privilegios de la aplicacion
        $privs      = $this->privs_;
        $nav_privs  = $this->nav;





        //necesitamos que la data se entregue en arreglo no asociado
        if(!is_array($this->privs_))
            $privs = $this->transform($this->privs_);
        if(!is_array($this->nav))
            $nav_privs = $this->transform($this->nav);
        if(!is_array($child))
            $child = $this->transform($child);





        if( !is_array($nav_privs) &&  $nav_privs == 0) return TRUE;


        //Verificamos el privilegio padre
        $parent  = $this->preview($parent );




        // si el privilegio padre esta detro de los accesos nos saltamos el each
        if(in_array($parent , $privs)) return TRUE;
        else if(in_array($parent ,$nav_privs)) return TRUE;
        else if(strcmp($parent , $nav_privs) === 0) return TRUE;
        else if(strcmp($parent , $privs) === 0) return TRUE;



        //verificando privilegios hijos
        foreach ($child as $c) {
            $n = $this->transform($c);

            if(empty($n)) continue; //parche si child es vacio entonces continue

            if(in_array($n , $privs)) return TRUE;
            else if(in_array($n ,$nav_privs)) return TRUE;
            else if(strcmp($n , $nav_privs) === 0) return TRUE;
            else if(strcmp($n , $privs) === 0) return TRUE;
        }



        return FALSE;


    }
    
    
    public function get_all_rols()
    {
       $rols = str_replace("[table1]", $this->table1, $this->sql['get']);
       return $this->class->db->query($rols)->result();
    }

    private function transform($string)
    {

      if(is_numeric($string))
      {
         return $string;
      }
        //verifica el toke correspondiente y lo transforma a un arreglo
        foreach ($this->tokens as $token) {
            if(strpos($string , $token) !== FALSE)
            {
                return explode($token , $string);
            }
        }
    }

    private function preview($priv_user)
    {
         //verificamos si la data entregada es el
         //id del rol dado caso se debe de previzualizar a un id
         if(is_numeric($priv_user))
         {
            return $priv_user;
         }
         else if(is_string($priv_user)) {
             $format = str_replace('[table1]' , $this->table , $this->sql['rol']);
             $result = $this->class->db->query($format)->result();
             return $result[0]->rol;
         }
         else {
             return null;
         }
    }
    
    
    


}

<?php

/**
 * The class works
 * log to keep track of the functions that have been configured as relevant ,
 * this class creates a log for each user
 *
 * @author Rolando Arriaza <rolignu90@gmail.com>
 * @version 1.0.0
 * @date 10-7-2016
 */

defined("LOG_TYPE_SYSTEM") or define("LOG_TYPE_SYSTEM" , 0);
defined("LOG_TYPE_USER") or define("LOG_TYPE_USER" , 3);
defined("LOG_TYPE_UNDEFINED") or define("LOG_TYPE_UNDEFINED" , 2);


class Logfile
{

    protected $class ;

    protected $querys = [
        "detect" => "SELECT count(*) as 'count' FROM [table] WHERE [table].key LIKE ? AND id_user LIKE ?",
        "data"   => "SELECT value as 'data' FROM [table] WHERE [table].key LIKE ? AND id_user LIKE ?"
    ];

    protected $has = FALSE;

    protected $table = "";

    protected $commands = [
        "%user%"            => "[user]",
        "%username%"        => "[username]",
        "%ip%"              => "[ip]",
        "%email%"           => "[email]",
        "%datetime%"        => "[datetime]"
    ];

    private $meta_key = "log_file";

    private $user_id = "";

    public function __construct($params = null )
    {

        //load
        $this->class        = &get_instance();
        $this->class->load->database();
        $this->class->load->library("user");



        if(isset($params['id']))
            $this->user_id = $params['id'];
        else
            $this->user_id      = $this->class->user->get()->id();


        $this->table        = $this->class->db->dbprefix("metadata");


        //get if exist a metadata has current user for logfile
        $this->has          = $this->class->db->query(str_replace("[table]" ,
                                        $this->table ,
                                        $this->querys['detect']), [ $this->meta_key , $this->user_id ])
                                             ->result()[0]->count > 0 ? TRUE  : FALSE ;

        /**
         * load the predeterminate commands
        **/

        $this->class->load->helper(["date", "string"]);

        if(!isset($params['command'])) {
            $this->commands["%user%"]       = $this->class->user->user();
            $this->commands["%username%"]   = $this->class->user->name();
            $this->commands["%email%"]      = $this->class->user->email();
            $this->commands["%ip%"]         = $this->class->input->ip_address();
        }

        $this->commands["%datetime%"]       = date(DATE_RFC822 , time());

    }

    public function Add($title , $description , $type = LOG_TYPE_SYSTEM )
    {

         if(!$this->has)
         {
             $this->class->db->insert($this->table , [
                 $this->table . ".key"  => $this->meta_key,
                 "value"                =>  NULL ,
                 "id_user"              => $this->user_id,
                 "id_rol"               => 0
             ]);

         }

        if(empty($description)) return NULL;

        foreach ($this->commands as $command => $value)
        {
            $description = str_replace($command , $value , $description );
        }

        switch ($type)
        {
            case LOG_TYPE_SYSTEM:
                $description = "[SYSTEM] " . $description;
                break;
            case LOG_TYPE_USER:
                $description = "[USER] " . $description;
                break;
            case LOG_TYPE_UNDEFINED:
                $description = "[NOT DEFINED] " . $description;
                break;
        }

        $description = "[$title]" . $description;

        $data = $this->class->db->query(str_replace("[table]" , $this->table , $this->querys['data']),
                                        [ $this->meta_key , $this->user_id ])->result()[0]->data;

        $data = json_decode($data);

        $data[] = [
            "id"        => random_string("md5"),
            "data"      => $description,
            "date"      => date(DATE_RFC1123 , time())
        ];


        return $this->class->db->update($this->table , [
            "value"     => json_encode($data)
        ],[
            $this->table . ".key" => $this->meta_key,
            "id_user"             => $this->user_id
        ]);

    }

    public function Read($id = NULL , $json = FALSE )
    {

        if(!is_null($id)) $this->user_id = $id;

        $data = $this->class
                     ->db
                     ->query(str_replace("[table]" , $this->table , $this->querys['data']),
                                [ $this->meta_key , $this->user_id ])
                     ->result()[0]
                     ->data;

        return  $json == FALSE ? json_decode($data) : $data;

    }

    public function ReadPage($start = 0 , $count = 10 , $id = NULL )
    {

        $data           = array_reverse($this->Read($id));
        $counter        = count($data);
        $data_sheet     = [];

        for($i = $start ; $i < $counter ; $i++)
        {
            if(($count + $start) < $i) break;
            $data_sheet[] = $data[$i];
        }

        return $data_sheet;

    }

    public function Delete()
    {

    }

}
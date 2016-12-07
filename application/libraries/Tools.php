<?php


class Tools {
    
    var $class      = NULL;
    
    private $lang_date      = array(
        "es"     => array(
            "now"       => " ahora",
            "week"      => " semana",
            "day"       => " dia",
            "days"      => " dias",
            "month"     => " mes",
            "months"    => " meses",
            "year"      => " año",
            "years"     => " años",
            "minutes"   => " minutos",
            "hour"      => " hora(s)"
        ),
        "en"    => array(
            "now"       => " now",
            "week"      => " week",
            "day"       => " day",
            "month"     => " months",
            "year"      => " years"
        )
    );
    
    private $timezone       = "America/El_Salvador";
    
    public function __construct() {
        if (function_exists("get_instance")) {
            $this->class = &get_instance();
        }
    }
    
   
    public function __call($name, $arguments) {
        //NO CALLS 
    }
    
    
    /**
     * GET Y SET DE LA LIBRERIA TOOLS 
     * 
     * **/
    
    public function get(){
        return $this;
    }
    
    public function set(){
        return $this;
    }
    
    public function PrettyDate($date , $lang = "es"){
        $this->default_timezone();
        $d              = new DateTime($date);
        $n              = new DateTime("now");
        $interval       = $n->diff($d);
        $days           = $interval->d;
        $month          = $interval->m;
        $year           = $interval->y;
        $hour           = $interval->h;
        $min            = $interval->i;

        if($year != 0){
                return $year == 1 ?  $year . $this->lang_date[$lang]['year'] :
                    $year . $this->lang_date[$lang]['years'];
        }else if($month != 0){
             return $month == 1 ? $month . $this->lang_date[$lang]['month'] :
                    $month . $this->lang_date[$lang]['months'];
        }else if($days != 0){
                return $days == 1 ? $days . $this->lang_date[$lang]['day'] :
                    $days . $this->lang_date[$lang]['days'];
        }else if($hour != 0){
             return $hour . $this->lang_date[$lang]['hour'];
        }
        else{
            return $min >= 0 && $min <= 2 
                    ? $this->lang_date[$lang]['now'] : 
                     $min . $this->lang_date[$lang]['minutes'];
        }
    }

    
    public function default_timezone(){
        date_default_timezone_set($this->timezone);
    }
    
    public function current_datetime(){
        $d = new DateTime("now");
        return $d->format("Y-m-d H:i:s");
    }
    
    public function current_date(){
        $d = new DateTime("now");
        return $d->format("Y-m-d");
    }
   
}

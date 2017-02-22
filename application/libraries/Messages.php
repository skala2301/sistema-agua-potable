<?php

class Messages {

    var $class                  = NULL;
    
    protected $from_            = NULL;
    
    protected $to_              = NULL;
    
    protected $msj_             = NULL;
    
    protected $subject_         = NULL;

    public function __construct() {
        
        $this->class = &get_instance();
        
        $this->class->load->helper("setup");
        $this->class->load->library("email");

        if (email_config() != NULL) {
            $this->class->email->initialize(email_config());
        }
    }

    public function get_config(){
        return email_config();
    }

    
    public function emailFrom($email = NULL , $name = NULL){
       $this->from_ = $email != NULL ? array(
           "from"   => $email,
           "name"   => $name != NULL ? $name : $email
       ) : email_admin();

       return $this;
    }
    
    public function email_subject($subj){
        $this->subject_ = $subj ?? '';
        return $this;
    }
    
    public function email_to($to){
       $this->to_ = $to;
       return $this;
    }
    
    public function email_body($body){
        $this->msj_ = $body;
        return $this;
    }
    
    public function email_attach($attach){
        $this->class
                ->email
                ->attach($attach);
        return $this;
    }
    
    public function email_attach_cid($attach){
        return $this->class
                ->email
                ->attachment_cid($attach);
    }
    
    public function email_send(){

        $this->class
                ->email
                ->from($this->from_['from'] , $this->from_['name']);
        
        $this->class
                ->email
                ->to($this->to_);

        $this->class
                ->email
                ->subject($this->subject_);

        $this->class
                ->email
                ->message($this->msj_);

        return $this->class
                ->email
                ->send(false) ?? false ;
    }
    
    public function debugger(){
        return $this->class->email->print_debugger();
    }

}

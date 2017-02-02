/**
 *@version 1.1
 *@author Rolando Arriaza
 *@licence MIT
 *@constructor jtask 
 */

var jtask = function(){

    this.method         = "POST";
    
    this.url            = "/";
    
    this.cache          = false;
    
    this.data           = {};
    
    this.beforesend     = false;
    
    this.dataType       = "html";
    
    this.conf_before    = null;
    
    this.conf_complete  = null;  
    
    this.async          = true;
    
    this.callback       = {};
    
    this.error          = {};
    
    this.do_task = function(){
        
        this.method   = this.method.toUpperCase();
        
        var to_data   = null;
        
        var before    = this.beforesend;
        
        var C_before  = this.conf_before;
        
        var C_url     = this.url;

        var C_method  = this.method;
        
        var C_type    = this.dataType;
        
        var C_cache   = this.cache ;

        var C_async   = this.async;
        
        var C_call    = this.callback;
        
        var C_complete  = this.conf_complete;
        
        var C_error     = this.error;
        
        switch(this.method){
            case "POST":
                to_data = this.data;
                break;
            case "GET":
                to_data = this.get_convert();
                break;
        }
        
        $.ajax({
            
              type: C_method,
              url:  C_url,
              data : to_data ,
              dataType: C_type,
              crossDomain: true,
              cache: C_cache,
              async : C_async,
              beforeSend : function(){
                    if(before){
                        C_before.target();
                    }
              },
              complete   : function() { },
              success: function ( callback){ C_call.callback(callback);},
              statusCode: {
                        404: function() {
                        alert( "Opps!!! page not found" );
                    }
              },
              error: function(e){
                  C_error.error_handle(e);
              }
        });
         
    };
    
    this.get_convert = function(){
          var data  = $.map(this.data , function(i ,j){
               return [ j + "=" + i];
          });
          return data = data.join('&');
    };
    
    this.config_before = function(target){
         this.conf_before = { 
             "target" : target
         };
    };
    
     this.config_complete = function(target){
         this.conf_complete = { 
             "target" : target
         };
    };
    
    this.success_callback = function (callback){
         this.callback = {
              "callback" : callback
         };
    };
    
    this.error_handle = function(handle){
        this.error = {
            "error_handle" : handle
        };
    };
    
};


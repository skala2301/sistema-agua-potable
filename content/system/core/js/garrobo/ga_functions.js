/**
 * Created by Rolando Arriaza on 12/6/2016.
 * Licence MIT
 */

'use strict';

var page                    = $("#ga_");
var back_end                = $("#ga_dashboard").val();
var url_                    = $("#ga_url").val();
var entry_                  = $("#ga_entry").val();
var head_                   = $("#ga_head");
var foot_                   = $("#ga_foot");
var title_                  = $("#ga_title");
var limit_request_          = $("#ga_limit").val();


var ga_id_script            = null;



/***
 * @ga_
 * @author Rolando Arriaza
 * @version 2.1.0
 * @todo
 *
 *      <ga_> es una funcion en la cual hace la conexion y filtros necesarios
 *            para que garrobo funcione sin hacer el uso de reflesh en paginacion
 *            el metodo verbosite por defecto es GET donde x=pi asiendo asignacion
 *            pi como una constante irregular OMG !!!
 *
 *            por si tienen duda alguna ga_ esta escrito en ES6 , si no tiene conocimiento
 *            alguno de ES6 favor favor favor !!! no tocar.
 *
 * @param location .. string where is the location to call
 * ***/
var ga_  = (location, element = null , counter = 0)=>
{


    try{

        if(element != null)
        {
            var e = $("#sga_" + element);

            $(".sub-menu").find("li").each(function (a, b) {
                $(b).removeClass("active")
                    .removeClass("open");
            });

            $(".page-sidebar-menu.page-header-fixed")
                .find("li")
                .each(function (a, b) {
                    let h = $(b).find("a").find("span").each(function (x, y) {
                        if ($(y).hasClass("arrow"))
                            return true;
                        else
                            return false;
                    })
                    if (!h)
                        $(b).removeClass("active")
                            .removeClass("open");
                });

            e.parent().addClass("active open");
        }

    }catch(e){}


    var x = $("#ga_url").val();
    $.ajax({
        url : location ,
        dataType: "json",
        beforeSend: () => {
            page.prepend('<img style="width:5%;padding-bottom:5%;" src="' + x  + 'content/assets/svg/ripple.svg" />');
        },
        success : (s)=>{

            try {
                let core = new ga_core(); // prototype garrobo instance ES5

                core.clean_(); // clean all extra css and js

                ga_id_script = s.id; // the id global

                core.css_filter(s.css, s.id); // if exist css filter
                core.js_filter(s.js, s.id); // if exist js filter
             
                let the_title = s.title !== 'undefined' || s.title !== null ? s.title : "Main"; // set the title , or return main

                title_.html(the_title); //  set title
                page.html(s.view); // set view
            }catch (e)
            {

                page.html("");
                ga_(location , null , counter++);

            }
        }
    }).fail((a)=>{
        /***
         * oh my god !!!
         * if there is an error to call Ga_ dashboard
         * **/
        counter = counter + 1;
        page.html("<b style='font-size:1em;'>Pagina no encontrada , Redireccionando... (+" + counter + " try)</b>");
        if(limit_request_ <= counter){
            ga_request({
                'function'  : 'end_session',
                'dir'       : 'system',
                'model'     : 'end_session'
            },  {} , function (r) {
                window.location.href = url_ + back_end ;
            });
        }else
            ga_(url_ + back_end  , null , counter );
    });

};


/**
 * @todo ga_request its send a simple request and return a any value ...
 * @version 1.0.5
 * @author Rolando Arriaza
 * @param object/string location [add a location][example] : [ { function: 'hello' , dir : 'system' , model : 'test' } ] or a string 'hello/system/test'
 * @param object data, data to sender if exist
 * @param object/function/string/null result ,where send a result if exist
 * @param object sender , { id : 'element' , html : 'load...' }
 * ***/
var ga_request = (location  , data = {} , result = function(){} ,  sender = null ) =>
{
    
     var url = $("#ga_url").val() + "Dashboard/Request/";

    if(typeof location === 'object') {

        url += location.function;
        url += "/";
        url += location.dir;
        url += "/";
        url += location.model;
    }
    else if(typeof location === 'string')
    {
        url += location;
    }
    else {
        return { error : 'is Null ' , type: null  , result : null }
    }

    $.ajax({
        url : url,
        data : data,
        type: "POST",
        beforeSend: () =>
        {
            if(sender != null)
            {
                $("#" + sender.id).html(sender.html());
            }
        },
        success: (r) =>
        {
            if(typeof  result === 'function')
                return result(r);
            else if (_.isObject(r))
            {
                if(result.async !== 'undefined' && typeof result.async === 'function')
                {
                    return result.async(r);
                }
            }else {
                return null;
            }
        }

    }).fail(function(xhr , status ){
        console.log(xhr);
    });

};



/**
 * @todo ga_forms its send a form request and return values
 *
 * **/
var ga_forms   = (id = null , success = function(){} , beforesend = function(){} ) =>
{
     if(id == null) return null;
     var form_ = $("#" + id);
    $.ajax({
            type            : form_.attr('method'),
            url             : form_.attr('action'),
            data            : form_.serialize(),
            success         : success ,
            beforeSend      : beforesend,
            dataType        : "json"
        }).fail((event, status )=>{
            console.log("Error submit file ... missing arguments");
            console.log(status);
    });
};



/**
 * @author Rolando Arriaza
 * @version 1.4.0
 * @todo ga_core
 *
 *          <ga_core> esta es una funcion basada en contructores de clases o
 *                    prototipos de forma indirecta, son series de funciones
 *                    en la cual ayuda al garrobo a se lo que es un GARROBO.
 *                    
 *          Ultima modificacion : 3/12/2016 por rolignu
 * **/

var ga_core     = function()
{

    this.clean_ = () => {

           head_.find("link,style,script").each((k,v)=>{
               if($(v).attr("id") === ga_id_script )
               {
                   $(v).remove();
               }
               else if($(v).attr("async"))
               {
                   $(v).remove();

               }
           });

           foot_.find("script").each((k,v)=>{
            if($(v).attr("id") === ga_id_script )
            {
                $(v).remove();
            }
        });
    };

    this.css_filter = (f , id) =>{
         $.each(f, (z,m) => {
             if(typeof m === 'object')
             {
                  return this.css_filter(m, id);
             }
             else {
                 try {

                     let t = m.toString();
                     let r = /<style>.*?<\/style>/.exec(t);
                     if(r !== null)
                     {
                         let parse = $.parseHTML(t);
                         $(parse).attr("id" , id);
                         head_.append(parse);
                     }
                     else  {
                         r = new RegExp("^(http|https)://", "i");
                         let k = r.test(t);
                         if(k !== null)
                         {
                             let v = "text/css";
                             //let v = typeof z === 'string' ?  z : "text/css";
                             let uri = '<link href="' + t + '" rel="stylesheet" id="' + id + '" type="' + v + '">';
                             head_.append(uri);
                         }
                         else
                         {
                             console.log("Css erroneo :" + t);
                         }
                     }

                 }catch (ex)
                 {
                     console.log("Error encontrado en :" + m + ": tipo: " + ex);
                 }
             }
         });
    };

    this.js_filter = (f, id ) =>{
       let result_ = [];
       
       result_.push( $.each(f, (z,m)=>{
             
             if(typeof m === 'object') {
                 if (m.script !=  null ) {
                     var t = m.type === 'undefined' ? "text/javascript" : m.type;
                     var l = m.location === 'undefined' ? "footer" : m.location;
                     this.parse_js(m.script, {
                         "type"     : t,
                         "location" : l,
                         "systemjs" : m.systemjs
                     }, id);
                 }
                 else if(Array.isArray(m))
                 {

                     let obj = $.extend({} , m );
                     let a = [obj];
                     return this.js_filter( a,id);
                 }
                 else {

                     return this.js_filter(m, id);
                 }
             }
             else {
                 var k = !isNaN(z)  ? "text/javascript" : z;
                 this.parse_js(m.toString() , {
                     "type"             : k,
                     "location"         : "footer"
                 } , id);
             }
             
         }));

    };
    
    this.parse_js = (script , params , id )=>{


        let r = /<script>.*?<\/script>/.exec(script);
        let parse = null;
        if(r !== null)
        {
            parse = $.parseHTML(script ,true);
            $(parse).attr("id" , id)
                    .attr("type" , params.type);
        }
        else
        {
            r = new RegExp("^(http|https)://", "i");
            let k = r.test(script);
            if(k !== null)
            {

               if(params.systemjs == false || params.systemjs  == 'false')
               {
                        parse = document.createElement('script');
                        parse.onload= "";
                        parse.src = script;
                        parse.type = params.type;
                        parse.id = id;
                        parse.async = true;
               }
               else{
                    parse                = document.createElement('script');
                    parse.async          = true;
                    parse.innerHTML      = "System.import('" + script + "').then(console.log.bind(console));";
                    parse.id             = id;
               }
               
            }
            else
            {
                console.log("Javascript erroneo :" + script );
            }
        }


         switch (params.location)
         {
             case "header":
                 head_.append(parse);
                 break;
             case "footer":
                 foot_.append(parse);
                 break;
             default:
                 foot_.append(parse);
                 break;
         }

    };
    
    this.sidebar_ = () => {

        window.setInterval(function(){
            $(".nav-item")
                .removeClass("active")
                .find("span.selected")
                .remove();

            $(".nav-item.open")
                .addClass("active")
                .find("a")
                .append("<span class='selected'></span>");

        } , 500);
    };

};


var ga_tools = {


     get_images : function(input)
     {
         var files = document.getElementById(input);
         if(files.files.length == 1) return files.files[0];
         else return files.files;
     },

     set_lang : function(lang){
         $("#ga_lang").val(lang);
     }
};



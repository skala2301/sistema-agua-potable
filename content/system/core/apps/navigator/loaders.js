    /**objeto navigator_ encargado de la manipulacion en carga***/


    var navigator_ = {

        load : ()=> {

            $("#nav_tree").jstree();

            /**
             * Tree info objects events
             * **/

            $("#edit-tree-info").click( () => {
                navigator_.edit();
            });

            $("#save-tree-info").click( ()=>{
                navigator_.saveEdit();
            });

            $("#trash-tree-info").click(()=>{
                navigator_.modal();
            });

            $("#delete-nav").click(()=>{
                navigator_.delete();
            });

            $("#tp-click").click(()=>{
                ReactDOM.render(
                    React.createElement(NavNewRender,{}) ,
                    document.getElementById('tab_1_2')
                );
            });

            $("#sub-click").click(() =>{
                ReactDOM.render(
                    React.createElement(Sub_Menu_Render , {} ),
                    document.getElementById('tab_1_3')
                );
            });


        },

        save : function(pointer, target )
        {


            var error = false;
            var directives = {
                target : target,
                sidebar : {
                    pattern : {
                        0 : 'txt-location',
                        1 : 'txt-route'
                    }
                },
                pattern : null , //patrones sin objetivo o target
                namespace : {},
                section: {},
                sub_menu : {
                    pattern : {
                        0 : 'txt-location',
                        1 : 'txt-route'
                    }
                },
                merger : {
                    pattern: {
                        0 : 'txt-icon',
                        1 : 'txt-langs[]',
                        2 : 'txt-privs'
                    }
                }
            };

            error = ga_tools.form_validation(directives , pointer );

            if(error)
            {
                $("#error-message").css({"display" : "block"});
                return false;
            }else {
                $("#error-message").css({"display" : "none"});
            }


            let serial = $(pointer).serialize();

            var lang_param = [];
            $("input[name='txt-langs[]']").each(function(){
                lang_param.push({
                    lang    : $(this).attr("id"),
                    value   : $(this).val()
                });
            });


            ga_request({
                func : 'Save',
                dir : 'system',
                model : 'navigator'
            } , {
                data : serial ,
                target : target,
                privs : $("#txt-privs").val().join(),
                names : $.param({ names :  lang_param})
            } , function(a){

                gatoast = new ga_toast();
                gatoast.config();

                a = JSON.parse(a);

                switch(a.error)
                {
                    case false:
                        gatoast.set_toast(a.message);
                        break;
                    case true:
                        gatoast.set_toast(a.message , gatoast.warning_data);
                        break;
                }

                switch(a.warning)
                {
                    case false:
                        break;
                    case true:
                        gatoast.set_toast(a.message , gatoast.warning_data);
                        break;
                }


                $("#input,select,textarea").each(function(){
                    $(this).val("");
                });

            });


        },

        tree_show : (id , type , render = 'form-render-tree') =>
        {


            var data       = null;

            if(type !== 'sub_menu')
            {
                  data = JSON.parse($("#data_tree").val());


                let result     = navigator_.recursive_tree(data , id , type );

                //llamado a renderizar desde JS
                ReactDOM.render(
                    React.createElement(NavRender , { node : result  }),
                    document.getElementById(render)
                );
            }
            else
            {

                navigator_.get_sub_menu(function(a){
                    data = JSON.parse(a);

                    let result     = navigator_.recursive_tree(data , id , type );

                    //llamado a renderizar desde JS
                    ReactDOM.render(
                        React.createElement(NavRender , { node : result  }),
                        document.getElementById(render)
                    );

                });

            }


          
        },

        recursive_tree: (obj , id , type) =>
        {
            let r = $.map(obj , function (v) {
                  if(v.id == id) {return v; }
                  if(typeof v.sidebars != 'undefined' && v.sidebars != null  ){
                      let k = navigator_.recursive_tree(v.sidebars , id , type);
                      if(k.length != 0) return k;
                  }
                  if(typeof v.sections  != 'undefined' && v.sections != null  ){
                        let m = navigator_.recursive_tree(v.sections , id , type);
                        if(m.length != 0) return m;
                  }
            });
            return r;
        },
        
        edit : function(render = 'form-render-tree'){

            let fd = $("#" + render );

            if(fd.children().length == 0)
            {
                alert("Seleccione un nodo en el arbol.");
                return;
            }

            if(render == 'form-render-tree')
                    $("#save-tree-info").removeAttr("disabled");
           
            $("#data-render").find("div").find(":input").each(function(){
                $(this).removeAttr("disabled");
            });

        },

        saveEdit : function()
        {

            let d = [];
            $("#data-render").find("div").find(":input").each(function(){
                 if( $(this).attr("name") != undefined ||  $(this).attr("id") != undefined)
                 d.push({
                     name : $(this).attr("name"),
                     id   : $(this).attr("id"),
                     data : $(this).val()
                 });
            });


            ga_request( {
                function: 'Edit' ,
                dir : 'system' ,
                model : 'navigator'
            }  , { "data" : d  }, (request)=>{

                request = parseInt(request) >= 0 ? parseInt(request) : request  ;
                gatoast = new ga_toast();
                gatoast.config();
                switch(request)
                {
                    case 0:
                        gatoast.set_toast("Hubo un error al momento de procesar la información" , "Opps!!" , gatoast.warning_data);
                        break;
                    case 1:
                        gatoast.set_toast("Configuracion Almacenada sin problemas" , "Exito !" );
                        break;
                    default:
                        let name         = "Hubo un error en el sistema al momento de ejecutar (editar) navegador";
                        let error        = request;
                        let located      = "system=navigator";
                        let type         = "class_error";
                        ga_error_handle(name , error , located  , type );
                        gatoast.set_toast("Hubo un error del sistema " , "Error del sistema" , gatoast.warning_data);
                        break;
                }

            });


        },

        modal : function() {

            let form = $("#form-render-tree");

            if(form.children().length <= 0 )
            {
                alert("Seleccione un nodo");
                return;
            }

            $("#del-modal").html($("#del-modal").html().replace("{nav-name}" , $("#name").val() ))
            $('#nav-message').modal();
        } ,

        delete : function()
        {

            $('#nav-message').modal('hide');
           ga_request({
               'function'   : 'Delete',
               dir          : 'system' ,
               model        : 'navigator'
           } , {
               id : $("#node-id").val()
           } , (a)=>{

               let y = a;
               a = parseInt(a);
               switch(a)
               {
                   case 0:
                       $("#nav-message-alert").modal();
                       break;
                   case 1:
                       ga_(ga_tools.current_url().url  , ga_tools.current_url().name);
                       break;
                   default:
                       let name         = "Error al tratar de eliminar un elemento del menu navegacion";
                       let error        = y;
                       let located      = "system=navigator";
                       let type         = "class_error";
                       ga_error_handle(name , error , located  , type );
                       break;
               }


           });
        },

        get_navs : function()
        {
            let data = $("#data_navs").val();
            return data.split(",");
        },

        get_navType : function(type = 'section')
        {
            var data       = JSON.parse($("#data_tree").val());
            var l          = this.get_lang();
            switch(type )
            {
                case 'section':
                    return $.map(data , function(a){
                         return { id : a.id , name : a.name[l]   }
                    });
                    break;
                case 'sidebar':
                    return $.map(data , function(a){
                        let k = this.navigator_.recursive_sidebar(a, l) ;
                        if(k !=null) return k;
                    });
                    break;
            }
        },

        recursive_sidebar : function(a , lang)
        {
            if(a.sections.length >= 1)
            {
                return $.map(a.sections , (s)=>{
                    let name = '';
                    if( typeof s.name[lang] == 'undefined')
                    {
                        let enc = JSON.parse(s.name);
                        name = enc[lang];
                    }else name = s.name[lang];
                    return { id: s.id , name : name};
                });
            }
            else return null;
        },

        get_lang : function()
        {
            return $("#lang").val();
        },

        get_sub_menu : function(func)
        {
            ga_request({
                func : 'get_sub_menus',
                dir  : 'system',
                model : 'navigator'
            } , {} , func );
        }
 };
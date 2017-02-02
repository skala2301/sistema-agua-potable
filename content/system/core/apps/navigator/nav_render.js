'use strict';

//important SYSTEMJS 
export var p = 5;

/**
 * carga de NavRender para el sistema de navigation.
 * **/

var org_data        = [];
var navtypes        = [];

NavRender = React.createClass({
    
    getInitialState: function() {
        return this.loadVars(this.props , true);
    },
    
    loadVars : function(props , r = false )
    {

        let node = props.node[0];

        if(node.components == '"{}"') node.comments = '{}';

        let data = {
             name           : typeof  node.name == 'object' ? JSON.stringify( node.name) :  node.name,
             components     : typeof  node.name == 'object' ? JSON.stringify( node.components) :  node.components,
             type           : node.type,
             objects        : node.objects,
             location       : node.location ,
             route          : node.route ,
             parent         : node.parent ,
             active         : node.active ,
             origins        : node.origins ,
             token          : node.token
        };
    
        if(!r){
            this.setState(data);
        }
        else
            return data;
    },
    

    componentWillMount : function()
    {

    },
    
    componentWillReceiveProps(nextProps) {
        this.loadVars(nextProps);
    },
    
    componentWillUpdate: function(nextProps, nextState){

    },
    
    shouldComponentUpdate: function(nextProps, nextState)
    {
        return true;
    },

     componentDidMount: function()
    {
        $("#privs-loaders").select2(); 
        $("#privs-loaders").prop("disabled", true);
        $("#save-tree-info").attr("disabled" , "disabled");
    },
    
    handleChange(e) {
       this.setState({[e.target.name] : e.target.value}, function () {
           //console.log(this.state.name);
        });
    },    


    render : function () {
        

        let node    = this.props.node[0];
        let privs   = JSON.parse($("#data_privs").val());
      
        let name            =  node.name;

        try{
            org_data            =  node.privs.split(",") ;
        }
        catch(e){
            org_data            =  [] ;
        }

        if(typeof name === 'object')
        {
            name = JSON.stringify(name);
        }
        
        try{
             $("#privs-loaders").select2({
              allowClear: true
            }) ; 
        }catch(e){}
        
        
        let data_privs = [];
        data_privs =  $.map(privs , (m)=>{  return <option value={m.id}>{m.name}</option>;   });

      $.each(org_data , (k,h)=>{  
 
          for(let i = 0 ; i < data_privs.length ; i++) 
          {
               if(h == parseInt(data_privs[i].props.value)){
                  data_privs[i].props.selected = true;
              }
          }
       });

        let navtypes    = $("#data_navs").val().split(",");
        let dt          = $.map(navtypes , (a)=>{
            if(this.props.node[0].type == a){

                return (<option selected value={a}>{a}</option>);
            }
            else
            {
                return (<option value={a}>{a}</option>);
            }
        });

       return(
           <div id="data-render" className="form-body">

               <div className="form-group form-md-line-input">
                   <label className="col-md-4 control-label" >
                       ID
                   </label>
                   <div className="col-md-8">
                       <input disabled
                              style={{"font-weight" : "bold" }}
                              type="text"
                              className="form-control"
                              value={node.id}
                              placeholder=""
                              id="node-id" name="id"/>
                   </div>
               </div>

               <div className="form-group form-md-line-input">
                   <label className="col-md-4 control-label" >
                      Nombre Asignado
                   </label>
                   <div className="col-md-8">
                       <input id="name"  disabled type="text" className="form-control" value={this.state.name}  onChange={this.handleChange} placeholder="" name="name" />
                       <div className="form-control-focus"> </div>
                       <span className="help-block">Nombre asignado puede contener un formato JSON</span>
                   </div>
               </div>

               <div className="form-group form-md-line-input">
                   <label className="col-md-4 control-label" >
                       Componentes
                   </label>
                   <div className="col-md-8">
                       <input name="components" id="components"  disabled  type="text" className="form-control" onChange={this.handleChange} value={this.state.components} placeholder="" />
                       <div className="form-control-focus"> </div>
                       <span className="help-block">Componentes en formato JSON</span>
                   </div>
               </div>
               
               
                <div className="form-group form-md-line-input">
                   <label className="col-md-4 control-label" >
                      Objetos
                   </label>
                   <div className="col-md-8">
                       <input   disabled type="text" className="form-control" value={this.state.objects} name="objects" id="objects" onChange={this.handleChange} placeholder="" />
                       <div className="form-control-focus"> </div>
                       <span className="help-block">Objetos declarados JSON</span>
                   </div>
               </div>
               
               <div className="form-group form-md-line-input">
                   <label className="col-md-4 control-label" >
                      Locación
                   </label>
                   <div className="col-md-8">
                       <input   disabled type="text" className="form-control" value={this.state.location} onChange={this.handleChange} name="location" id="location" placeholder="" />
                       <div className="form-control-focus"> </div>
                       <span className="help-block">Nombre del MVA </span>
                   </div>
               </div>
               
                 
               <div className="form-group form-md-line-input">
                   <label className="col-md-4 control-label" >
                      Ruta 
                   </label>
                   <div className="col-md-8">
                       <input onChange={this.handleChange} id="route" name="route"   disabled type="text" className="form-control" value={this.state.route} placeholder="" />
                       <div className="form-control-focus"> </div>
                       <span className="help-block">Ruta Generada </span>
                   </div>
               </div>
               
                <div className="form-group form-md-line-input">
                   <label className="col-md-4 control-label" >
                      Nav Padre 
                   </label>
                   <div className="col-md-8">
                       <input  disabled type="text" className="form-control" name="parent" id="parent" onChange={this.handleChange} value={this.state.parent} placeholder="" />
                       <div className="form-control-focus"> </div>
                       <span className="help-block"></span>
                   </div>
               </div>
               
               
                
                <div className="form-group form-md-line-input">
                   <label className="col-md-4 control-label" >
                      Estado del navegador
                   </label>
                   <div className="col-md-8">
                       <input onChange={this.handleChange} name="active" id="active"   disabled type="text" className="form-control" value={this.state.active} placeholder="" />
                       <div className="form-control-focus"> </div>
                       <span className="help-block"></span>
                   </div>
               </div>
               
                <div className="form-group form-md-line-input">
                   <label className="col-md-4 control-label" >
                        Tipo de nav
                   </label>
                   <div className="col-md-8">
                   <div >
                        <select name="nav_type" id="nav_type" disabled   className="form-control" >
                            {dt}
                        </select>
                    </div>
                   </div>
               </div>
               
                
                <div className="form-group form-md-line-input">
                   <label className="col-md-4 control-label" >
                        Privilegios
                   </label>
                   <div className="col-md-8">
                   <div >
                        <select name="privs-loaders"  disabled id='privs-loaders'  className="form-control" multiple="multiple">
                              {data_privs}
                        </select>
                    </div>
                   </div>
               </div>
               
               
                <div className="form-group form-md-line-input">
                   <label className="col-md-4 control-label" >
                        Origen
                   </label>
                   <div className="col-md-8">
                       <input onChange={this.handleChange} name="origins" id="origins"   disabled type="text" className="form-control" value={this.state.origins} placeholder="" />
                       <div className="form-control-focus"> </div>
                       <span className="help-block"></span>
                   </div>
               </div>
               
               
                <div className="form-group form-md-line-input">
                   <label  className="col-md-4 control-label" >
                        Token
                   </label>
                   <div className="col-md-8">
                       <input onChange={this.handleChange} name="token" id="token" disabled  type="text" className="form-control" value={this.state.token} placeholder="" />
                       <div className="form-control-focus"> </div>
                       <span className="help-block"></span>
                   </div>
               </div>
            </div>
       );
    }
});


NavNewRender = React.createClass({


    getInitialState : function()
    {

        return {
             nav_types : navigator_.get_navs(),
             target : null
        };
    },


    nav_select : function(e)
    {

        let target = e.target.value;
        this.state.target = target;
        if(target == 'namespace' || target == 'sub_menu'){
            $("#group_tree").attr("style" , "display:none;" );
            $("#group_tree_options").attr("style" , "display:inline;" );
            get_system_langs(function(data){
                ReactDOM.render(
                    < NavTreeOpt target={target} ParentId={null} langs={data}   /> ,
                    document.getElementById("group_tree_options"));
            });
        }
        else {
            $("#group_tree").attr("style" , "display:inline;" );
            $("#group_tree").find("label").html("Donde colocara <b>el/la</b> " + target );

            let data = navigator_.get_navType(target);

            ReactDOM.render(
                < NavTree target = {target} data = {data} /> ,
                document.getElementById("nav_tree_render"));
        }
    },


    componentDidMount: function () {

        var self = this;
       $("#form-save-nav").submit(function (event) {
            navigator_.save(this , self.state.target);
            event.preventDefault();
        });
    },


    render : function(){

        let nav_data_render =   $.map(this.state.nav_types , function(k){
            return (<option value={k}>{k}</option>);
        });


        return ( <div className="portlet box ">
            <div className="portlet-title">
                <div className="caption"></div>
                <div className="tools">
                    <a href="javascript:;" classNameName="collapse" data-original-title="" title=""> </a>
                    <a href="#portlet-config" data-toggle="modal" classNameName="config" data-original-title="" title=""> </a>
                    <a href="javascript:;" classNameName="reload" data-original-title="" title=""> </a>
                    <a href="javascript:;" className="remove" data-original-title="" title=""> </a>
                </div>
            </div>
            <div className="portlet-body form">
                <form action="#" method="POST" id="form-save-nav" className="form-horizontal">
                    <div className="form-body">
                        <div className="form-group">
                            <label className="col-md-3 control-label">Tipo</label>
                            <div className="col-md-4">
                                <select onChange={this.nav_select} className="form-control">
                                    <option selected="-1">Seleccione un navegador</option>
                                    { nav_data_render}
                                </select>
                                <span  className="help-block">Seleccion el tipo de nav a crear </span>
                            </div>
                        </div>
                        <div id="group_tree" style={ {'display' : 'none'  } } className="form-group">
                            <label className="col-md-3 control-label"></label>
                        <div  id="nav_tree_render" className="col-md-4" >
                            <ul>

                            </ul>
                        </div>
                        </div>
                        <div id="group_tree_options" style={ {'display' : 'none'  } } className="form-group">

                        </div>

                        <div id="save-data" style={{'display' : 'none'}} className="form-actions top">
                            <div className="row">
                                <div className="col-md-offset-3 col-md-9">
                                    <button type="submit" className="btn green">Guardar</button>
                                    &nbsp;
                                    <button type="button" className="btn default">Cancelar</button>
                                </div>
                                <div className="col-md-12">
                                    <br></br>
                                    <div id="error-message" style={{"text-align" : "center" , "display" : "none"}} className="m-heading-1 border-green m-bordered">
                                        <h3>Existen uno o más campos que son obligatorios. </h3>
                                        <h4>Favor Llenar esos campos requeridos.</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>);
    }

});


var NavTree = React.createClass({

    componentDidMount:function()
    {

        /**
         * luego del render ¿?
         * ***/

        if(!$("#nav_tree_render").hasClass("jstree")){
            $("#nav_tree_render").jstree({
                'core' : {
                    'check_callback' : true
                }
            });
        }

        var that = this;
        $.map(this.state.cid , (a)=>{
            $("#id-" + a + '_anchor').on("click" , function(){
                that.handleClick(a);
            });
        });

    },

    componentWillUpdate: function(nextProps, nextState){
        //si el dom virtual ya existen nodos , actualizamos jstree
        $('#nav_tree_render').jstree(true);
    },


    getInitialState : function()
    {
        return {
            cid : []
        };
    },


    sections : function(){

        var that = this;
        let k = $.map(this.props.data , function(h){

            that.state.cid.push(h.id);

            return (<ul>
                        <li id={'id-' + h.id } >{h.name}</li>
                    </ul>);
        });

        return k;
    },

    sidebars: function()
    {
        var that = this;
        let k = $.map(this.props.data , function(h){
            that.state.cid.push(h.id);
            return (<ul data-jstree="{ 'icon' : 'fa fa-file icon-state-success' , 'opened' : 'true' }">
                <li  id={'id-' + h.id } >{h.name}</li>
            </ul>);
        });

        return k;
    },

    handleClick : function(a)
    {
        $("#group_tree_options").attr("style" , "display:inline;" );
        var self = this;
        get_system_langs(function(data){
            ReactDOM.render(
                < NavTreeOpt target={self.props.target} ParentId={a} langs={data}   /> ,
                document.getElementById("group_tree_options"));
        });


    },

    render : function () {

        let data_selected = null;


        /**
         * importante
         * se encesita destruir los nodos de JSTREE ya que el reflesh no funciona
         * asi que verificamos si existe la clase jstree , en dado caso exista
         * destruimos los nodos del DOM pero no del DOMVIRTUAL
         * **/
        if($("#nav_tree_render").hasClass("jstree")){
            $("#nav_tree_render").jstree('destroy');
        }

        switch(this.props.target.trim(""))
        {
            case 'section':
                data_selected = this.sections();
                break;
            case 'sidebar' :
                data_selected = this.sidebars();
                break;
            default:
                $("#group_tree").attr("style", "display:none");
                $("#group_tree_options").attr("style" , "display:inline;" );
                return (<div></div>);
        }

        return (<ul>
            <li data-jstree='{ "selected" : true , "opened" : true }'>
                RAIZ
                {data_selected}
            </li>
        </ul>)

    }

});


var NavTreeOpt = React.createClass({


    getInitialState: function () {
        return {
            namespace: {
                parent: false,
                location: false,
                route: false
            },
            section: {
                parent: true,
                location: false,
                route: false
            },
            sidebar: {
                parent: true,
                location: true,
                route: true
            },
            sub_menu :
            {
                parent: false,
                location: true,
                route: true
            },
            directories: null
        }

    },


    componentWillMount: function () {

    },


    componentDidMount: function () {
        $("#txt-privs").select2();
        $("#save-data").attr("style" , "display:block;")
    },


    lang: function () {
        return $.map(this.props.langs, function (k, a) {
            return (
                <div className="col-md-4">
                    <div className="input-group">
                  <span className="input-group-addon">
                          <i className="fa fa-language"></i>
                  </span>
                        <input name="txt-langs[]" id={a} type="text" className="form-control" placeholder={k}/></div>
                </div>
            );
        });
    },

    privs: function ()
    {
        let privs   = JSON.parse($("#data_privs").val());
        return $.map(privs , (m)=>{  return <option value={m.id}>{m.name}</option>;   });
    },


    render : function(){

        var target      = this.props.target;
        var languages   = this.lang();
        var privileges  = this.privs();

        return (
            <div className="form-group">
                    <div
                        style={ this.state[target].parent == true ? {'display' : 'inline'} : { 'display' : 'none'} }
                        className="form-group">

                        <label className="col-md-3 control-label">Codigo Padre</label>
                        <div className="col-md-4">
                                <input
                                    style={{
                                        'border-color': 'red',
                                        'border-style': 'dashed',
                                        'color': 'blue',
                                        'background-color': 'antiquewhite'
                                    }}
                                    disabled=""
                                    name="txt-parent-id" id="txt-parent-id"  type="text" className="form-control " value={this.props.ParentId} />
                        </div>

                    </div>
                    <div className="form-group">
                        <label className="col-md-3 control-label">Idiomas detectados</label>
                        {languages}
                    </div>
                <div
                    style={ this.state[target].location == true ? {'display' : 'inline'} : { 'display' : 'none'} }
                    className="form-group">
                    <label className="col-md-3 control-label">Locacion del script </label>
                    <div className="col-md-4">
                        <input placeholder="directorio=archivo" name="txt-location" id="txt-location"  type="text" className="form-control "  />
                    </div>

                </div>
                <div
                    style={ this.state[target].route == true ? {'display' : 'inline'} : { 'display' : 'none'} }
                    className="form-group">
                    <label className="col-md-3 control-label"> Ruta (Opcional) </label>
                    <div className="col-md-4">
                        <input placeholder="directorio=archivo" name="txt-route" id="txt-route"  type="text" className="form-control "  />
                    </div>

                </div>

                <div
                    className="form-group">
                    <label className="col-md-3 control-label"> Icono </label>
                    <div className="col-md-4">
                        <input placeholder="fa fa-example" name="txt-icon" id="txt-icon"  type="text" className="form-control "  />
                    </div>
                </div>

                <div
                    className="form-group">
                    <label className="col-md-3 control-label"> Redireccion (Opcional)</label>
                    <div className="col-md-4">
                        <input placeholder="" name="txt-redirect" id="txt-redirect"  type="text" className="form-control "  />
                    </div>
                </div>

                <div
                    className="form-group">
                    <label className="col-md-3 control-label"> Target (Opcional) </label>
                    <div className="col-md-4">
                        <input placeholder="_blank ?" name="txt-target" id="txt-target"  type="text" className="form-control "  />
                    </div>
                </div>

                <div
                    className="form-group">
                    <label className="col-md-3 control-label"> Ubicacion (Opcional) </label>
                    <div className="col-md-4">
                        <input placeholder="2 or 1 or 3 ... numero" name="txt-place" id="txt-place"  type="number" className="form-control "  />
                    </div>
                </div>

                <div
                    className="form-group">
                    <label className="col-md-3 control-label"> Divisor Horizontal  </label>
                    <div className="col-md-4">
                       <select id="txt-divider" className="form-control " name="txt-divider">
                           <option value="0" selected="">No agregar divisor horizontal </option>
                           <option value="1" >Si agregar divisor horizontal </option>
                       </select>
                    </div>
                </div>

                <div
                    className="form-group">
                    <label className="col-md-3 control-label">Componentes (Opcional)</label>
                    <div className="col-md-4">
                            <textarea id="txt-components" name="txt-components" className="form-control" rows="4">  </textarea>
                    </div>
                </div>

                <div
                    className="form-group">
                    <label className="col-md-3 control-label">Origen</label>
                    <div className="col-md-4">
                        <select id="txt-origin" className="form-control " name="txt-origin">
                            <option value="system" selected="">Sistema </option>
                            <option value="app" >Aplicacion </option>
                            <option value="third" >Terceros </option>
                            <option value="test" >Prueba</option>
                        </select>
                    </div>
                </div>


                <div
                    className="form-group">
                    <label className="col-md-3 control-label">Privilegios</label>
                    <div className="col-md-4">
                        <select id="txt-privs" name="txt-privs" className="form-control"  multiple="multiple" >
                            {privileges}
                        </select>
                    </div>
                </div>

                <div
                    className="form-group">
                    <label className="col-md-3 control-label"> Token </label>
                    <div className="col-md-4">
                        <input value={Math.random().toString(36).substring(7)}  name="txt-token" id="txt-token"  type="text" className="form-control "  />
                    </div>
                </div>

            </div>

        );
    }

});


Sub_Menu_Render = React.createClass({

    getInitialState : function()
    {
       return {
           sub_menus : null,
           lang : $("#ga_lang").val()
       };
    },

    componentWillMount : function()
    {
       this.get_request();
    },

    componentWillUpdate : function(a,b)
    {
        this.get_request();
    },


    get_request : function()
    {
        var that = this;
        navigator_.get_sub_menu(function(data){
                 try {
                     that.setState({
                         sub_menus: JSON.parse(data)
                     });
                 }catch(ex){
                      console.log("---------- ERROR MESSAGE -----------------");
                      console.log(ex);
                      console.log("-------------- DATA GET  -------------------");
                      //console.log(data);
                 }
        });
    },

    edit_click : function()
    {
        navigator_.edit('sub_render_form');
        $("#trash-tree-info-sub").removeAttr("disabled");
        $("#save-tree-info-sub").removeAttr("disabled");
    },

    sub_select : function(event)
    {
        let target = event.target.value;
        navigator_.tree_show(target , 'sub_menu' , 'sub_render_form');
        $("#trash-tree-info-sub").attr("disabled" , "disabled");
        $("#save-tree-info-sub").attr("disabled" , "disabled");
    },

    save_node : function(){
        navigator_.saveEdit();
    },

    delete_node : function(){
        navigator_.delete();
    },

    render : function () {

        var that = this;

        let subs = $.map(this.state.sub_menus , function(a,k){

             let lang_name = JSON.parse(a.name);
             let name =  lang_name[that.state.lang];
             return (<option value={a.id}>{name}</option>);
        });

        return (
            <div  id="form-save_sub_menu" className="form-horizontal">
                <div className="form-body">
                    <div className="form-group">
                        <br></br>
                        <br></br>
                        <label className="col-md-3 control-label"></label>
                        <div className="col-md-4">
                            <select onChange={this.sub_select} className="form-control">
                                <option selected="-1">Seleccione un Sub-Menú</option>
                                { subs}
                            </select>
                            <span  className="help-block">Seleccione el sub menu a ver</span>
                        </div>
                    </div>
                   </div>
                <div className="col-md-12">
                    <div className="portlet light portlet-fit portlet-form bordered">
                        <div className="portlet-title">
                            <div className="caption">
                                <i className=" icon-layers font-green"></i>
                                <span id="tree-title-sub" class="caption-subject font-green sbold uppercase">
                                    Información
                                </span>
                            </div>
                            <div className="actions">
                                <a id="save-tree-info-sub "
                                   onClick={this.save_node}
                                   disabled="disabled"
                                   className="btn btn-circle btn-icon-only btn-default"
                                   href="javascript:;">
                                    <i className="fa fa-save"></i>
                                </a>
                                <a onClick={this.edit_click}
                                   className="btn btn-circle btn-icon-only btn-default"
                                   href="javascript:;">
                                    <i className="icon-wrench"></i>
                                </a>
                                <a id="trash-tree-info-sub"
                                   disabled="disabled"
                                   onClick={this.delete_node}
                                   className="btn btn-circle btn-icon-only btn-default"
                                   href="javascript:;">
                                    <i className="icon-trash"></i>
                                </a>
                            </div>
                        </div>
                        <div className="portlet-body">

                            <form action="#"
                                  className="form-horizontal"
                                  id="sub_render_form"
                                  novalidate="novalidate">

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        );
    }

});


var Sub_Menu_Select = React.createClass({

    getInitialState : function()
    {
        return {};
    },


    render : function()
    {
        return (<div></div>);
    }


});

//(function(){})(window , document);






  


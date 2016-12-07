'use strict';

//important SYSTEMJS 
export var p = 5;

/**
 * carga de NavRender para el sistema de navigation.
 * **/

var org_data = [];

NavRender = React.createClass({
    

    componentWillMount : function()
    {
      
    },

     componentDidMount: function()
    {
   
       
        $("#privs-loaders").select2(); 
        
    },

    render : function () {

        if(Object.keys(this.props).length === 0 && this.props.constructor === Object)
        {
            return (<div>
                <div className="alert alert-success">
                    Seleccione un nodo !!
                </div>
            </div>);
        }

        let node    = this.props.node[0];
        let privs   = this.props.privileges;
      
        let name            =  node.name;
        org_data            = node.privs.split(",");

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
        data_privs =   $.map(privs , (m)=>{
                                    
                                  /*  let j = null;
                                    j = $.map(current_privs , (h)=>{
                                         if(h == m.id) return (<option selected value={m.id}>{m.name}</option>);
                                         else return (<option value={m.id}>{m.name}</option>);
                                    });*/
          
                                    return <option value={m.id}>{m.name}</option>;
                                    
                           });
        
       

       return(
           <div className="form-body">

               <div className="form-group form-md-line-input">
                   <label className="col-md-4 control-label" >
                       ID
                   </label>
                   <div className="col-md-8">
                       <input disabled=""
                              style={ {"font-weight" : "bold" }}
                              type="text"
                              className="form-control"
                              value={node.id}
                              placeholder=""
                              id="node-id"/>
                   </div>
               </div>

               <div className="form-group form-md-line-input">
                   <label className="col-md-4 control-label" >
                      Nombre Asignado
                   </label>
                   <div className="col-md-8">
                       <input type="text" className="form-control" value={name} placeholder="" name="name" />
                       <div className="form-control-focus"> </div>
                       <span className="help-block">Nombre asignado puede contener un formato JSON</span>
                   </div>
               </div>

               <div className="form-group form-md-line-input">
                   <label className="col-md-4 control-label" >
                       Componentes
                   </label>
                   <div className="col-md-8">
                       <input type="text" className="form-control" value={node.components} placeholder="" />
                       <div className="form-control-focus"> </div>
                       <span className="help-block">Componentes en formato JSON</span>
                   </div>
               </div>
               
               
                <div className="form-group form-md-line-input">
                   <label className="col-md-4 control-label" >
                      Objetos
                   </label>
                   <div className="col-md-8">
                       <input type="text" className="form-control" value={node.objects} placeholder="" />
                       <div className="form-control-focus"> </div>
                       <span className="help-block">Objetos declarados JSON</span>
                   </div>
               </div>
               
               <div className="form-group form-md-line-input">
                   <label className="col-md-4 control-label" >
                      Locación
                   </label>
                   <div className="col-md-8">
                       <input type="text" className="form-control" value={node.location} placeholder="" />
                       <div className="form-control-focus"> </div>
                       <span className="help-block">Nombre del MVA </span>
                   </div>
               </div>
               
                 
               <div className="form-group form-md-line-input">
                   <label className="col-md-4 control-label" >
                      Ruta 
                   </label>
                   <div className="col-md-8">
                       <input type="text" className="form-control" value={node.route} placeholder="" />
                       <div className="form-control-focus"> </div>
                       <span className="help-block">Ruta Generada </span>
                   </div>
               </div>
               
                <div className="form-group form-md-line-input">
                   <label className="col-md-4 control-label" >
                      Nav Padre 
                   </label>
                   <div className="col-md-8">
                       <input type="text" className="form-control" value={node.parent} placeholder="" />
                       <div className="form-control-focus"> </div>
                       <span className="help-block"></span>
                   </div>
               </div>
               
               
                
                <div className="form-group form-md-line-input">
                   <label className="col-md-4 control-label" >
                      Estado del navegador
                   </label>
                   <div className="col-md-8">
                       <input type="text" className="form-control" value={node.active} placeholder="" />
                       <div className="form-control-focus"> </div>
                       <span className="help-block"></span>
                   </div>
               </div>
               
                
                <div className="form-group form-md-line-input">
                   <label className="col-md-4 control-label" >
                        Privilegios
                   </label>
                   <div className="col-md-8">
                   <div >
                        <select id='privs-loaders'  className="form-control" multiple="multiple">
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
                       <input type="text" className="form-control" value={node.origins} placeholder="" />
                       <div className="form-control-focus"> </div>
                       <span className="help-block"></span>
                   </div>
               </div>
               
               
                <div className="form-group form-md-line-input">
                   <label className="col-md-4 control-label" >
                        Token
                   </label>
                   <div className="col-md-8">
                       <input type="text" className="form-control" value={node.token} placeholder="" />
                       <div className="form-control-focus"> </div>
                       <span className="help-block"></span>
                   </div>
               </div>
            </div>
       );
    }
});




  


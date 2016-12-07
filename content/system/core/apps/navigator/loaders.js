

    /**objeto navigator_ encargado de la manipulacion en carga***/
    var navigator_ = {

        load : ()=> {
            $("#nav_tree").jstree();

            $('#nav_tree').on("", function (e, data) {
                console.log(data.selected);
            });
         
        },

        tree_show : (id , type) =>
        {
             var data       = JSON.parse($("#data_tree").val());
             let result     = navigator_.recursive_tree(data , id , type );
             let privs      = JSON.parse($("#data_privs").val());
             
             //llamado a renderizar desde JS 
             ReactDOM.render(
                 React.createElement(NavRender , { node : result , privileges : privs}),
                 document.getElementById("form-render-tree")
             );
     
          
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
        }

 };
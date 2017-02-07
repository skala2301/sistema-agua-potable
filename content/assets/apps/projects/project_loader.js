
var project_data =
{

    exist_project : (name  , func) => {
        ga_request({
            dir : "projects",
            model : "create_project",
            func : "exist_project"
        } , {
            data : name
        } , func );
    },


    create_project: (name , active = null , func ) => {

        let a = 0 ;
        if(active == true ) a = 1;

        ga_request({
            dir : "projects",
            model : "create_project",
            func : "new_project"
        } , {
            name : name,
            active : a
        } , func );
    },

    loaders : () =>{

        $("#create_new_project").click(function () {
            let name = $("#txt-project").val();
            project_data.exist_project(name , function (data) {



                var toast = new ga_toast();
                toast.config();

                if(data === "")
                {
                    toast.set_toast("Error al procesar la data" , "Error" , toast.warning_data);
                    $("#research").html("Error al momento de procesar la data.").css({"opacity": "1"});
                    return false ;
                }


                data = JSON.parse(data);



                if(data.result >= 1)
                {
                    toast.set_toast("Poryecto ya existente" , "" , toast.warning_data);
                    $("#research").html("Ya existe un proyecto con este nombre").css({"opacity": "1"});
                    return false ;
                }


                let name            = $("#txt-project").val();
                let active          = $("#txt-new-active").prop("checked");



                project_data.create_project(name , active , function (result) {

                        console.log(result);

                        var toast = new ga_toast();
                        toast.config();

                       if(result === ''){
                           toast.set_toast("Error al momento de crear el proyecto" , "" , toast.warning_data);
                           return false;
                       }


                       result = JSON.parse(result);

                       if(result.result == true ){



                       }else{
                           toast.set_toast("No se pudo crear el proyecto , intente denuevo mas tarde." , "" , toast.warning_data);
                       }

                       return true;

                });


            });
        });

    }

};
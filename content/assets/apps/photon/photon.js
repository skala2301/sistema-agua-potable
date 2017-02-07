/**
 * Created by rolandoarriaza on 4/2/17.
 */


var photon_ = {

    init : () => {

        $("#create_new_").click(function () {


            let name = $("#txt-new-element").val();


            if(name == '' || name == 'undefined' || name == null  )
            {
               alert("ingresar el nombre de su paquete");
               return;
            }


            photon_.is_package(name , function (result) {



                gatoast = new ga_toast();
                gatoast.config();

                if(result === '') {
                    gatoast.set_toast("Hubo un error al procesar la peticion [intente denuevo]" , "Error" , gatoast.warning_data);
                    return true ;
                }

                try{

                    result = JSON.parse(result);
                    switch (result.status){
                        case true:
                            gatoast.set_toast("Este Nombre ya ha esta utilizado" , "Error" , gatoast.warning_data);
                            $("#txt-new-element").attr("style" , "border: red solid 1px;");
                            return false;
                        case false :

                            $("#device_name").val(result.name);

                            break;
                    }

                }catch(ex){

                    ga_error_handle("Error / is_package" , JSON.stringify(ex) , "../photon.js");

                }


                ReactDOM.render( React.createElement(PhotonInsert,{})
                    , document.getElementById("render_view")
                );

            });


        });

    },

    is_package : function( name ,  request ){
        ga_request({
            model  : "tools_devices",
            dir : "photon" ,
            func : "find_packages"
        } , {
            "package" : name
        } , request );

        return false ;
    }


};

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


            ga_request({
                location : "tools_devices",
                dir : "photon" ,
                func : ""
            } , {
                "package" : name
            } , function (result) {


                $("#device_name").val(name);

                ReactDOM.render( React.createElement(PhotonInsert,{})
                    , document.getElementById("render_view")
                );

            });




        });

    }


};

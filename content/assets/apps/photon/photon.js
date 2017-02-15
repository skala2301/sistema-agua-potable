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
                            break;
                    }

                }catch(ex){

                    ga_error_handle("Error / is_package" , JSON.stringify(ex) , "../photon.js");

                }


                ReactDOM.render( React.createElement(PhotonInsert,{
                         package :  result.name
                    })
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
    },
    
    create : function ($form) {

        var status = true ;
        var toast_ = new ga_toast();
        toast_.config();


        $($form).find("input,select").each(function () {

            let block = {
                "photon-project"        : true  ,
                "photon-token"          : true
            };


            let name =  $(this).attr("name");
            let val  =  $(this).val();


            if(block[name] !== undefined && block[name] == true && val == "" || val == "-1" ){
                status = false;
                $(this).attr("style" , "border:3px solid red;");
            }else{
                $(this).attr("style" , "border:1px solid #ccc");
            }


        });


        if(status == false ){
            toast_.set_toast("Existen campos requeridos" , "Requeridos (*)" , toast_.warning_data);
            return;
        }



        let serialize           = $($form).serialize();
        var l                   = Ladda.create($($form).find("button")[0]);
        var table               = $("#data-device").find("tbody").find("tr");
        l.start();


        var device_data = [];
        $(table).each(function () {

            if($(this).attr("name")!= "disabled") {

                try {
                    let c = $(this).find("td input")[0];
                    let i = $(this).find("td")[1];
                    let n = $(this).find("td")[2];

                    if ($(c).prop("checked")) {
                        device_data.push({
                            "id": $(i).html(),
                            "name": $(n).html()
                        });
                    }

                } catch (ex) {
                    console.log(ex);
                }
            }

        });

        if(device_data.length == 0){
            l.stop();
            toast_.set_toast("todos los dispositivos ya han sido agregados"  ,
                "Dispositivos" , toast_.warning_data);
            return true;
        }


        ga_request({
            model  : "new_device",
            dir : "photon" ,
            func : "create_photon"
        } , {
            "data"      : serialize,
            "pkg"       :  $("#photon-package").val(),
            "device"    : JSON.stringify(device_data)
        } , function (a) {


            try{
                a = JSON.parse(a);

                if(a.status )
                {
                    toast_.set_toast(a.msj , "Habemuss Photon" , toast_.success_data);
                }else{
                    toast_.set_toast(a.msj  , "Opps!!" , toast_.warning_data);
                }

                $($form).find("input").each(function (){
                    let pk = $(this).attr("name");
                    if(pk != 'photon-package')
                        $(this).val("");
                });

            }catch (e){
                toast_.set_toast("Error al momento de procesar"  , "" , toast_.warning_data);
            }

            l.stop();

        } );

    },

    get_devices : function ( device , project   ,$function) {
        ga_request({
            model  : "tools_devices",
            dir : "photon" ,
            func : "find_devices"
        } , {
            device_id : device,
            project   : project
        } ,  $function );
    }

};

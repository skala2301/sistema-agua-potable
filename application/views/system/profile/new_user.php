<div class="row">
    <div class="col-md-12 col-md-offset-0  ">
        <div class="portlet light ">
            <div class="portlet-title tabbable-line">
                <div class="caption caption-md">
                    <i class="icon-globe theme-font hide"></i>
                    <span class="caption-subject font-blue-madison bold uppercase">Nueva Cuenta  </span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="tab-content">
                    <!-- PERSONAL INFO TAB -->
                    <div class="tab-pane active" id="tab_1_1">
                        <form role="form" id="profile_submit" method="post" action="">
                            <div class="form-group">
                                <label class="control-label">Nombres</label>
                                <input name="name"  id="name" type="text" value="" placeholder="Nombres" class="form-control"> </div>
                            <div class="form-group">
                                <label class="control-label">Apellidos</label>
                                <input name="last_name" id="last_name" type="text" value="" placeholder="Apellidos" class="form-control"> </div>
                            <div class="form-group ">
                                <label class="control-label">Usuario</label>
                                <input id="user" name="user" type="text" value="" placeholder="Nombre de usuario" class="form-control data_disabled">
                                <span style="display:none;" id="umsj" class="help-block"> Este Usuario ya existe  </span>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Cargo</label>
                                <input id="occupation" name="occupation"
                                       type="text" value=""
                                       placeholder="Cargo que desempeña"
                                       class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Correo Electronico</label>
                                <input name="email" id="email" type="text" value="" placeholder="ejemplo@dominio.com" class="form-control">
                                <span style="display:none;" id="emsj" class="help-block"> Este Correo ya existe  </span>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Rol o privilegio</label>
                                <select id="rols"  class="form-control" >
                                    <option selected  value="-1">Seleccione un rol o privilegio</option>
                                    <?php foreach ($rols as $rol): ?>
                                        <option value="<?php echo $rol->id ?>"><?php echo $rol->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="margiv-top-10">
                                <button disabled id="send_profile" type="button" class="btn green">Crear Cuenta</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>


     var e = { a : 0 , b: 0 };

    (function($) {

            
            var k = {
                
                l : function () {


                    $("#user").keyup(function () {
                        k.g(true);
                    });

                    $("#email").keyup(function () {
                        k.g(false);
                    });


                    $("#last_name").keyup(function () {

                        let as = $("#name").val();
                        let ad = $("#last_name").val();
                        let am = $("#user");

                        if(as !== '' & ad !== '')
                        {
                            let f = Math.floor(99 + Math.random() * 1000);
                            am.val(as.charAt(0).toLowerCase() + ad.charAt(0).toLowerCase()  + f);
                        }
                    });


                    $("#rols").on("change" , function () {
                        $("#send_profile").removeAttr("disabled");
                    });
                    
                    
                    $("#send_profile").click(function () {


                        var toast = new ga_toast();
                        toast.config();

                         ga_request({
                             'function'         : 'save' ,
                             dir                : 'profile' ,
                             model              : 'new_profile'
                         } , {
                             "data" : $("#profile_submit").serialize(),
                             "rol"  : $("#rols").val()
                         }, function (k) {


                             try{

                                 k = JSON.parse(k);

                                 switch (k.status){

                                     case true:
                                         toast.set_toast(k.msj ,  '' );
                                         break;
                                     case false :
                                         toast.set_toast(k.msj , toast.warning_data);
                                         break;

                                 }

                             }catch (e){
                                 ga_error_handle(
                                     "Error en la vista new_user.php ",
                                     JSON.stringify(e),
                                     "view->profile->new_user.php",
                                     "0"
                                 );
                             }
                         });
                    });

                },
                
                g : function (p = true ) {

                    let u = $("#user").val();
                    let c = $("#email").val();

                    ga_request(
                        { 'function': 'check_user' ,
                            dir : 'profile' ,
                            model : 'new_profile'
                        } ,
                        {   "user" : u ,
                            "email" : c
                        } ,
                        function (a) {

                            let z = JSON.parse(a);

                             if(p== true) {

                                 if($("#user").val()== '')
                                 {
                                     $("#umsj").css({"display" : "block"}).html("Usuario vacio");
                                     e.a = 0;
                                 }
                                 else if (z.user) {
                                     $("#umsj").css({"display" : "block"}).html("Este usuario ya existe.");
                                     e.a = 0;
                                 } else if(!z.user) {
                                     $("#umsj").attr("style" , "display:block;").html("Este usuario se puede utilizar.");
                                     e.a = 1;
                                 }

                             }else {

                                 if($("#user").val()== '')
                                 {
                                     $("#emsj").css({"display" : "block"}).html("Correo electronico vacio");
                                     e.b = 0;
                                 }
                                 else if(z.email)
                                 {
                                     $("#emsj").css({"display" : "block"}).html("Correo ya existente ");
                                     e.b = 0;
                                 }else if(!z.email){
                                     $("#emsj").attr("style" , "display:block;").html("Este correo electronico se puede utilizar");
                                     e.b = 1;
                                 }
                             }
                        });
                }
                
            };


            k.l();


    })(this.jQuery);

</script>
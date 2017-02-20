
<style>

    .data_disabled {
        opacity: 0.65;
        cursor: not-allowed;
    }

    .data_disabled:hover {
        border: 1px solid red;
        background-color: transparent;
        filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr=#26759e, endColorstr=#133d5b);
    }

    .data_disabled:hover {
        display: block;
        margin-bottom: 20px;
        text-decoration: none;
        border: 1px solid #25729a;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        color: red;
        filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr=#3093c7, endColorstr=#1c5a85);
    }

</style>

<?php $contant = "Perfil Usuario"; ?>
<?php $departments = [];  ?>
<?php //echo "<pre>" , print_r($datauser) , "</pre>"; ?>
<?php foreach ($users as $user) :?>
    <?php

    $details    = json_decode($user->data)->details;
    $location   = $details->location;
    $departments[$location][] = array(
        "key"       => $user->id ,
        "value"     => $details->name . " " . $details->last_name . " ($user->username)"
    );
    ?>
<?php endforeach; ?>
<div class="row">
<div class="col-md-4">
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-user"></i>
                <span style="color:#80809c;" class="caption-subject  bold uppercase">Seleccione un usuario</span>
            </div>
        </div>
        <div class="portlet-body">
            <div class="form-group">
        <div class="input-group select2-bootstrap-prepend">
            <select id="susers" class="form-control select2-allow-clear">
                    <?php foreach ($departments as $depto=>$value): ?>
                        <?php
                            echo '<optgroup label="' .  $depto . '">';

                                foreach ($value as $data):
                                    $id = $_GET['id'] ?? NULL;
                                    if(!is_null($id) && $id == $data['key']):
                                        echo '<option selected value="' . $data['key'] . '">' . $data['value'] . '</option>';
                                    else :
                                        echo '<option value="' . $data['key'] . '">' . $data['value'] . '</option>';
                                    endif;
                                endforeach;
                            echo '</optgroup>';
                        ?>
                    <?php endforeach; ?>
            </select>
        </div>
    </div>
        </div>
    </div>
</div>
</div>

<?php if(isset($datauser) && $datauser != NULL): ?>
<?php $details = json_decode($datauser->data)->details; ?>
<div id="body-data" style="display: block;" class="row">
    <div class="col-md-4 ">
        <div style="    width: 400px;" class="profile-sidebar">
            <!-- PORTLET MAIN -->
            <div class="portlet light profile-sidebar-portlet ">
                <!-- SIDEBAR USERPIC -->
                <div class="profile-userpic">
                    <img src="<?php echo site_url() . "/content/system/core/img/users/" . $details->avatar ;  ?>" class="img-responsive" alt=""> </div>
                <!-- END SIDEBAR USERPIC -->
                <!-- SIDEBAR USER TITLE -->
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name"> <?php echo $details->name; ?> </div>
                    <div class="profile-usertitle-job"> <?php echo $details->last_name;  ?>  </div>
                </div>
            </div>
            <!-- END PORTLET MAIN -->
            <!-- PORTLET MAIN -->

            <div class="portlet light ">
                <div>

                    <div style="    margin-left: 32%;" class="form-group">
                        <input id="ustatus" <?php echo $datauser->active == true ? 'checked' : ''; ?> type="checkbox" class="make-switch" data-on-text="Activo" data-off-text="Inactivo">
                    </div>

                    <div style="    margin-left: 32%;" class="form-group">
                        <button onclick='$("#now_pass").attr("style" , "display:block");' type="button" id="now_pass_btn" class="btn btn-primary">Conocer contraseña</button>
                        <label id="now_pass" style="display: none;" class="control-label"><b><?php echo $datauser->password ?></b></label>
                    </div>

                </div>
            </div>

            <!-- END PORTLET MAIN -->
        </div>
    </div>
    <div class="col-md-8">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <i class="fa fa-user"></i>
                <span style="color:#80809c;" class="caption-subject  bold uppercase">
                    Ultima conexión el  <?php echo $datauser->last_connect ?>
                </span>
            </div>
            <div class="portlet-body">
                <form id="profile_data" role="form" action="#">
                    <div class="form-group">
                        <label class="control-label">Usuario</label>
                        <input name="user"  type="text" placeholder="" value="<?php echo $datauser->username; ?>" class="form-control data_disabled">
                    </div>
                    <div class="form-group">
                        <label class="control-label">Correo electronico</label>
                        <input name="email"  type="text" placeholder="" value="<?php echo $datauser->email; ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="control-label">Ocupación</label>
                        <input name="occupation" type="text" placeholder="" value="<?php echo $details->occupation; ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="control-label">Departamento</label>
                        <select name="departments" id="departments" class="form-control select2-allow-clear">
                            <option value="">Sin departamento</option>
                            <?php foreach ($deptos as $depto): ?>
                                <?php

                                        if($depto->name == $details->location):
                                            echo '<option selected value="' . $depto->name . '">' .  $depto->name . '</option>';
                                        else:
                                            echo '<option  value="' . $depto->name . '">' .  $depto->name . '</option>';
                                        endif;

                                ?>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Rol o Privilegio</label>
                        <select id="departments" name="rols" class="form-control select2-allow-clear">
                            <option value="">Sin Privilegios </option>
                            <?php foreach ($rols as $rol): ?>
                                <?php

                                if($rol->id == $datauser->privileges->id):
                                    echo '<option selected value="' . $rol->id . '">' .  $rol->name . '</option>';
                                else:
                                    echo '<option  value="' . $rol->id . '">' .  $rol->name . '</option>';
                                endif;

                                ?>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <button id="send_profile" type="submit" class="btn green">Guardar cambios</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>


<?php  endif; ?>

<script>


    var render = function () {





        $("#susers").change(function(){
             // ga_(window.location.href + "/perfil_usuario?id=" + $("#susers").val() , '<?php echo $contant; ?>');
            window.location.href = window.location.origin
                    +  window.location.pathname
                    + "?id=" + $("#susers").val();

        });

        $("#profile_data").unbind().submit(function (e) {

            var r = {  'data' : $(this).serializeArray() , 'i' : '<?php echo $_REQUEST['id']; ?>' } ;
            var that = this;
            $(this).find('button').html("Guardando ...")
            ga_request('save_actions/profile/user_profile' , r , function (a) {

                $(that).find('button').html("Guardar cambios")
                let k = JSON.parse(a);
                switch (k.error)
                {
                    case true:
                        toastr["warning"](k.msj ,"");
                        break;
                    case false:
                        toastr["success"](k.msj ,"");
                        break;
                }


            });

            e.preventDefault();
        });

        $("#ustatus").on('switchChange.bootstrapSwitch', function(event, state) {


            var s = 0;
            if(state) s= 1

            ga_request('save_state/profile/user_profile' , { "state" : s , 'i' : '<?php echo $_REQUEST['id']; ?>' } , function (a) {

                console.log(a);
                let k = JSON.parse(a);
                switch (k.error)
                {
                    case true:
                        toastr["warning"](k.msj ,"");
                        break;
                    case false:
                        toastr["success"](k.msj ,"");
                        break;
                }


            });

        });


    };


    (function($) {


        var init = function () {
            try{
                $.fn.select2.defaults.set( "theme", "bootstrap" );


                $("#susers , #departments").select2({
                    theme: "bootstrap"
                });

                $("#ustatus").bootstrapSwitch("toggleRadioState");


                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": true,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": true,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };

            }catch (ex){

            }
        };

        render();
        init();
    })(this.jQuery);
    




</script>



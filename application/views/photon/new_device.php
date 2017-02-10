[PageBar ; {"name":"Home" , "url":"<?php echo dashboard_url(); ?>"}, {"name" : "Photon" , "url" : ""} , {"name" : "Nuevo_Dispositivo"} ]

<style>

    .small-request{
        margin-left: 20% !important;
        margin-right: 33% !important;
        margin-top: 10% !important;
    }

</style>

<h3 class="page-title">Nuevo Dispositivo/Elemento
    <small>(Version 1.0.0)</small>
</h3>

<input type="hidden" value="" id="device_name" >


<div id="render_view" class="row">

<div class="col-md-12">

    <div class="portlet light bordered small-request">
    <div class="form-group form-md-line-input">
        <input type="text" class="form-control" id="txt-new-element" placeholder="Nombre del paquete ej: photon.package">
        <span class="help-block">El nombre con el que se identificara el paquete de tu proyecto </span>

    </div>

        <div class="form-group " style="text-align: center;margin-top: 7%;">
            <button id="create_new_" class="btn btn-primary " type="button">Crear Paquete</button>
        </div>


    </div>

</div>
</div>



<script>

    /* modo no asincrono entrada por htpp* **/
    $(document).ready(()=>{
        if(document.readyState)
                photon_.init();
    });

    /** carga modo asincrono XHR**/
    (function($) {
        try{

            if(document.addEventListener && !document.readyState)
            {
                photon_.init();
            }

        }
        catch (ex){
            console.log(ex);
        }

    })(this.jQuery);






</script>
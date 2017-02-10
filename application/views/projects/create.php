[PageBar ; {"name":"Home" , "url":"<?php echo dashboard_url(); ?>"}, {"name" : "Proyectos" , "url" : ""} , {"name" : "Crear"} ]



<style>

    .small-request{
        margin-left: 20% !important;
        margin-right: 33% !important;
        margin-top: 10% !important;
    }

</style>

<h3 class="page-title">Crear Proyecto
    <small>(Version 1.0.0)</small>
</h3>

<input type="hidden" value="" id="device_name" >


<div id="render_view" class="row">

    <div class="col-md-12">

        <div id="_render" class="portlet light bordered small-request">

            <div class="form-group form-md-line-input">
                <input type="text" class="form-control" id="txt-project" placeholder="Nombre del proyecto ">
                <span id="research" class="help-block"></span>
                <div class="form-group">
                    <div style="margin:6%;" class="icheck-inline">
                        <input checked type="checkbox" class="form-control" id="txt-new-active">
                        <span>Activar proyecto</span>
                    </div>
                </div>

            </div>

            <div class="form-group " style="text-align: center;margin-top: 7%;">
                <button id="create_new_project" class="btn btn-primary" type="button">Crear Proyecto</button>
            </div>


        </div>

    </div>
</div>



<script>

    /* modo no asincrono entrada por htpp* **/
    $(document).ready(()=>{
        project_data.loaders();
    });

    /** carga modo asincrono XHR**/
    (function($) {
        try{

            if(!document.addEventListener)
            {
                project_data.loaders();
            }

        }
        catch (ex){
            console.log(ex);
        }

    })(this.jQuery);



</script>
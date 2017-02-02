
[PageBar ; {"name":"Home" , "url":"<?php echo dashboard_url(); ?>"} , {"name" : "Navegación"} ]

<h3 class="page-title">Navegador [ESP]
    <small>(Version 1.0.1)</small>
</h3>


<div class="row">
    <div class="col-md-12 col-xs-12">

        <input type="hidden" id="data_tree" value='<?= json_encode($navs);?>'>
        <input type="hidden" id="data_privs" value='<?= json_encode($privs); ?>'>
        <input type="hidden" id="data_navs" value='<?= implode("," , $navs_meta); ?>'>
        <input type="hidden" id="lang" value="<?= $lang ?>">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#tab_1_1" data-toggle="tab" aria-expanded="true">Navegador Izquierdo </a>
            </li>
            <li class="">
                <a id="sub-click" href="#tab_1_3" data-toggle="tab" aria-expanded="false">Sub Menús </a>
            </li>
            <li class="">
                <a id="tp-click" href="#tab_1_2" data-toggle="tab" aria-expanded="false"> Crear Navegador </a>
            </li>
        </ul>


        <div class="tab-content">

            <!-- tab la cual se muestra todos los navs -->
            <div class="tab-pane fade active in" id="tab_1_1">

                <div style="padding-bottom:20px;" class="col-md-12" >

                    <br><br>
                    <div id="nav_tree" class="tree-demo">
                        <ul>
                            <li data-jstree='{ "selected" : true , "opened" : true }'> Raiz del navegador
                                <?php foreach ($navs as $nodes): ?>
                                    <?php if (count($nodes->sidebars) >= 1 or count($nodes->sections) >= 1): ?>
                                    <ul>
                                        <li>
                                            <a onclick="navigator_.tree_show(<?php echo $nodes->id ?> , 'namespace' );" href="#"> <?= $nodes->name->$lang; ?></a>
                                            <ul>
                                                <?php foreach ($nodes->sidebars as $sidebar): ?>
                                                    <li onclick="navigator_.tree_show(<?php echo $sidebar->id ?>, 'sidebars' );" data-jstree='{ "icon" : "<?php echo $sidebar->active ? 'fa fa-link' : 'fa fa-chain-broken'; ?> icon-state-success " }'>
                                                        <?php
                                                                $name = json_decode($sidebar->name);
                                                                if(is_null($name)) $name = $sidebar->name;
                                                        ?>
                                                        <?= $name->$lang ?? $name; ?>
                                                    </li>
                                                <?php endforeach; ?>

                                                <?php foreach ($nodes->sections as $section): ?>

                                                        <li data-jstree='{ "icon" : "<?php echo $section->active ? 'fa fa-file' : 'fa fa-close'; ?> icon-state-success " ,  "opened" : true }' >
                                                            <a onclick="navigator_.tree_show(<?php echo $section->id ?> , 'sections' );" href="#">
                                                                <?php
                                                                        $name = json_decode($section->name);
                                                                        if(is_null($name)) $name = $section->name;
                                                                ?>
                                                                <?= $name->$lang ?? $name; ?>
                                                            </a>
                                                            <ul>
                                                                <?php foreach ($section->sidebars as $sidebar): ?>
                                                                    <li onclick="navigator_.tree_show(<?php echo $sidebar->id ?>, 'sidebars' );" data-jstree='{ "icon" : "<?php echo $sidebar->active ? 'fa fa-link' : 'fa fa-chain-broken'; ?> icon-state-success " }'>
                                                                        <?php
                                                                        $name = json_decode($sidebar->name);
                                                                        if(is_null($name)) $name = $sidebar->name;
                                                                        ?>
                                                                        <?= $name->$lang ?? $name; ?>
                                                                    </li>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                        </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </li>
                                    </ul>
                                    <?php endif; ?>
                                <?php endforeach;?>
                            </li>
                        </ul>
                    </div>
                    


                </div>

                <div class="col-md-12">

                    <div class="portlet light portlet-fit portlet-form bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class=" icon-layers font-green"></i>
                                <span id="tree-title" class="caption-subject font-green sbold uppercase">
                                    Información
                                </span>
                            </div>
                            <div class="actions">
                                <a id="save-tree-info" disabled="" class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                    <i class="fa fa-save"></i>
                                </a>
                                <a id="edit-tree-info" class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                    <i class="icon-wrench"></i>
                                </a>
                                <a id="trash-tree-info" class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                    <i class="icon-trash"></i>
                                </a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <!-- BEGIN FORM-->
                            <form action="#" class="form-horizontal" id="form-render-tree" novalidate="novalidate">
                            </form>
                            
                           
                            <!-- END FORM-->
                        </div>
                    </div>

                </div>

            </div>

            <!-- tab la cual se muestra todos los sub-menus -->
            <div class="tab-pane fade" id="tab_1_3" >

            </div>

            <!-- tab la cual podras crear nuevo navegador -->
            <div class="tab-pane fade" id="tab_1_2">

            </div>

        </div>

    </div>
</div>

<div class="modal fade" id='nav-message' tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Eliminar navegador</h4>
            </div>
            <div id="del-modal" class="modal-body">
                    ¿Seguro que desea eliminar el navegdaor con el nombre asignado ('{nav-name}') ? no hay vuelta atras
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Cerrar</button>
                <button id="delete-nav" type="button" class="btn red">Eliminar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade" id='nav-message-alert' tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Eliminar navegador</h4>
            </div>
            <div class="modal-body">
                Hubo un problema al momento de eliminar la accion , favor intentar denuevo.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>



<script>

    /* modo no asincrono entrada por htpp* **/
    $(document).ready(()=>{
        try{ navigator_.load(); }
        catch(ex){}
        
        let id = window.setInterval(()=>{
            $(".privs-loaders").css({"width" : "100% !important"});

        } , 1000);

        start_withInterval();
        
    });

    /** carga modo asincrono XHR**/
    (function($) {
        try{
            if(!document.addEventListener) {
                navigator_.load();
            }

            start_withInterval();
        }
        catch (ex){
        }

    })(this.jQuery);


    var start_withInterval = function () {
       window.setTimeout(function(){
            if(!$("#nav_tree").hasClass('jstree'))
            {
                $("#nav_tree").jstree();
                navigator_.load();
            }
        }, 500);
    };


</script>
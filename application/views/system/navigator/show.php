
<h3 class="page-title">Navegador
    <small>(Sistema 1.0)</small>
</h3>


<div class="row">
    <div class="col-md-12 col-xs-12">

        <input type="hidden" id="data_tree" value='<?= json_encode($navs);?>'>
        <input type="hidden" id="data_privs" value='<?= json_encode($privs); ?>'>

        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#tab_1_1" data-toggle="tab" aria-expanded="true">Información </a>
            </li>
            <li class="">
                <a href="#tab_1_2" data-toggle="tab" aria-expanded="false"> Crear Navegador </a>
            </li>
        </ul>


        <div class="tab-content">

            <!-- tab la cual se muestra todos los navs -->
            <div class="tab-pane fade active in" id="tab_1_1">

                <div class="col-md-6" >

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
                    
                    <div class='alert alert-info'>
                        <strong>Doble Click</strong> a cada nodo para reflescar su información
                    </div>

                </div>

                <div class="col-md-6">

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
                                <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                    <i class="icon-wrench"></i>
                                </a>
                                <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
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

            <!-- tab la cual podras crear nuevo navegador -->
            <div class="tab-pane fade " id="tab_1_2">


            </div>

        </div>

    </div>
</div>


<script>


    /* modo no asincrono entrada por htpp* **/
    $(document).ready(()=>{
        try{ navigator_.load(); }
        catch(ex){}
        
        let id = window.setInterval(()=>{
            $(".privs-loaders").css({"width" : "100% !important"});
        } , 1000);
        
    });

    /** carga modo asincrono XHR**/
    (function($) {
        try{
            navigator_.load();
            
        }
        catch (ex){
        }
    })(this.jQuery);


</script>
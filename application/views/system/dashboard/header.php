<?php

    $instance           = &get_instance();
    $ga_dashboard       = $instance->config->item("backend");
    $ga_                = $instance->config->item("ga_");
    $reflesh            = $instance->config->item("reflesh");
    $name               = $instance->user->get()->pretty_names();
    $avatar             = $instance->user->avatar();
    $request_limit      = $instance->config->item("request_limit");
    $json_sidebar       = $instance->config->item("ga_json_sidebar");
    $json_menubar       = $instance->config->item("ga_json_menubar");

?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="<?php echo $lang; ?>" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="<?php echo $lang; ?>" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="<?php echo $lang; ?>"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head id="ga_head">
    <!-- utf meta chartset -->
    <meta   id="ga_meta_charset" charset="utf-8"/>
    <!-- title -->
    <title  id="ga_title"><?php echo $title == "" ? "Main" : $title; ?></title>
    <!-- garrobo metadata -->
    <meta   id="ga_meta_ie" http-equiv="X-UA-Compatible" content="IE=edge">
    <meta   id="ga_meta_viewport" content="width=device-width, initial-scale=1" name="viewport"/>
    <meta   id="ga_meta_description" content="<?php echo $description; ?>" name="description"/>
    <meta   id="ga_meta_author" content="<?php echo $author; ?>" name="author"/>


    <!-- garrobo oficial font -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
    <!-- system css -->
    <?php foreach($css_system as $css) : ?>
        <link href="<?php echo $css; ?>" rel="stylesheet" id="<?php echo random_string(); ?>" type="text/css"/>
    <?php endforeach; ?>
    <!-- if exist loader css -->
    <?php foreach ($css as $css): ?>
        <link href="<?php echo $css; ?>" rel="stylesheet" id="<?php echo random_string(); ?>" type="text/css"/>
    <?php endforeach; ?>

    <!-- app css -->
    <?php

    /***
     * recursividad similar la de javascript solo cambia un preg match
    **/
    function css_lambda($node)
    {
        $preg           = "/<style>[\\s\\S]*?<\\/style>/";
        $preg_2         = "%^((https?://)|(www\\.))([a-z0-9-].?)+(:[0-9]+)?(/.*)?$%i";

        foreach ($node as $data){

            if(is_array($data) || is_object($data))
            {
                css_lambda($data);
            }
            else{
                if(preg_match($preg , $data))
                {
                    echo $data;
                }
                else if(preg_match($preg_2 , $data))
                {
                    echo "<link href='$data'  type='text/css' rel='stylesheet' />";
                }
            }

        }
    }
    
    //llamamos la funcion recursiva
    css_lambda($css_apps);

    ?>


    <!-- end app css-->

    <!-- SYSTEM CORE JAVASCRIPT -->
    <?php foreach ($js_system as $js): ?>
        <?php echo "<script src='$js' type='text/javascript'></script>"; ?>
    <?php endforeach; ?>



    <!-- APPS HEADER SCRIPTS -->
    <?php

    /***
     * cada aplicacion puede tener llamados de javascript
     * aca separa la data por medio de recursividad y expresiones regulares
     * esto significa que hace el mismo proceso que cuando es xhr pero con la ventaja
     * de que los script permaneceran en el DOM ya que no llevan identificadores
     * 
     * desarrolado por Rolignu
     * ultima modificacion : 03/12/2016 por rolignu<
     ***/
 
    function js_lambda_header($node , $scripts= array())
    {
        $preg           = "/<script[\\s\\S]*?>[\\s\\S]*?<\\/script>/";
        $preg_2         = "%^((https?://)|(www\\.))([a-z0-9-].?)+(:[0-9]+)?(/.*)?$%i";

        foreach ($node as $data){

            if(is_array($data))
            {
              
                if(isset($data["type"]) && isset($data['location']))
                {
                    
                    
                    if($data['location'] == "header" && !isset($data['systemjs']) || $data['systemjs'] == true) {
                       // echo "<script type='" . $data['type'] . "' src='" . $data['script'] . "' async></script>";
                       $scripts[] = array( 
                           "script"     => $data['script'] , 
                           "mode"       => null,
                           "type"       => $data['type']
                        );
                    }
                    else if (isset($data['systemjs']) || $data['systemjs'] == false)
                    {
                         echo "<script type='" . $data['type'] . "' src='" . $data['script'] . "' async></script>";
                    }
                }else{
                    js_lambda_header($data, $scripts);
                }
            }
            
        }
        
        return $scripts;
    }
    

    //llamamos la funcion recursiva
    $script_array = js_lambda_header($js_apps);

    ?>
   
    <script>
        System.transpiler = 'babel';

        <?php
        
            /***
             * importacion por medio de SystemJS
             * se necesita que la funcion ademas de recursiva 
             * devuelva un arreglo en la cual se habilitara el modo debug 
             * en esta forma
             * ***/
        
        ?>
        <?php foreach ($script_array as $script): $s = (object) $script; ?>
            <?php if(!is_null($s->mode) || !empty($s->mode)) : ?>
                console.log('<?= $s->script ?> [IS IN DEBUG MODE ]');
            <?php endif; ?> 
            System.import('<?= $s->script  ?>');
        <?php endforeach; ?>


       /* Peace.options = {
            restartOnRequestAfter: false,
            ajax: false
        };*/

    </script>

    <!-- icon or favicon -->
    <link id="ga_icon" rel="shortcut icon" href="<?php echo $favicon; ?>"/>
</head>
<!-- END HEAD -->
<!-- BODY BABY -->
<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
<input type="hidden" id="ga_url" value="<?php echo site_url(); ?>" />
<input type="hidden" id="ga_reflesh" value="<?php echo $reflesh; ?>" />
<input type="hidden" id="ga_storage" value="1" />
<input type="hidden" id="ga_controller" value="<?php echo $json_sidebar; ?>" />
<input type="hidden" id="ga_controller_menu" value="<?php echo $json_menubar; ?>" />
<input type="hidden" id="ga_dashboard" value = "<?php echo $ga_dashboard; ?>"/>
<input type="hidden" id="ga_entry" value = "<?php echo $entry; ?>"/>
<input type="hidden" id="ga_hibrid" value = "<?php echo $ga_ ?? 1; ?>"/>
<input type="hidden" id="ga_lang" value = "<?php echo $lang ?? "es" ; ?>"/>
<input type="hidden" id="ga_limit" value = "<?php echo $request_limit ?? 100; ?>"/>
<input type="hidden" id="ga_current_url" value="" name="" />
<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner ">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="index.html">
                <img width="10%" src="<?= site_url();?>content/system/files/img/smartwater.png" alt="logo" class="logo-default" /> </a>
            <div class="menu-toggler sidebar-toggler"> </div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN TOP NAVIGATION MENU -->
        <div id="ga_menu" class="top-menu">
            <ul class="nav navbar-nav pull-right">
               
                <li class="dropdown dropdown-user">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <img alt="" id="header_profile_image" class="img-circle" src="<?php echo $avatar; ?>">
                        <span class="username username-hide-on-mobile"><?php echo $name; ?></span>
                        <i class="fa fa-angle-down"></i>
                    </a>

                    <ul id="ga_sub_menu" class="dropdown-menu dropdown-menu-default">

                    </ul>
                </li>
            </ul>
        </div>
        <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END HEADER INNER -->
</div>


<!-- BEGIN HEADER & CONTENT DIVIDER -->
<div class="clearfix"> </div>
<!-- END HEADER & CONTENT DIVIDER -->
<!-- BEGIN CONTAINER -->

<div class="page-container">
    <div class="page-sidebar-wrapper">
        <div class="page-sidebar navbar-collapse collapse">
            <!--BEGIN VERTICAL SIDEBAR-->
            <ul id="ga_nav" class="page-sidebar-menu  page-header-fixed "
                        data-keep-expanded="false"
                        data-auto-scroll="true"
                        data-slide-speed="200" style="padding-top: 20px">

            </ul>
            <!-- END SIDEBAR MENU -->
        </div>

        <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            <!-- BEGIN CONTENT BODY -->
            <div id="ga_" class="page-content">
                    <?php if($entry == "no-dashboard") { echo $render; } ?>
            </div>
            <!-- END CONTENT BODY -->
        </div>
        <!-- END CONTENT -->
        <!-- BEGIN QUICK SIDEBAR -->
        <a href="javascript:;" class="page-quick-sidebar-toggler">
            <i class="icon-login"></i>
        </a>
    </div>

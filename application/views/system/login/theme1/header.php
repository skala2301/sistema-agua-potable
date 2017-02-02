<!DOCTYPE html>
<?php $directory = __DIR__; ?>
<html lang="<?php echo $lang; ?>" id="garrobo">
<!--[if IE 8]> <html lang="<?php echo $lang; ?>" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="<?php echo $lang; ?>" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<head>
        <meta charset="utf-8" />
        <title><?php print $title; ?></title>
        
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="<?php print $description; ?>" name="description" />
        <meta content="<?php print $author; ?>" name="author" />
        
        <link rel="shortcut icon" href="<?php print site_url($favicon); ?>" /> 
        
        <?php
       
            $css = print_css([
                "bootstrap",
                "fontawesome",
                "content/assets/plugins/simple-line-icons/simple-line-icons.min.css",
                "content/assets/global/plugins/uniform/css/uniform.default.css",
                "content/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css",
                "select2",
                "select2_bootstrap",
                "content/assets/global/css/components.min.css",
                "content/assets/global/css/plugins.min.css",
                "content/assets/themes/theme1/css/login.css",
                "animate"
            ] , "url");
        
        ?>
        
        <?php foreach($css as $style): ?>
                <link href="<?php echo $style; ?>" id="<?php echo random_string('sha1'); ?>" rel="stylesheet" type="text/css" />
        <?php endforeach; ?>
                
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        
</head>



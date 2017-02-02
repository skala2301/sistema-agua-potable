<?php
    $lang = $_GET['lang'] ?? isset($_COOKIE['lang']) ? $_COOKIE['lang'] : "en";

?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="<?php echo $lang; ?>" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="<?php echo $lang; ?>" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="<?php echo $lang; ?>"> <!--<![endif]-->

<head>
    <meta charset="utf-8"/>
    <title>Install</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>


    <link rel="shortcut icon" href="favicon.ico"/>

    <script>

        var load = function()
        {

            this.css = [<?php foreach ($params['css'] as $css) { echo "'". "$css" . "',"; } ?>];
            this.js = [<?php foreach ($params['js'] as $js) { echo "'". "$js" . "',"; } ?>];
            this.instance = function()
            {
                for(i = 0 ; i < this.css.length ;i++)
                {
                    let d = document.createElement("link");
                    d.type  = "text/css";
                    d.rel   = "stylesheet";
                    d.href  = this.css[i];
                    document.head.appendChild(d);
                }

                for(i = 0 ; i < this.js.length ; i++)
                {
                    let d = document.createElement("script");
                    d.type  = "text/javascript";
                    d.src  = this.js[i];
                    document.body.appendChild(d);
                }
            };

        };


        var i = new load();
        i.instance();
    </script>

</head>



<body>


<div class="page-container">

    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light portlet-fit bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-wrench"></i>
                                <span class="caption-subject font-black bold uppercase">INSTALACION DE LA PLATAFORMA </span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="mt-element-step">
                                <div class="row step-line">
                                    <div class="col-md-4 mt-step-col first done">
                                        <div class="mt-step-number bg-white">
                                            <i class="fa fa-shopping-cart"></i>
                                        </div>
                                        <div class="mt-step-title uppercase font-grey-cascade">Purchase</div>
                                        <div class="mt-step-content font-grey-cascade">Purchasing the item</div>
                                    </div>
                                    <div class="col-md-4 mt-step-col active">
                                        <div class="mt-step-number bg-white">
                                            <i class="fa fa-cc-visa"></i>
                                        </div>
                                        <div class="mt-step-title uppercase font-grey-cascade">Payment</div>
                                        <div class="mt-step-content font-grey-cascade">Complete your payment</div>
                                    </div>
                                    <div class="col-md-4 mt-step-col last">
                                        <div class="mt-step-number bg-white">
                                            <i class="fa fa-rocket"></i>
                                        </div>
                                        <div class="mt-step-title uppercase font-grey-cascade">Deploy</div>
                                        <div class="mt-step-content font-grey-cascade">Receive item integration</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END : STEPS -->
        </div>
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->

</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<div class="page-footer">
    <div class="page-footer-inner"> <?php echo date("Y"); ?> &copy;
        <a href="#" title="Garrobo Platform" target="_blank">Garrobo Platform!</a>
    </div>
</div>

</body>
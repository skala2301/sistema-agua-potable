<<!DOCTYPE html>
<html>
    <head>
        <title>Lieisoft | Acceso Denegado</title>
        <link href="<?php echo $route; ?>assert/error/error.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            <div class="page-content">                
                <div class="page-bar">
                    <ul class="page-breadcrumb">
                        <li>
                            <i class="icon-direction"></i>
                            <a href="<?php echo site_url("Dashboard/index/"); ?>">Inicio</a>
                            <i class="fa fa-circle"></i>
                        </li>
                        <li>
                            <a href="<?php echo site_url("Dashboard/index/"); ?>">Permiso Denegado</a>
                        </li>
                    </ul>
                    <div class="page-toolbar">
                    </div>
                </div>
                <h3 class="page-title">
                    Lieisoft<small> | Dashboard</small>
                </h3>
                <!-- END PAGE HEADER-->
                <!-- BEGIN DASHBOARD STATS -->
                <div class="row">
                    <div class="col-md-12 page-404">
                        <div class="number">
                            500
                        </div>
                        <div class="details">
                            <h3>Permiso Denegado</h3><br>
                            <p>
                                No tienes los Permisos suficientes para acceder a esta Pagina<br/>
                                Contacta a tu Administrador<a href="<?php echo site_url("Dashboard/index/"); ?>">
                                    Regresar al Inicio</a>
                            </p>
                        </div>
                    </div>
                </div>   
            </div>
        </div>

        <!-- END CONTENT -->
    </body>
</html>
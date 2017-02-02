
<?php if(!$enabled): ?>
    <link href="<?php echo site_url();?>content/system/core/css/global/bootstrap/bootstrap.min.css" rel="stylesheet" id="zCoI6E4u" type="text/css"/>
<?php endif; ?>


<link href="<?php echo site_url();?>content/assets/global/css/error.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url();?>content/system/core/css/global/font_awesome/font-awesome.min.css" rel="stylesheet" id="6WNaMBDh" type="text/css"/>
<link href="<?php echo site_url();?>content/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" id="gB2CeKoz" type="text/css"/>
<link href="<?php echo site_url();?>content/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" id="Z4SIXf1Y" type="text/css"/>
<link href="<?php echo site_url();?>content/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" id="7SZCs2Pd" type="text/css"/>
<link href="<?php echo site_url();?>content/assets/global/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" id="lhPJvfGL" type="text/css"/>
<link href="<?php echo site_url();?>content/assets/global/css/components.css" rel="stylesheet" id="ToLWp6kA" type="text/css"/>
<link href="<?php echo site_url();?>content/assets/layouts/layout/css/layout.css" rel="stylesheet" id="az0Dgie4" type="text/css"/>

<?php $instance = &get_instance(); ?>
<?php $instance->load->helper("form"); ?>
<?php $request = $request ?? null ; ?>
<div style="padding-top:10%" class="row">
    <div class="col-md-12 page-404">
        <div class="number font-red"> 404 </div>
        <div class="details">
            <h3>Oops! Estas perdido </h3>
            <p> <?php if(isset($message)): ?>
                        <?= $message; ?>
                    <?php else: ?>
                        No pudimos encontrar lo que buscas :(
                <?php endif; ?>
                <br/>
                <?= form_open("Dashboard/Request" ,
                    [
                        "method"        => "post" ,
                        "id"            => "looking_form"
                    ] ,
                    [
                        "dir"       => "system" ,
                        "model"     => "system_core" ,
                        "function"  => "get_looking" ,
                        "lang"      => $lang ?? "es",
                        "token"     => "asd09903453334556336546562264",
                        "request"   => $request ?? null
                    ]);
                ?>
            <?php if(is_null($request) || $request == 'front'): ?>
                <div class="input-group input-medium">
                    <input name="look" type="text" class="form-control" placeholder="palabra clave">
                            <span class="input-group-btn">
                                <button type="submit" class="btn red">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                </div>
            <?php endif; ?>
            <?= form_close(); ?>
        </div>
    </div>
</div>


[PageBar ; {"name":"Home" , "url":"<?php echo dashboard_url(); ?>"}, {"name" : "System " , "url" : ""} , {"name" : "Email-Config"} ]


<h3 class="page-title">Email configuration
    <small>(SMTP)</small>
</h3>

<div class="row">

    <form method="post"  action="<?php echo site_url("/request/save_smtp/system/email"); ?>" id="ga_smtp" class="form-horizontal">
        <div class="col-md-6">

            <div class="form-body">
                    <div class="form-group form-md-line-input">
                        <label class="col-md-4 control-label" for="form_control_1">{$core_lang ,[ system , email , protocol]}</label>
                        <div class="col-md-8">
                            <input type="text" name="protocol" id="protocol" value="<?php echo $protocol; ?>" class="form-control" placeholder="">
                        </div>
                    </div>
                <div class="form-group form-md-line-input">
                    <label class="col-md-4 control-label" for="form_control_1">{$core_lang ,[ system , email , host]}</label>
                    <div class="col-md-8">
                        <input type="text" name="host" id="host" value="<?php echo $smtp_host; ?>" class="form-control" placeholder="">
                    </div>
                </div>
                <div class="form-group form-md-line-input">
                    <label class="col-md-4 control-label" for="form_control_1">{$core_lang ,[ system , email , port]}</label>
                    <div class="col-md-8">
                        <input type="text" name="port" id="port" value="<?php echo $smtp_port; ?>" class="form-control" placeholder="">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-body">
                <div class="form-group form-md-line-input">
                    <label class="col-md-4 control-label" for="form_control_1">
                        {$core_lang ,[ system , email , timeout]}
                    </label>
                    <div class="col-md-8">
                        <input type="text" name="timeout" id="timeout" value="<?php echo $smtp_timeout; ?>" class="form-control" placeholder="">
                    </div>
                </div>
                <div class="form-group form-md-line-input">
                    <label class="col-md-4 control-label" for="form_control_1">
                        {$core_lang ,[ system , email , user]}
                    </label>
                    <div class="col-md-8">
                        <input type="text" name="user" id="user" value="<?php echo $smtp_user; ?>" class="form-control" placeholder="">
                    </div>
                </div>
                <div class="form-group form-md-line-input">
                    <label class="col-md-4 control-label" for="form_control_1">
                        {$core_lang ,[ system , email , password]}
                    </label>
                    <div class="col-md-8">
                        <input type="text" name="password" id="password" value="<?php echo $smtp_password; ?>" class="form-control" placeholder="">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5"></div>
        <div class="col-md-2">
             <div class="form-body">
                 <button type="submit" class="form-control btn btn-primary">
                     <i class="fa fa-save"></i>
                     {$core_lang ,[ system , email , save]}
                 </button>
             </div>
        </div>
        <div class="col-md-5"></div>
    </form>
</div>

<script>

    (function($){




    })(this.jQuery);

    $(document).ready(function(){
        $("#ga_smtp").ga_forms({ a : function(r){
                 alert(r);

        }, b: function(){

        }});
    });

</script>

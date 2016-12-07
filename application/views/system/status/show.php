[PageBar; {"name":"Home" , "url":"<?php echo dashboard_url(); ?>"}, {"name" : "System " , "url" : ""} , {"name" : "Status"} ]

<h3 class="page-title">System Status</h3>

<?php

/**

 *  return $this->load->view("system/status/show" , [
"lang"             => $lang,
"browser"          => $browser,
"browser_version"  => $browser_version,
"os"               => $os,
"uagent"           => $uagent,
"system_url"       => $system_url,
"phpversion"       => $phpversion
] , TRUE);
 *
 ***/


?>

<div class="row">

    <form  class="form-horizontal">
        <div class="col-md-6">

            <div class="form-body">
                <div class="form-group form-md-line-input">
                    <label class="col-md-3 control-label" for="form_control_1">Language</label>
                    <div class="col-md-8">
                        <input disabled type="text" name="" id="" value="<?php echo $lang; ?> " class="form-control" placeholder="">

                    </div>
                </div>
                <div class="form-group form-md-line-input">
                    <label class="col-md-3 control-label" for="form_control_1">Browser</label>
                    <div class="col-md-8">
                        <input disabled type="text" name="" id="" value="<?php echo $browser; ?>" class="form-control" placeholder="">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
                <div class="form-group form-md-line-input">
                    <label class="col-md-3 control-label" for="form_control_1">Browser Version</label>
                    <div class="col-md-8">
                        <input disabled type="text" name="" id="" value="<?php echo $browser_version; ?>" class="form-control" placeholder="">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
                <div class="form-group form-md-line-input">
                    <label class="col-md-3 control-label" for="form_control_1">Operative System (O.S)</label>
                    <div class="col-md-8">
                        <input disabled type="text" name="" id="" value="<?php echo $os; ?>" class="form-control" placeholder="">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
                <div class="form-group form-md-line-input">
                    <label class="col-md-3 control-label" for="form_control_1">Usage Memory </label>
                    <div class="col-md-8">
                        <input disabled type="text" name="" id="" value="<?php echo $memory_usage; ?>" class="form-control" placeholder="">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
                <div class="form-group form-md-line-input">
                    <label class="col-md-3 control-label" for="form_control_1">Max Script Usage Memory </label>
                    <div class="col-md-8">
                        <input disabled type="text" name="" id="" value="<?php echo $memory_max; ?>" class="form-control" placeholder="">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">

            <div class="form-body">
                <div class="form-group form-md-line-input">
                    <label class="col-md-3 control-label" for="form_control_1">User Agent</label>
                    <div class="col-md-8">
                        <input disabled type="text" name="" id="" value="<?php echo $uagent; ?> " class="form-control" placeholder="">

                    </div>
                </div>
                <div class="form-group form-md-line-input">
                    <label class="col-md-3 control-label" for="form_control_1">System Url</label>
                    <div class="col-md-8">
                        <input disabled type="text" name="" id="" value="<?php echo $system_url; ?>" class="form-control" placeholder="">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
                <div class="form-group form-md-line-input">
                    <label class="col-md-3 control-label" for="form_control_1">PHP version</label>
                    <div class="col-md-8">
                        <input disabled type="text" name="" id="" value="<?php echo $phpversion; ?>" class="form-control" placeholder="">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
                <div class="form-group form-md-line-input">
                    <label class="col-md-3 control-label" for="form_control_1">Garrobo Version</label>
                    <div class="col-md-8">
                        <input disabled type="text" name="" id="" value="<?php echo $ga_version;  ?>" class="form-control" placeholder="">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
                <div class="form-group form-md-line-input">
                    <label class="col-md-3 control-label" for="form_control_1">CI version</label>
                    <div class="col-md-8">
                        <input disabled type="text" name="" id="" value="<?php echo $ci_version;  ?>" class="form-control" placeholder="">
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

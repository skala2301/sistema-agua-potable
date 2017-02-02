[PageBar ; {"name":"Home" , "url":"<?php echo dashboard_url(); ?>"}, {"name" : "System " , "url" : ""} , {"name" : "Constants"} ]

<?php $right_side = []; ?>

<h3 class="page-title">Constants configuration
    <small>operating all constants</small>
</h3>

<div class="row">

    <form  action="/" id="const-form" class="form-horizontal">
        <div class="col-md-6">

        <div class="form-body">
            <?php foreach($const as $key=>$value): if(!is_array($value)){ ?>
            <div class="form-group form-md-line-input">
                <label class="col-md-3 control-label" for="form_control_1"><?php echo $key; ?></label>
                <div class="col-md-8">
                    <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo $value?>" class="form-control" placeholder="">
                    <div class="form-control-focus"> </div>
                </div>
            </div>
                <?php }else{ $right_side[$key] = $value; } ?>
            <?php endforeach; ?>
        </div>
        </div>



        <div class="col-md-6">
            <div class="form-body">
                 <?php foreach($right_side as $key=>$value): ?>

                     <div class="form-group form-md-line-input">
                         <h4 class="col-md-6 control-label" for="form_control_1"><p style="font-weight: bold;text-transform: uppercase;"><?php echo $key; ?></p></h4>
                         <?php foreach ($value as $k=>$v): ?>
                             <label class="col-md-12 control-label" for="form_control_1"><?php echo $k; ?></label>
                         <div class="col-md-12">
                             <input name="<?php echo $key . "-" . $k; ?>" id="<?php echo $key . "-" . $k; ?>"  type="text" value="<?php echo $v?>" class="form-control" placeholder="">
                             <div class="form-control-focus"> </div>
                         </div>
                         <?php  endforeach; ?>
                     </div>
                <?php endforeach; ?>
            </div>
        </div>


        <div style="text-align: right;" class="col-md-6">
            <div class="form-body">
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-12">
                            <button id="send-const" type="submit" class="btn ">Send</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div id="si_yes" style="display: none;" class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                <strong>WOW!</strong> Well done and everything looks OK.
                <a href="<?php echo dashboard_url(); ?>" class="alert-link"> Please reflesh all system with F5 or click this </a>
            </div>

            <div id="no_no" style="display: none;" class="alert alert-danger alert-dismissable">

            </div>
        </div>
    </form>
</div>


<script>

    $(document).ready( function(){
          $("#const-form")
              .unbind()
              .submit(function(e){

                  let data = {
                      "serialize" : $(this).serialize()
                  };

                  var that = this;
                  $(this).find("button").html("Sending...");

                  ga_request(  { function: 'Save' , dir : 'system' , model : 'Constants' }  , data  , function(a){

                      let j = JSON.parse(a);
                      switch(j.error)
                      {
                          case false:
                               $("#si_yes").css({"display" : "block"});
                               $("#no_no").css({"display" : "none"});
                              break;
                          case true:
                              $("#no_no").css({"display" : "block"});
                              $("#si_yes").css({"display" : "none"});
                              break;
                      }
                      $(that).find("button").html("Send");
                  });

              e.preventDefault();
          });
    });

</script>



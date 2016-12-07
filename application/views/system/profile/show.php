

[PageBar ; {"name":"Home" , "url":"<?php echo dashboard_url(); ?>"} , {"name" : "Usuario"} ]

<style>
    .btn-circle {
        width: 40px;
        height: 40px;
        text-align: center;
        padding: 2px 0;
        font-size: 12px;
        line-height: 1.42;
        border-radius: 15px;
        float: left;
        margin-left: 100%;
    }

    .button-space {
        padding-top: 20px;
    }

</style>

<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PROFILE SIDEBAR -->
        <div class="profile-sidebar">
            <!-- PORTLET MAIN -->
            <div class="portlet light profile-sidebar-portlet ">
                <!-- SIDEBAR USERPIC -->
                <div class="profile-userpic">
                    <img src="<?php echo $avatar; ?>" class="img-responsive" alt=""> </div>
                <!-- END SIDEBAR USERPIC -->
                <!-- SIDEBAR USER TITLE -->
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name"> <?php echo $user_data->name; ?> </div>
                    <div class="profile-usertitle-job"> <?php echo $privs->parent[0]->name;  ?>  </div>
                </div>
                <!-- END SIDEBAR USER TITLE -->
                <!-- SIDEBAR MENU -->
              <!--  <div class="profile-usermenu">
                    <ul class="nav">
                        <li>
                            <a href="page_user_profile_1.html">
                                <i class="icon-home"></i> Overview </a>
                        </li>
                        <li class="active">
                            <a href="page_user_profile_1_account.html">
                                <i class="icon-settings"></i> Account Settings </a>
                        </li>
                        <li>
                            <a href="page_user_profile_1_help.html">
                                <i class="icon-info"></i> Help </a>
                        </li>
                    </ul>
                </div>-->
                <!-- END MENU -->
            </div>
            <!-- END PORTLET MAIN -->
            <!-- PORTLET MAIN -->
            <div class="portlet light ">
                <!-- STAT -->
                <div class="row list-separated profile-stat">
                    <?php foreach ($privs->child as $child): ?>
                    <div class="col-md-2 col-sm-2 col-xs-2">
                        <div class="uppercase profile-stat-text"><?php echo $child->name; ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <!-- END STAT -->
                <div>
                    <h4 class="profile-desc-title">{$core_lang,[profile,about,about]}<?php echo  $user_data->name; ?></h4>
                    <span class="profile-desc-text">
                        <?php echo $user_data->occupation; ?>
                    </span>
                    <div class="margin-top-20 profile-desc-link">
                        <i class="fa fa-globe"></i>
                        <a target="_blank" href="<?php echo $user_data->website; ?>"><?php echo $user_data->website; ?></a>
                    </div>
                    <div class="margin-top-20 profile-desc-link">
                        <i class="fa fa-flag"></i>
                        <a href="#"><?php echo $user_data->location; ?></a>
                    </div>
                    <div class="margin-top-20 profile-desc-link">
                        <i class="fa fa-calendar"></i>
                        <a href="#">Usuario hace <?php echo $register; ?></a>
                    </div>
                    <div class="margin-top-20 profile-desc-link">
                        <i class="fa fa-clock-o"></i>
                        <a href="#">Conexión <?php echo $connect; ?></a>
                    </div>
                    <div class="margin-top-20 profile-desc-link">
                        <i class="fa fa-envelope-o"></i>
                        <a href="#"><?php echo $user_data->email; ?></a>
                    </div>
                </div>
            </div>
            <!-- END PORTLET MAIN -->
        </div>
        <!-- END BEGIN PROFILE SIDEBAR -->
        <!-- BEGIN PROFILE CONTENT -->
        <div class="profile-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light ">
                        <div class="portlet-title tabbable-line">
                            <div class="caption caption-md">
                                <i class="icon-globe theme-font hide"></i>
                                <span class="caption-subject font-blue-madison bold uppercase">{$core_lang,[profile,about,account]}</span>
                            </div>
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tab_1_1" data-toggle="tab">{$core_lang ,[ profile , tabs , t1]}</a>
                                </li>
                                <li>
                                    <a href="#tab_1_2" data-toggle="tab">{$core_lang ,[ profile , tabs , t2]}</a>
                                </li>
                                <li>
                                    <a href="#tab_1_3" data-toggle="tab">{$core_lang ,[ profile , tabs , t3]}</a>
                                </li>
                                <li>
                                    <a href="#tab_1_4" data-toggle="tab">{$core_lang ,[ profile , tabs , t4]}</a>
                                </li>
                                <li>
                                   <a href="#tab_1_5" data-toggle="tab">{$core_lang ,[ profile , tabs , t5]}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="portlet-body">
                            <div class="tab-content">
                                <!-- PERSONAL INFO TAB -->
                                <div class="tab-pane active" id="tab_1_1">
                                    <form role="form" id="profile_submit" method="post" action="<?php echo site_url("request/save_profile/profile/profile"); ?>">
                                        <div class="form-group">
                                            <label class="control-label">{$core_lang ,[ profile , personal , name]}</label>
                                            <input name="name" type="text" value="<?php echo  $user_data->name; ?>" placeholder="<?php echo  $user_data->name; ?>" class="form-control"> </div>
                                        <div class="form-group">
                                            <label  class="control-label">{$core_lang ,[ profile , personal , last_name]}</label>
                                            <input name="last_name" type="text"  value="<?php echo  $user_data->last_name; ?>" placeholder="<?php echo  $user_data->last_name; ?>" class="form-control"> </div>
                                        <div class="form-group ">
                                            <label class="control-label">{$core_lang ,[ profile , personal , user]}</label>
                                            <input id="user" name="user" type="text" value="<?php echo  $user_data->username; ?>"  placeholder="<?php echo  $user_data->username; ?>" class="form-control data_disabled"> </div>
                                        <div class="form-group">
                                            <label class="control-label">{$core_lang ,[ profile , personal , occupation]}</label>
                                            <input name="occupation" type="text" value="<?php echo  $user_data->occupation; ?>" placeholder="<?php echo  $user_data->occupation; ?>" class="form-control"> </div>
                                        <div class="form-group">
                                            <label class="control-label">{$core_lang ,[ profile , personal , location]}</label>
                                            <input name="location" type="text" value="<?php echo  $user_data->location; ?>" placeholder="<?php echo  $user_data->location; ?>" class="form-control"> </div>
                                        <div class="form-group">
                                            <label class="control-label">{$core_lang ,[ profile , personal , website]}</label>
                                            <input name="website" type="text" value="<?php echo  $user_data->website; ?>" placeholder="<?php echo  $user_data->website; ?>" class="form-control">
                                        </div>
                                        <div class="margiv-top-10">
                                            <button id="send_profile" type="button" class="btn green">{$core_lang ,[ profile , personal , save]}</button>
                                            <button type="button" id="cancel"  class="btn default">{$core_lang ,[ profile , personal , cancel]}</button>
                                        </div>
                                    </form>
                                </div>
                                <!-- END PERSONAL INFO TAB -->
                                <!-- CHANGE AVATAR TAB -->
                                <div class="tab-pane" id="tab_1_2">
                                    <form id="" action=""  method="post" role="form">
                                        <div class="form-group">
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                    <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text={$core_lang , [profile , personal , no_img]}" alt=""> </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                                <div>
                                                                        <span class="btn default btn-file">
                                                                            <span class="fileinput-new"> {$core_lang ,[profile , image , select]} </span>
                                                                            <span class="fileinput-exists"> {$core_lang ,[profile , image , change]} </span>
                                                                            <input type="file" name="avatar" id="avatar" /> </span>
                                                    <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> {$core_lang ,[profile , image , remove]}</a>
                                                </div>
                                            </div>
                                            <div class="clearfix margin-top-10">
                                                <span class="label label-danger">{$core_lang,[profile,personal,note]}</span>
                                                <span>{$core_lang , [profile , personal , attach]}</span>
                                            </div>
                                        </div>
                                        <div class="margin-top-10">
                                            <a id="save_image" href="javascript:;" class="btn green"> {$core_lang ,[profile , image , save]}</a>
                                            <a href="javascript:;" class="btn default">{$core_lang ,[profile , image , cancel]}</a>
                                        </div>
                                    </form>
                                </div>
                                <!-- END CHANGE AVATAR TAB -->
                                <!-- CHANGE PASSWORD TAB -->
                                <div class="tab-pane" id="tab_1_3">
                                    <form action="#">
                                        <div class="form-group">
                                            <label class="control-label">{$core_lang , [profile , password , current]}</label>
                                            <input type="password" id="password" name="password" class="form-control"> </div>
                                        <div class="form-group">
                                            <label class="control-label">{$core_lang , [profile , password , new]}</label>
                                            <input type="password" id="newpass" name="newpass" class="form-control"> </div>
                                        <div class="form-group">
                                            <label class="control-label">{$core_lang , [profile , password , re-type]}</label>
                                            <input type="password" id="retypepass" name="retypepass" class="form-control"> </div>
                                        <div class="margin-top-10">
                                            <a href="javascript:;" id="savepass" class="btn green">{$core_lang , [profile , password , change]}</a>
                                        </div>
                                    </form>
                                </div>
                                <!-- END CHANGE PASSWORD TAB -->
                                <!-- LOG PROFILE -->
                                <div class="tab-pane" id="tab_1_4">
                                    <div class="faq-page faq-content-1">
                                    <div class="faq-content-container">
                                        <div class="row">
                                            <div  class="col-md-12">
                                                <div class="faq-section">
                                                <div class="panel-group accordion faq-content">
                                                <div id="logfile" class="panel panel-default">

                                                </div>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>

                                    <div class="col-md-6">
                                        <button id="logmore" class="btn btn-default btn-circle"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                                    </div>
                                </div>

                                <!-- END PRIVACY SETTINGS TAB -->
                                <div class="tab-pane " id="tab_1_5">
                                    <form action="#">
                                        <div class="form-group">
                                            <label class="control-label">{$core_lang ,[ profile , personal , language]}</label>
                                            <?php  echo $clang;?>
                                            <select id="lang-change" class="form-control">
                                                <?php foreach ($languages as $key=>$value): ?>
                                                    <?php $lang_ = '' ; if(isset($_COOKIE['lang'])) $lang_ = $_COOKIE['lang']; else $lang_= $user_data->lang;  if($lang_ == $key): ?>
                                                        <option selected value="<?php echo  $key ?>"><?php echo $value; ?></option>
                                                        <?php else: ?>
                                                            <option value="<?php echo  $key ?>"><?php echo $value; ?></option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                            
                                            <hr>
                                            <div class="form-group">
                                                <label class="control-label">User type </label>
                                                <input disabled type="text" class="form-control" value="(<?= $utype->type; ?>) <?= $utype->label ?>">
                                            </div>

                                            <div class="button-space">
                                                <button type="button" id="save_advance" class="btn btn-primary">{$core_lang ,[ profile , personal , save]}</button>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PROFILE CONTENT -->
    </div>
</div>
<script>

    var property = {
        start : 0 ,
        count: 10 ,
        location : '/profile/profile',
        functions : {
            log         : 'log_profile',
            avatar      : 'save_avatar',
            password    : 'save_password',
            advance     : 'save_advance'
        }
    };

    var logfile = function(){

        try {
            let l = property.functions.log + property.location;
            ga_request( l, property, function (result) {
                let object = JSON.parse(result);
                property.start = object.start;
                property.count = object.count;
                let log = $("#logfile");
                log.html("");
                $.map(object.data, function (o) {
                    let b = '<div class="panel-heading">' +
                        '<h5 class="panel-title">' +
                        ' <i class="fa fa-circle"></i>' +
                        '<a class="accordion-toggle collapsed"  href="#" >' + o.data + '</a>'
                    '</h5>' +
                    '</div>';
                    log.append(b);
                });
            });

        }catch(e){
            /**
             * ga_request in load even not defined
             * fixed if call a document ready
             * **/
            $(document).ready(function(){
                logfile();
                defined_();
            });
        }
    };
    var defined_ = function() {
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": true,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        $("#savepass").attr("disabled" , "disabled");

    };

    /**
     * document load function , if call is xhr _ga
     * **/
    (function($) {

         try {defined_(); } catch(e) {}

         $("#cancel").click(function () {
              ga_(url_ + "/" + back_end );
         });

         $("#send_profile").click(function () {
             var that = this;
             ga_forms('profile_submit' , function (a) {

                 $(that)
                     .html("{$core_lang ,[ profile , personal , save]}")
                     .prop("disabled" , false );


                 if(a.error == true)
                    toastr["warning"](a.message ,"{$core_lang ,[ profile , alerts ,  warning]}");
                 else
                     toastr["success"]( a.message , "{$core_lang ,[ profile , alerts , success ]}");

                 switch(a.type)
                 {
                     case 1:
                         $("#user").css({
                             "border" : "2px solid red"
                         });
                         break;
                     default:
                         $("#user").css({
                             "border" : "1px solid #ccc"
                         });
                         break;
                 }



             }, function () {
                 $(that)
                     .html("{$core_lang ,[ profile , personal , saving]}")
                     .prop("disabled" , true );
             });
         });


         $("#logmore").click(function () {
            logfile();
         });


         $("#save_image").click(function () {
              var avatar = ga_tools.get_images("avatar");
              switch(avatar.type)
              {
                  case "image/jpeg":
                  case "image/png":
                      break;
                  default:
                      toastr["warning"]( "{$core_lang , [system,core,request,error_image_upload]}"  ,"{$core_lang , [system,core,request,error_image_upload_title]}");
                      return;
              }
             

             var that       = this;
             var invoke     = {
                 "type"     : avatar.type ,
                 "image"   : avatar.result,
                 "name"     : avatar.name
             };
             $(that).html("{$core_lang ,[ profile , personal , saving]}").attr("disabled" , "disabled");
             let d = property.functions.avatar + property.location;
             ga_request( d
                 , invoke 
                 , function(result){
                     let data = JSON.parse(result);
                     switch(data.error)
                     {
                         case false:
                             toastr["success"]( "{$core_lang,[profile,alerts,updated]}"  , "{$core_lang ,[ profile , alerts , success ]}");
                             $(".profile-userpic").find("img").attr("src" , data.message);
                             $("#header_profile_image").attr("src" , data.message);
                             break;
                         case true:
                             toastr["warning"]( "{$core_lang , [system,core,request,error_image_upload]}"  ,"{$core_lang , [system,core,request,error_image_upload_title]}");
                             break;
                     }

                    $(that).html(" {$core_lang ,[profile , image , save]}").removeAttr("disabled");
             });

         });


         $("#retypepass").on('keyup' , function () {

            let np = $("#newpass").val();
            let rp = $("#retypepass").val();

            if(np != rp)
            {
                $("#savepass").attr("disabled" , "disabled");
                return false;
            }

            if($("#password").val() != '' && np !== '')
            {
                $("#savepass").removeAttr("disabled");
            }else return false;

        });


         $("#savepass").click(function(){

              var that = this;
              $(that).html("{$core_lang ,[ profile , personal , saving]}").attr("disabled" , "disabled");
              let d = property.functions.password + property.location;
              ga_request(d,
                  {
                  oldpass: $("#password").val(),
                  newpass: $("#newpass").val()
              } , function (v) {

                  let c = JSON.parse(v);

                      switch (c.error)
                      {
                          case true :
                              toastr["warning"]( c.message , "");
                              break;
                          case false:
                              toastr["success"]( c.message , "");
                              break;
                      }


                  $(that).html("{$core_lang , [profile , password , change]}")
                         .removeAttr("disabled");

              });

         });

         $("#save_advance").click(function(){

                var that = this;
                let d = property.functions.advance + property.location;
                $(that).html("{$core_lang ,[ profile , personal , saving]}").attr("disabled" , "disabled");
                ga_request(d, {
                    "lang"  : $("#lang-change").val()
                } , function(y){

                     let c = JSON.parse(y);
                     switch(c.error)
                     {
                         case true:
                             toastr["warning"]( c.message , "");
                             break;
                         case false:
                             toastr["success"]( c.message , "");
                             ga_tools.set_lang(c.call);
                             break;
                     }

                     $(that).html("{$core_lang ,[ profile , personal , save]}")
                            .removeAttr("disabled");
                });
         });


        try{
           logfile();
        }catch (e){
            console.log(e);
        }

    })(this.jQuery);
    
</script>


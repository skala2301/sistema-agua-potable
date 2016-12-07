<body class=" login">

    <input type="hidden" id="url" value="<?php echo site_url(); ?>" />
    <!-- BEGIN LOGO -->
    <div class="logo">
        <a href="<?php echo site_url(); ?>">
            <img src="<?php echo $image; ?>" alt="" /> </a>
    </div>
    <!-- END LOGO -->
    <!-- BEGIN LOGIN -->
    <div class="content">
        <!-- BEGIN LOGIN FORM -->
        <?php echo form_open("Dashboard/Request" , 
                [ 
                    "method"        => "post" , 
                    "id"            => "login_form" , 
                    "class"         => "login-form"] , 
                [
                    "dir"       => "system" , 
                    "model"     => "admin_core" , 
                    "function"  => "get_login" , 
                    "lang"      => $lang ?? "en",
                    "token"     => "453gtGJRTOP5600@#FGjkcvbsssaq2"]); ?>
             
            <h3 class="form-title font-green"><?php echo core_lang([ "login", "in"]); ?></h3>
            <div id="class_error" class="alert alert-danger display-hide">
                <button class="close" data-close="alert"></button>
                <span id="error"></span>
            </div>
            <div class="form-group">
                <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                <label class="control-label visible-ie8 visible-ie9"><?php echo core_lang([ "login", "inputs" , "username"]); ?></label>
                <input class="form-control form-control-solid placeholder-no-fix" id="username" type="text" autocomplete="off" placeholder="<?php echo core_lang([ "login", "inputs" , "username"]); ?>" name="username" /> </div>
            <div class="form-group">
                <label class="control-label visible-ie8 visible-ie9"><?php echo core_lang([ "login", "inputs" , "password"]); ?></label>
                <input class="form-control form-control-solid placeholder-no-fix" id="password" type="password" autocomplete="off" placeholder="<?php echo core_lang([ "login", "inputs" , "password"]); ?>" name="password" /> </div>
            <div class="form-actions">
                <button type="submit" class="btn green uppercase"><?php echo core_lang([ "login", "inputs", "login"]); ?></button>
                <label class="rememberme check">
                    <input type="checkbox" name="remember" value="1" /><?php echo core_lang([ "login", "inputs" , "remember"]); ?></label>
                <a href="javascript:;" id="forget-password" class="forget-password"><?php echo core_lang([ "login", "password"]); ?></a>
            </div>
            
            <div class="login-options">
                <ul class="social-icons">
                    <li>
                        <a class="social-icon-color facebook" data-original-title="facebook" href="javascript:;"></a>
                    </li>
                    <li>
                        <a class="social-icon-color twitter" data-original-title="Twitter" href="javascript:;"></a>
                    </li>
                    <li>
                        <a class="social-icon-color googleplus" data-original-title="Goole Plus" href="javascript:;"></a>
                    </li>
                    <li>
                        <a class="social-icon-color linkedin" data-original-title="Linkedin" href="javascript:;"></a>
                    </li>
                </ul>
            </div>

        <?php echo form_close(); ?>
        <!-- END LOGIN FORM -->
        <!-- BEGIN FORGOT PASSWORD FORM -->
          <?php echo form_open("Dashboard/Request" , 
                [ 
                    "method"        => "post" , 
                    "id"            => "login_form_forget" , 
                    "class"         => "forget-form"
                ] ,
                [
                    "dir"       => "system" , 
                    "model"     => "admin_core" , 
                    "function"  => "get_login" , 
                    "lang"      => $lang]); ?>
            <h3 class="font-green"><?php echo core_lang([ "login", "forget"]); ?></h3>
            <p> <?php echo core_lang([ "login", "forgot"]); ?></p>
            <div class="form-group">
                <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email" /> </div>
            <div class="form-actions">
                <button type="button" id="back-btn" class="btn btn-default"><?php echo core_lang([ "login", "inputs" , "back"]); ?></button>
                <button type="submit" class="btn btn-success uppercase pull-right"><?php echo core_lang([ "login", "inputs" , "submit"]); ?></button>
            </div>
        <?php echo form_close(); ?>

    </div>
    <div class="copyright"><?php echo date("Y"); ?> © <?php echo $copyright; ?></div>
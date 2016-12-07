


<?php
$js = print_javascript([
            "jquery",
            "bootstrap",
            "content/assets/global/plugins/js.cookie.min.js",
            "content/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js",
            "content/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js",
            "content/assets/global/plugins/jquery.blockui.min.js",
            "content/assets/global/plugins/uniform/jquery.uniform.min.js",
            "content/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js",
            "content/assets/global/plugins/jquery-validation/js/jquery.validate.min.js",
            "content/assets/global/plugins/jquery-validation/js/additional-methods.min.js",
            "content/assets/global/plugins/select2/js/select2.full.min.js",
            "content/assets/global/scripts/app.min.js",
            "content/assets/themes/theme1/js/login.min.js",
            "boot"
        ], "url");
?>

<?php foreach ($js as $j): ?>
<script src="<?php echo $j; ?>" id="<?php echo random_string('sha1'); ?>" type="text/javascript" ></script>
<?php endforeach; ?>


<script>

 $(document).ready(function(){


   $("#login_form").login({
       "login" : ' <?php echo meta_lang($lang, [ "login", "inputs" , "login"], $file_lang); ?>'
      , "wait" : '   <?php echo  meta_lang($lang, [ "login", "inputs" , "wait"], $file_lang); ?>'
   } , '<?php echo $query; ?>');

    var log = new login();
    log.form();
    Login.init();
 });

</script>

</body>

</html>
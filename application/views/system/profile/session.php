[PageBar ; {"name":"Home" , "url":"<?php echo dashboard_url(); ?>"} , {"name" : "Sesión"} ]

<style>
    .m-heading-1
    {
        margin-top: 10%;
        text-align: center;
    }
</style>

<div class="m-heading-1 border-green m-bordered">
    <h3>¿ <?php echo  $user ?> Seguro que deseas cerrar sesión ?</h3>
    <p>
        Al momento que cierres sesión se borrara todo rastro de cookies y otras cosas mas.
    </p>
    <p>
        si no quiere cerrar sesión <a href="[dashboard_url]">click aca</a>
    </p>
    <p></p>
    <a id="end_session"
                        class="btn blue btn-outline"
                        href="<?php echo site_url() . "/request/end_session/system/end_session" ?>" >Cerrar Sesión</a>
</div>

<script>
    var end =  function()
    {
        ga_request({
            'function'  : 'end_session',
            'dir'       : 'system',
            'model'     : 'end_session'
        },  {} , function (r) {
            window.location.href = "<?php echo site_url();?>" + back_end ;
        });
    };
</script>
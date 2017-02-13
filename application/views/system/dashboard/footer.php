<footer id="ga_foot">
    <!-- SYSTEM CORE JAVASCRIPT -->
    <?php foreach ($js_system as $js): ?>
        <?php echo "<script src='$js' type='text/javascript'></script>"; ?>
    <?php endforeach; ?>
    <!-- END CORE JAVASCRIPT -->
    <!-- SYTEM JAVASCRIPT + BABEL -->
    <?php foreach ($js_babel as $js): ?>
        <?php echo "<script src='$js' type='text/babel'></script>"; ?>
    <?php endforeach; ?>
    <!-- END SYSTEM -->
    <!--SYSTEM FUNCTIONS-->
    <?php foreach ($js_functions as $js): ?>
        <?php echo "<script src='$js' type='text/javascript'></script>"; ?>
    <?php endforeach; ?>
    <!-- END SYSTEM -->
    <!-- APPS JAVASCRIPT -->
    <?php if(isset($js_apps)): ?>
     <?php

        /***
         * cada aplicacion puede tener llamados de javascript
         * aca separa la data por medio de recursividad y expresiones regulares
         * esto significa que hace el mismo proceso que cuando es xhr pero con la ventaja
         * de que los script permaneceran en el DOM ya que no llevan identificadores
        ***/
        function js_lambda($node)
        {
            $preg           = "/<script[\\s\\S]*?>[\\s\\S]*?<\\/script>/";
            $preg_2         = "%^((https?://)|(www\\.))([a-z0-9-].?)+(:[0-9]+)?(/.*)?$%i";

            foreach ($node as $data){

                if(is_array($data) || is_object($data))
                {
                    if(isset($data["type"]) && isset($data['location']))
                    {
                        if($data['location'] == "footer") {
                            if (preg_match($preg, $data['script'])) {
                                echo $data;
                            } else if (preg_match($preg_2, $data['script'])) {
                                echo "<script type='" . $data['type'] . "' src='" . $data['script'] . "' async></script>";
                            }
                        }
                    }else{
                        js_lambda($data);
                    }
                }
                else{
                    if(preg_match($preg , $data))
                    {
                        echo $data;
                    }
                    else if(preg_match($preg_2 , $data))
                    {
                        echo "<script type='text/javascript' src='$data'></script>";
                    }
                }

            }
        }


        //llamamos la funcion recursiva
        js_lambda($js_apps);

        ?>
    <?php endif; ?>
    <!-- END APPS  -->
    <!-- START SYSTEM LOADER SCRIPTS -->
    <script>
        // core functions 
        var core                    = new ga_core();
        //document ready ? or not ready 
        $(document).ready(function(){
            if(entry_ == "dashboard") // if a dashboard exec
                ga_(url_ + back_end); // ga_ is normal function
            core.sidebar_(); // sidebar function 
        });

    </script>


    <!--END SYSTEM LOADER SCRIPT -->
    

</footer>
</body>
</html>
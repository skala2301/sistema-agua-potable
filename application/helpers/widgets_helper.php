<?php

/**
 * @author Rolando Arriaza
 * @todo Widgets for garrobo
 * @shorcode {{[function] , [params]}}
**/



if(!function_exists("PageBar"))
{

    /*echo PageBar([
        array("name" => "Home" , "url" => dashboard_url()),
        array("name" => "Usuario")
    ]);*/

    /***
     * @version 1.0.0
     * @author Rolando Arriaza
     * @since 1.0.0
     * @todo Page Bar widget print a pagebar with params
     * @shortcode example {{[PageBar] , [{ {"name" : "Home" , "url" : "<?php echo dashboard_url(); ?>"} }]}}
    **/
    function PageBar( $items = [
        array( "name" => "Home", "url" => "" , "loc" => true )
    ])
    {
        $items      = object_to_array($items);

        $data       = NULL;
        $data       = '<div class="page-bar">';
        $data      .= ' <ul class="page-breadcrumb">';

        foreach($items as  $item)
        {
            $data .= '<li>';
            if(isset($item['loc']) && $item['loc'] == TRUE)
            {
                $item['url'] = dashboard_url();
                $data .= ' <a href="javascript:ga_(' . "'" . $item['url']  . "'"  . ');">' . $item["name"] . '</a>';
                $data .= ' <i class="fa fa-circle"></i>';
            }
            else if (!isset($item['url']))
            {
                $data .= '<span>' . $item["name"] . '</span>';
            }
            else
            {
                $data .= ' <a href="javascript:ga_(' . "'" . $item['url']  . "'"  . ');">' . $item["name"] . '</a>';
                $data .= ' <i class="fa fa-circle"></i>';
            }
            $data .= '</li>';
        }

        $data      .= '</ul>';
        $data      .= '</div>';

        return $data;
    }
}


if(!function_exists('object_to_array'))
{

    function object_to_array($data)
    {
        if (is_array($data) || is_object($data))
        {
            $result = array();
            foreach ($data as $key => $value)
            {
                $result[$key] = object_to_array($value);
            }
            return $result;
        }
        return $data;
    }
}


if(!function_exists('get_request'))
{

    function get_request($get)
    {
        
         if(is_array($get))
             return "Dashboard/Request/" . $get[0];
         else
            return "Dashboard/Request/" . $get;
    }

}


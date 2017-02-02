<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @version 1.0.4
 * @author Rolando Arriaza
 * @todo Garrobo platform , the best !!!
 * **/

//Ok, include one path more.
include APPPATH . "config/config.php";


//overrides
$route['404_override']              = 'dashboard/error_404';

//uris
$route['translate_uri_dashes']      = FALSE;



//Default controller. how to use; front or back end
$route['default_controller']                                                         = 'dashboard/front';


//front end route config
$route[$config['frontend']->prefix]                                                  = 'Front/index';
$route[$config['frontend']->prefix . "/(:any)"]                                      = 'Front/index/$1';
$route[$config['frontend']->prefix . "/(:any)/(:any)"]                               = 'Front/index/$1/$2';
$route[$config['frontend']->prefix . "/(:any)/(:any)/(:any)"]                        = 'Front/index/$1/$2/$3';

//abstract front route
$route['!/(:any)']                                                                   = 'Front/index_routing/$1';
$route['!/(:any)/(:any)']                                                            = 'Front/index_routing/$1/$2';
$route['!/(:any)/(:any)/(:any)']                                                     = 'Front/index_routing/$1/$2/$3';
$route['!/(:any)/(:any)/(:any)/(:any)']                                              = 'Front/index_routing/$1/$2/$3/$4';



//Dashboard special routes
$route['/(:any)']                         = 'dashboard/front/$1';
$route[$config['backend']]                = 'dashboard/index';
$route[$config['backend'] . '/(:any)']    = 'dashboard/index/$1';


/**
 * @version 1.0
 * @author Rolando arriaza
 * @system routes
 * @todo statics routes , please don´t alter this routes, keep alone.
***/


//garrobo route request function into a controller dashboard
$route['u/request/(:any)/(:any)/(:any)']                        = 'Dashboard/Request/$1/$2/$3';
//garrobo request function not parameters
$route['a/request']                                             = 'Dashboard/Request';
//garrobo request function
$route['request/(:any)/(:any)/(:any)']                          = 'Dashboard/Request/$1/$2/$3';
//garrobo download function
$route['u/download/(:any)/(:any)/(:any)/(:any)']                = 'Dashboard/Download/$1/$2/$3/$4';







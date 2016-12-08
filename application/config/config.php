<?php



defined('BASEPATH') OR exit('No direct script access allowed');
$config['garrobo_version'] = "1.2.5";


/**
 * Files config
**/

$config['data_config_path']                 =  APPPATH . "config/setup.json";
$config['content_core']                     = 'content/system/core/';
$config['login_core']                       = './content/system/files/login_resources.json';
$config['core_lang']                        = '/content/system/files/lang.json';
$config['app_lang']                         = '/content/lang/';



/***
 * @configuration data setup json file
**/

$data_config                = NULL;
$encode_config              = NULL;
if(file_exists($config['data_config_path']))
{
    $data_config            = file_get_contents($config['data_config_path']);
    $encode_config          = $data_config;
    $data_config            = json_decode($data_config);
}


/**
 * @configuration get string json from app , langs and core lang
 * new conf. since september-2016
**/
$config['app_config_encode']                    = $encode_config ?? NULL;
$config['app_languaje_encode']                  = file_exists($config['app_lang']) ? file_get_contents($config['app_lang']) : NULL;
$config['app_languaje_system_encode']           = file_exists($config['core_lang']) ? file_get_contents($config['core_lang']) : NULL;



/*
 * -----------------------------
 * 
 * @author Rolando Arriaza 
 * @todo debug mode
 * ----------------------------
 */

$config['lang_debug']           = TRUE;  // lang debug
$config['system_debug']         = TRUE; //system depuration
$config['email_debug']          = TRUE; //email depuration or debug
$config['mainten_mode']         = (bool) $data_config->mainten ?? FALSE; // maintent mode




/**
 * @author ROlando Arriaza <rolignu90>
 * @add 10-october-2016
**/

$config['ga_json_sidebar'] = "request/gasidebar/system/system_core?type=json";
$config['ga_json_menubar'] = "request/menu/system/system_core?type=json";


/**
 * reflesh the react objects
**/
$config['reflesh']              =  $data_config->reflesh ?? 1000;


/**
 * limit try to send request
**/

$config['request_limit']        = $data_config->request_limit ?? 100;

/**
 * SPANISH : el garrobo configuracion basica del sistema
 * en dado caso quieren dejarlo asi no hay problema 
 * solo se configura directorios y archivos que se necesitan 
 *
 * ENGLISH: the garrobo basic configuration of system
 * in this case required leave its .
 * **/

$config['backend']              = $data_config->backend ?? "0";




/**
 * Front end configuration. return a object or stdclass value
**/
$config['frontend']             = $data_config->front ?? (object) [ "prefix" => "0" , "redirect" => "" , "head" => "" ];


/**
 *  SPANISH:
 *          ga hibrido, si usted desea que las peticiones del sidebar
 *          sea por medio de redireccion ga_ debe de ser cero o si
 *          desea tener el sistema de ga por medio de xhr debe de ser uno
 *
 * ENGLISH :
            ga Hyb , if you want the sidebar requests
            either through redirection Ga must be zero or
            want to have the system through xhr ga must be one
 *
***/

$config['ga_']                  = $data_config->ga_ ?? 1;



/**
 * Routes configuration MVA_ROUTES comming soon try to deprecated
 */
$config['mva_routes']           = "/config/MVA_ROUTES.json";


/**
 * Directorios donde se controlan los logs de errores 
 * **/

$config['log_error'] = "./application/logs/errors/";


/**
 * Error views configurations
 * **/

$config['view_errors'] = array(
    
    "500_"          => "system/errors/500",
    "404_"          => "system/errors/404_error",
    "database"      => "",
    "denied"        => "system/errors/access_denied"
    
);


/**
 * Configuracion basica del sistema , esta configuracion es delicada
 * si algo no esta bien entonces puede que la aplicacion colapse esto 
 * puede causar un grave daño.
 * 
 * SI CAMBIA ALGO DE LA CONFIGURACION RESPETAR SIMBOLOS TALES COMO 
 * / & % () [] etc.
 *
 *
 * $config['setup_']               = array(
"model"              => '',                                               //
"lang"               => './content/lang/',                                //ARCHIVO DE TRADUCCION MULTILENGUAJE
"codename"           => 'Garrobo system' ,                                //NOMBRE CODIGO EVO SYSTEM
"data_config"        => APPPATH . "config/data_setup.json",
"core_lang"          => './content/system/core/files/lang.json',
"main"               => 'index',
"token"              => "="
);
 * 
 * **/

$config['setup_']               = array(    
    "lang"               =>     './content/lang/', // global Language content
    "data_config"        =>      APPPATH . "config/data_setup.json", // data setup
    "core_lang"          =>     './content/system/files/lang.json', // system lang content
    "core_config"        =>     './content/system/files/core.json',
    "plugin_dir"         =>     'plugins', // where plugins installs
    "token"              =>     "=", // token MVA dir=model , plugin=app
    "install"            =>     "ready", // installer
    "main"               =>     "" //main location
);


/**
 * where save the avatar image
**/

$config['avatar_files'] = "./content/system/core/img/users/";
$config['dump_image']   = 'avatar.png';


/**
 * where save system images
**/
$config['system_images'] = "/content/system/core/img/";

/**
 * nombre de la variable sesion 
 * **/

$config['session_name'] = "user";
$config['session_lang'] = "lang";



/***
 * @todo  advance , tokens
 *        this token generate a backdoor request
 *        when the token has read, the functions activate a short moment
 *
 *  how is it used
 *
 *   the key        => function to call into the Dashboard/Request
 *   the value      => where the request comes
 *
 *   example in a form
 *
 *  echo form_open("Dashboard/Request" ,
    [
        "method"        => "post" ,
        "id"            => "login_form" ,
        "class"         => "login-form"] ,
    [
        "dir"       => "system" ,
        "model"     => "admin_core" ,
        "function"  => "get_login" ,
        "lang"      => $lang,
        "token"     => "453gtGJRTOP5600@#FGjkcvbsssaq2"]);
 *
 *
 *
**/
$config['tokens']       = [
    
    "get_login"         => "453gtGJRTOP5600@#FGjkcvbsssaq2"
    
];


/*
|--------------------------------------------------------------------------
| Base Site URL
|--------------------------------------------------------------------------
| If the url not config in the data_setup.php or are empty garrobo framework
| try to create a new url , but is not secure
*/

$url                = current(explode("/", $_SERVER['SERVER_PROTOCOL'])) . "://" .  $_SERVER['SERVER_NAME'] . "/" ;
$op                 = explode("/", $_SERVER['SCRIPT_NAME']);
$op                 = $op[1] ?? NULL;
$url                = strtolower($url . $op . "/");

$config['base_url'] =  isset($data_config->url) ? empty($data_config->url) ? $url : $data_config->url : $url;

/*
|--------------------------------------------------------------------------
| Index File
|--------------------------------------------------------------------------
|
| Typically this will be your index.php file, unless you've renamed it to
| something else. If you are using mod_rewrite to remove the page set this
| variable so that it is blank.
|
*/
$config['index_page'] = '';
//$config['index_page'] = 'index.php';

/*
|--------------------------------------------------------------------------
| URI PROTOCOL
|--------------------------------------------------------------------------
|
| This item determines which server global should be used to retrieve the
| URI string.  The default setting of 'REQUEST_URI' works for most servers.
| If your links do not seem to work, try one of the other delicious flavors:
|
| 'REQUEST_URI'    Uses $_SERVER['REQUEST_URI']
| 'QUERY_STRING'   Uses $_SERVER['QUERY_STRING']
| 'PATH_INFO'      Uses $_SERVER['PATH_INFO']
|
| WARNING: If you set this to 'PATH_INFO', URIs will always be URL-decoded!
*/
$config['uri_protocol']	= 'REQUEST_URI';

/*
|--------------------------------------------------------------------------
| URL suffix
|--------------------------------------------------------------------------
|
| This option allows you to add a suffix to all URLs generated by CodeIgniter.
| For more information please see the user guide:
|
| http://codeigniter.com/user_guide/general/urls.html
*/

$config['url_suffix'] = '';

/*
|--------------------------------------------------------------------------
| Default Language
|--------------------------------------------------------------------------
|
| This determines which set of language files should be used. Make sure
| there is an available translation if you intend to use something other
| than english.
|
*/
$config['language']	= 'english';

/*
|--------------------------------------------------------------------------
| Default Character Set
|--------------------------------------------------------------------------
|
| This determines which character set is used by default in various methods
| that require a character set to be provided.
|
| See http://php.net/htmlspecialchars for a list of supported charsets.
|
*/
$config['charset'] = 'UTF-8';

/*
|--------------------------------------------------------------------------
| Enable/Disable System Hooks
|--------------------------------------------------------------------------
|
| If you would like to use the 'hooks' feature you must enable it by
| setting this variable to TRUE (boolean).  See the user guide for details.
|
*/
$config['enable_hooks'] = TRUE;

/*
|--------------------------------------------------------------------------
| Class Extension Prefix
|--------------------------------------------------------------------------
|
| This item allows you to set the filename/classname prefix when extending
| native libraries.  For more information please see the user guide:
|
| http://codeigniter.com/user_guide/general/core_classes.html
| http://codeigniter.com/user_guide/general/creating_libraries.html
|
*/
$config['subclass_prefix'] = 'MY_';

/*
|--------------------------------------------------------------------------
| Composer auto-loading
|--------------------------------------------------------------------------
|
| Enabling this setting will tell CodeIgniter to look for a Composer
| package auto-loader script in application/vendor/autoload.php.
|
|	$config['composer_autoload'] = TRUE;
|
| Or if you have your vendor/ directory located somewhere else, you
| can opt to set a specific path as well:
|
|	$config['composer_autoload'] = '/path/to/vendor/autoload.php';
|
| For more information about Composer, please visit http://getcomposer.org/
|
| Note: This will NOT disable or override the CodeIgniter-specific
|	autoloading (application/config/autoload.php)
*/
$config['composer_autoload'] = FALSE;

/*
|--------------------------------------------------------------------------
| Allowed URL Characters
|--------------------------------------------------------------------------
|
| This lets you specify which characters are permitted within your URLs.
| When someone tries to submit a URL with disallowed characters they will
| get a warning message.
|
| As a security measure you are STRONGLY encouraged to restrict URLs to
| as few characters as possible.  By default only these are allowed: a-z 0-9~%.:_-
|
| Leave blank to allow all characters -- but only if you are insane.
|
| The configured value is actually a regular expression character group
| and it will be executed as: ! preg_match('/^[<permitted_uri_chars>]+$/i
|
| DO NOT CHANGE THIS UNLESS YOU FULLY UNDERSTAND THE REPERCUSSIONS!!
|
*/
$config['permitted_uri_chars'] = '';


/*
|--------------------------------------------------------------------------
| Enable Query Strings
|--------------------------------------------------------------------------
|
| By default CodeIgniter uses search-engine friendly segment based URLs:
| example.com/who/what/where/
|
| By default CodeIgniter enables access to the $_GET array.  If for some
| reason you would like to disable it, set 'allow_get_array' to FALSE.
|
| You can optionally enable standard query string based URLs:
| example.com?who=me&what=something&where=here
|
| Options are: TRUE or FALSE (boolean)
|
| The other items let you set the query string 'words' that will
| invoke your controllers and its functions:
| example.com/index.php?c=controller&m=function
|
| Please note that some of the helpers won't work as expected when
| this feature is enabled, since CodeIgniter is designed primarily to
| use segment based URLs.
|
*/
$config['allow_get_array'] = TRUE;
$config['enable_query_strings'] = FALSE;
$config['controller_trigger'] = 'c';
$config['function_trigger'] = 'm';
$config['directory_trigger'] = 'd';

/*
|--------------------------------------------------------------------------
| Error Logging Threshold
|--------------------------------------------------------------------------
|
| If you have enabled error logging, you can set an error threshold to
| determine what gets logged. Threshold options are:
| You can enable error logging by setting a threshold over zero. The
| threshold determines what gets logged. Threshold options are:
|
|	0 = Disables logging, Error logging TURNED OFF
|	1 = Error Messages (including PHP errors)
|	2 = Debug Messages
|	3 = Informational Messages
|	4 = All Messages
|
| You can also pass an array with threshold levels to show individual error types
|
| 	array(2) = Debug Messages, without Error Messages
|
| For a live site you'll usually only enable Errors (1) to be logged otherwise
| your log files will fill up very fast.
|
*/
$config['log_threshold'] = $data_config->log->active ?? 0;

/*
|--------------------------------------------------------------------------
| Error Logging Directory Path
|--------------------------------------------------------------------------
|
| Leave this BLANK unless you would like to set something other than the default
| application/logs/ directory. Use a full server path with trailing slash.
|
*/
$config['log_path'] = $data_config->log->path ?? "";

/*
|--------------------------------------------------------------------------
| Log File Extension
|--------------------------------------------------------------------------
|
| The default filename extension for log files. The default 'php' allows for
| protecting the log files via basic scripting, when they are to be stored
| under a publicly accessible directory.
|
| Note: Leaving it blank will default to 'php'.
|
*/
$config['log_file_extension'] = $data_config->log->extension ?? "";

/*
|--------------------------------------------------------------------------
| Log File Permissions
|--------------------------------------------------------------------------
|
| The file system permissions to be applied on newly created log files.
|
| IMPORTANT: This MUST be an integer (no quotes) and you MUST use octal
|            integer notation (i.e. 0700, 0644, etc.)
*/
$config['log_file_permissions'] = $data_config->log->permission ?? 0644;

/*
|--------------------------------------------------------------------------
| Date Format for Logs
|--------------------------------------------------------------------------
|
| Each item that is logged has an associated date. You can use PHP date
| codes to set your own date formatting
|
*/
$config['log_date_format'] = $data_config->date->format ?? "Y-m-d H:i:s";

/*
|--------------------------------------------------------------------------
| Error Views Directory Path
|--------------------------------------------------------------------------
|
| Leave this BLANK unless you would like to set something other than the default
| application/views/errors/ directory.  Use a full server path with trailing slash.
|
*/
$config['error_views_path'] = $data_config->views->error ?? "";

/*
|--------------------------------------------------------------------------
| Cache Directory Path
|--------------------------------------------------------------------------
|
| Leave this BLANK unless you would like to set something other than the default
| application/cache/ directory.  Use a full server path with trailing slash.
|
*/
$config['cache_path'] = $data_config->cache->path ?? '';

/*
|--------------------------------------------------------------------------
| Cache Include Query String
|--------------------------------------------------------------------------
|
| Set this to TRUE if you want to use different cache files depending on the
| URL query string.  Please be aware this might result in numerous cache files.
|
*/
$config['cache_query_string'] = FALSE;

/*
|--------------------------------------------------------------------------
| Encryption Key
|--------------------------------------------------------------------------
|
| If you use the Encryption class, you must set an encryption key.
| See the user guide for more info.
|
| http://codeigniter.com/user_guide/libraries/encryption.html
|
*/
$config['encryption_key'] = 'abcdesd1234esfr24dfgbvdf2qwdfgew';

/*
|--------------------------------------------------------------------------
| Session Variables
|--------------------------------------------------------------------------
|
| 'sess_driver'
|
|	The storage driver to use: files, database, redis, memcached
|
| 'sess_cookie_name'
|
|	The session cookie name, must contain only [0-9a-z_-] characters
|
| 'sess_expiration'
|
|	The number of SECONDS you want the session to last.
|	Setting to 0 (zero) means expire when the browser is closed.
|
| 'sess_save_path'
|
|	The location to save sessions to, driver dependant.
|
|	For the 'files' driver, it's a path to a writable directory.
|	WARNING: Only absolute paths are supported!
|
|	For the 'database' driver, it's a table name.
|	Please read up the manual for the format with other session drivers.
|
|	IMPORTANT: You are REQUIRED to set a valid save path!
|
| 'sess_match_ip'
|
|	Whether to match the user's IP address when reading the session data.
|
| 'sess_time_to_update'
|
|	How many seconds between CI regenerating the session ID.
|
| 'sess_regenerate_destroy'
|
|	Whether to destroy session data associated with the old session ID
|	when auto-regenerating the session ID. When set to FALSE, the data
|	will be later deleted by the garbage collector.
|
| Other session cookie settings are shared with the rest of the application,
| except for 'cookie_prefix' and 'cookie_httponly', which are ignored here.
|
*/
$config['sess_driver'] = 'database';
//$config['sess_driver'] = 'database';
$config['sess_cookie_name'] = 'que_vaciles';
$config['sess_expiration'] = 7200;


/**
 * SESS_SAVE_PATH ON SERVER:
 * 
 * ARVIXE , HOSTGATOR , ETC ...
 * $config['sess_save_path'] = 'directorio_sesion';
 * $config['sess_save_path'] =  'database';
 * 
 * GODADDY
 * $config['sess_save_path'] = '/home/unitee/public_html/soft/application/DIRECTORIO_X';
 * 
 * 
 * **/
$config['sess_save_path'] = 'ga_sessions' ; //'sessions'; //'db_sessions';
$config['sess_match_ip'] = FALSE;
$config['sess_time_to_update'] = 300;
$config['sess_regenerate_destroy'] = FALSE;

/*
|--------------------------------------------------------------------------
| Cookie Related Variables
|--------------------------------------------------------------------------
|
| 'cookie_prefix'   = Set a cookie name prefix if you need to avoid collisions
| 'cookie_domain'   = Set to .your-domain.com for site-wide cookies
| 'cookie_path'     = Typically will be a forward slash
| 'cookie_secure'   = Cookie will only be set if a secure HTTPS connection exists.
| 'cookie_httponly' = Cookie will only be accessible via HTTP(S) (no javascript)
|
| Note: These settings (with the exception of 'cookie_prefix' and
|       'cookie_httponly') will also affect sessions.
|
*/
$config['cookie_prefix']	= '';
$config['cookie_domain']	= '';
$config['cookie_path']		= '/';
$config['cookie_secure']	= FALSE;
$config['cookie_httponly'] 	= FALSE;

/*
|--------------------------------------------------------------------------
| Standardize newlines
|--------------------------------------------------------------------------
|
| Determines whether to standardize newline characters in input data,
| meaning to replace \r\n, \r, \n occurences with the PHP_EOL value.
|
| This is particularly useful for portability between UNIX-based OSes,
| (usually \n) and Windows (\r\n).
|
*/
$config['standardize_newlines'] = FALSE;

/*
|--------------------------------------------------------------------------
| Global XSS Filtering
|--------------------------------------------------------------------------
|
| Determines whether the XSS filter is always active when GET, POST or
| COOKIE data is encountered
|
| WARNING: This feature is DEPRECATED and currently available only
|          for backwards compatibility purposes!
|
*/
$config['global_xss_filtering'] =  false;

/*
|--------------------------------------------------------------------------
| Cross Site Request Forgery
|--------------------------------------------------------------------------
| Enables a CSRF cookie token to be set. When set to TRUE, token will be
| checked on a submitted form. If you are accepting user data, it is strongly
| recommended CSRF protection be enabled.
|
| 'csrf_token_name' = The token name
| 'csrf_cookie_name' = The cookie name
| 'csrf_expire' = The number in seconds the token should expire.
| 'csrf_regenerate' = Regenerate token on every submission
| 'csrf_exclude_uris' = Array of URIs which ignore CSRF checks
*/
$config['csrf_protection'] = FALSE;
$config['csrf_token_name'] = 'csrf_test_name';
$config['csrf_cookie_name'] = 'csrf_cookie_name';
$config['csrf_expire'] = 7200;
$config['csrf_regenerate'] = TRUE;
$config['csrf_exclude_uris'] = array();

/*
|--------------------------------------------------------------------------
| Output Compression
|--------------------------------------------------------------------------
|
| Enables Gzip output compression for faster page loads.  When enabled,
| the output class will test whether your server supports Gzip.
| Even if it does, however, not all browsers support compression
| so enable only if you are reasonably sure your visitors can handle it.
|
| Only used if zlib.output_compression is turned off in your php.ini.
| Please do not use it together with httpd-level output compression.
|
| VERY IMPORTANT:  If you are getting a blank page when compression is enabled it
| means you are prematurely outputting something to your browser. It could
| even be a line of whitespace at the end of one of your scripts.  For
| compression to work, nothing can be sent before the output buffer is called
| by the output class.  Do not 'echo' any values with compression enabled.
|
*/
$config['compress_output'] = FALSE;

/*
|--------------------------------------------------------------------------
| Master Time Reference
|--------------------------------------------------------------------------
|
| Options are 'local' or any PHP supported timezone. This preference tells
| the system whether to use your server's local time as the master 'now'
| reference, or convert it to the configured one timezone. See the 'date
| helper' page of the user guide for information regarding date handling.
|
*/
$config['time_reference'] = $data_config->date->reference ?? 'local';

/*
|--------------------------------------------------------------------------
| Rewrite PHP Short Tags
|--------------------------------------------------------------------------
|
| If your PHP installation does not have short tag support enabled CI
| can rewrite the tags on-the-fly, enabling you to utilize that syntax
| in your view files.  Options are TRUE or FALSE (boolean)
|
*/
$config['rewrite_short_tags'] = FALSE;


/*
|--------------------------------------------------------------------------
| Reverse Proxy IPs
|--------------------------------------------------------------------------
|
| If your server is behind a reverse proxy, you must whitelist the proxy
| IP addresses from which CodeIgniter should trust headers such as
| HTTP_X_FORWARDED_FOR and HTTP_CLIENT_IP in order to properly identify
| the visitor's IP address.
|
| You can use both an array or a comma-separated list of proxy addresses,
| as well as specifying whole subnets. Here are a few examples:
|
| Comma-separated:	'10.0.1.200,192.168.5.0/24'
| Array:		array('10.0.1.200', '192.168.5.0/24')
*/
$config['proxy_ips'] = $data_config->proxy ?? '';


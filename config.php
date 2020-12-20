<?php
#Set date
date_default_timezone_set("Europe/Dublin");
#Directories
define('PS', PATH_SEPARATOR);
define('DS', DIRECTORY_SEPARATOR);
define('BASE_DIR', dirname( __FILE__ ) . DS);	
define("PATH", "project/");

#Config of DB
define("PDO_HOST", "127.0.0.1");
define("PDO_USER", "root");
define("PDO_DB", "project_webapp");
define("PDO_PASS", "");
define("PDO_DRIVER", "mysql");
define("PDO_PORT", "3306");

#Search all models inside models folder and includes it automatically
define("DIR_CLASSES", BASE_DIR . DS . '../models'. DS);
spl_autoload_register(function($className) {
	$className = str_replace("\\", DIRECTORY_SEPARATOR, $className);		
	include_once DIR_CLASSES. $className . '.php';
});

#Instaciando classes
$db = new Db(); //start connection with db
$ses = new Session(); //start a Session to verify login
$url = new Url(); //start class of URL where you can get and pass parameters

$ses->start(); // START session
$pagina = $url->getURL(0); // set null or home for variable pagina

//checks if user has a session logged
function isLoggedin() {
    global $ses;
    return @count($ses->getNode('logged')) > 1 ? true : false;
}
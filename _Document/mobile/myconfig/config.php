<?

ob_start();

error_reporting(E_ALL & ~E_NOTICE);

header("X-Powered-By: Silkrouters.com");

@session_start();



if (substr_count($_SERVER['HTTP_HOST'], "localhost")) {

    $vpath = "http://localhost/flowerwyz/";
    $apath = $_SERVER['DOCUMENT_ROOT'] . "/flowerwyz/";
    $calendar_new_path = "/calendar_new/";
    $captcha_path = "/captcha/";
    $fckapath = $apath . "fckeditor/";
    $fckbasepath = $vpath . "fckeditor/";
    define("USERNAME", 'root');
    define("PASSWORD", '');
    define("DBNAME", 'flower');
    define("HOST", 'localhost');
} else {

    $vpath = "http://" . $_SERVER['HTTP_HOST'] . "/";
    $apath = $_SERVER['DOCUMENT_ROOT'] . "/";
    $fckapath = $_SERVER['DOCUMENT_ROOT'] . "/fckeditor/mobile/";
    $fckbasepath = $vpath . "fckeditor/";
  
    
    define("USERNAME", 'decors_flwyzer');
    define("PASSWORD", '5Tg3WYz!4');
    define("DBNAME", 'decors_flwyzer');
    define("HOST", 'localhost');
}



$dbh = @mysql_connect(HOST, USERNAME, PASSWORD) or die('I cannot connect to the database because: ' . mysql_error());
$db = @mysql_select_db(DBNAME, $dbh) or die('I cannot connect to the database because: ' . mysql_error());



// Site Name ( not Site Title )

$dotcom = "flowerwyz.com";

$dark2 = "#344743";

$dark = "#38b3dc";

$light = "#e9f3fb";

$lightgray = "#c0c0c0";

$graywhite = "#D6C6C5";

$graywhite2 = "#e9e9e9";

/* * *****

  Tables

 * ****** */

define("TABLE_PRODUCT",'products');
define("TABLE_IMAGE",'images');
define("TABLE_LOG",'log');
define("TABLE_ADD_PRODUCT",'add_products');
define("TABLE_DELETE_PRODUCT",'delete_products');
define("TABLE_STATIC_DELETE_PRODUCT",'delete_static_products');
define("TABLE_STATIC_ADD_PRODUCT",'add_static_products');
/*
 * API Set
 */
define("API_USER",'312495');
define("API_PASSWORD",'vIC6Lk');

?>
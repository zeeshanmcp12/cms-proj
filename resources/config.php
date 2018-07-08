<?php 

//Ouput buffering is on
ob_start();

//Session started
session_start();

defined("DS") ? null : define("DS", DIRECTORY_SEPARATOR);   //ye line directory structure set kardegi, means windows main \ or linux main / so DS will be our /(forward slash) or \(backslash)

//echo __DIR__;   //ye constant hai jo hame server ka full path display karega resources folder tak.
//above one will show the directory

//echo __FILE__; ye folder or file dono display karayega.

                            //Defining Path with Constants

defined("TEMPLATE_FRONT") ? null : define("TEMPLATE_FRONT", __DIR__ . DS . "templates/front");

defined("TEMPLATE_BACK") ? null : define("TEMPLATE_BACK", __DIR__ . DS . "templates/back");

// echo TEMPLATE_FRONT; //Output: D:\xampp\htdocs\cms-proj\resources\templates/front

                            //Defining Paths and Database connection with Constants

defined("DB_HOST") ? null : define("DB_HOST", "localhost");

defined("DB_USER") ? null : define("DB_USER", "root");

defined("DB_PASS") ? null : define("DB_PASS", "");

defined("DB_NAME") ? null : define("DB_NAME", "cms-cwc_db");

                            //Making DB connection
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

//ham config.php file ko constantly use karenge because to include everything so functions.php file ko require_once function k sath use karliya so hame ye har jaga available ho.
require_once("functions.php");




?>
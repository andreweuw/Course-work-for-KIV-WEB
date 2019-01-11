<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
<?php
require_once "vendor/autoload.php";
$loader = new Twig_Loader_Filesystem("sablony");
$twig = new Twig_Environment($loader, array());
//Presun do volani render do Controlleru
//echo $twig->render("sablona1.htm", array("obsah" => $obsah, "pages" => $pages));

// vlastni funkce
include("inc/functions.php");

//konfiguracni soubor
include("inc/settings.php");

// nacteni parametru z URL
if (isset($_REQUEST["page"])) {
    $page = $_REQUEST["page"];
} else {
    $page = "uvod";
}

// struktura stranek
$pages = array();
$pages["uvod"] = "Úvod";
$pages["kontakt"] = "Kontakt";
$pages["notFound"] = "404 stránka nenalezena";

//baseModel
include_once("models/baseModel.php");
include_once("models/userModel.php");

$user = new userModel();
$user->Connect();

//modely do containeru
$containerOfModels = array();
$containerOfModels["user"] = $user;

// automaticka volba controlleru
if (array_key_exists($page, $pages)) {
    $filename = "$page.php";
} else {
    $filename = "notFound.php";
}
/*
if ($page == "uvod")
    $filename = "uvod.php";
else if ($page == "kontakt")
    $filename = "kontakt.php";
*/
//include("controllers/$filename");
$params = array();
$params["a"] = 5;
$params["b"] = 3;
$params["page"] = $page;
$params["pages"] = $pages;
//$obsah = phpWrapperFromFile("controllers/$filename", $params);

// include zakladniho controlleru
include_once("controllers/baseController.php");

if (array_key_exists($page, $pages)) {
    $ctrl_name = $page . "Controller";
} else {
    $ctrl_name = "notFoundController";
}

$filename_ctrl = "controllers/$ctrl_name.php";

if (file_exists($filename_ctrl) && !is_dir($filename_ctrl)) {
    include_once($filename_ctrl);
    //echo "mam controller, ale nic nedelam";
    //promenna $uvodController = new uvodController($twig);
    //udelam promennou z nazvu controlleru
    //vzdy vytvorim controller tomu, co zrovna potrebuju
    $$ctrl_name = new $ctrl_name($twig, $containerOfModels);

    $$ctrl_name->indexAction($params);
} else {
    echo "Chyba: controller $filename_ctrl nenalezen!";
}
?>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>


















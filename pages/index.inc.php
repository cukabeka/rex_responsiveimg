<?php

$Basedir = dirname(__FILE__);

$page = rex_request("page", "string");
$subpage = rex_request("subpage", "string");
$func = rex_request("func", "string");


include_once $REX["INCLUDE_PATH"]."/layout/top.php";

$subpages = array(
    array("", "Einstellungen"),
);


rex_title($REX['ADDON']['name']['responsiveimg'], $subpages);

switch($subpage) {
case "":
require $Basedir ."/settings.inc.php";
break;
default:
require $Basedir ."/settings.inc.php";
}
include_once $REX["INCLUDE_PATH"]."/layout/bottom.php";

?>
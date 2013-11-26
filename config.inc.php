<?php

$mypage = 'responsiveimg'; #name fuer weitere programmierung
$REX['ADDON']['rxid'][$mypage] = 'responsiveimg'; #addon-key von redaxo-webseite
$REX['ADDON']['page'][$mypage] = $mypage; # zum Erzeugen von Backend-Urls
$REX['ADDON']['name'][$mypage] = 'ResponsiveImg'; # name fuer Anzeige
$REX['ADDON']['perm'][$mypage] = 'responsiveimg[]'; # fuer Benutzerrechte
$REX['PERM'][] = 'responsiveimg[]';
$REX['ADDON']['version'][$mypage] = '1.0.1';
$REX['ADDON']['author'][$mypage] = 'NGW';

require_once ($REX['INCLUDE_PATH'].'/addons/responsiveimg/functions/functions.ep.inc.php');

if(!$REX['REDAXO']) {
	rex_register_extension('OUTPUT_FILTER', 'ep_include_responsiveimg');
	rex_register_extension('OUTPUT_FILTER', 'ep_replace_responsiveimg');
}
else {
	rex_register_extension('REX_FORM_SAVED', 'ep_generate_responsiveimg_js');
	rex_register_extension('REX_FORM_DELETED', 'ep_generate_responsiveimg_js');
}


?>
<?php

function ep_include_responsiveimg($params) {
	global $REX;
	
	$out = $params['subject'];
	
	$tmp = '<script src="'.$REX['HTDOCS_PATH'].'files/addons/responsiveimg/breakpoint.js"></script><script src="'.$REX['HTDOCS_PATH'].'index.php?responsiveimg_js=true"></script></head>';
	$out = str_replace('</head>', $tmp, $out);
	return $out;
}


function ep_generate_responsiveimg_js($params) {
	global $REX;

	$sql = rex_sql::factory();
	$sql->getArray('SELECT DISTINCT minwidth FROM '.$REX['TABLE_PREFIX'].'responsiveimg ORDER BY minwidth ASC');
	$breakpoints = array();
	$breakpoints[] = 1;
	if($sql->getRows()>0) {
	    for($i=0;$i<$sql->getRows();$i++) {
		    $breakpoints[] = $sql->getValue('minwidth');
		    $sql->next();
	    }
	}

	$out = '
$(window).setBreakpoints({
// use only largest available vs use all available
    distinct: true, 
// array of widths in pixels where breakpoints
// should be triggered
    breakpoints: [
    	'.implode(',', $breakpoints).'
    ] 
});';

	foreach($breakpoints as $breakpoint) {
		$out .= '
$(window).bind("enterBreakpoint'.$breakpoint.'",function() {';

		if($breakpoint==1) {
			$out .= '
	$("img.responsiveimg").each(function() {
		$(this).attr("src", $(this).data("'.$breakpoint.'px"))
	 });';
		}
		else {
			$sql = rex_sql::factory();
			$sql->getArray('SELECT * FROM '.$REX['TABLE_PREFIX'].'responsiveimg WHERE minwidth='.$breakpoint);	
			if($sql->getRows()>0) {
			    for($i=0;$i<$sql->getRows();$i++) {

			    $out .= '
	$("img.responsiveimg").each(function() {
		$(this).attr("src", $(this).data("'.$breakpoint.'px"))
	});';


			    $sql->next();
			    }
			}
		}
		$out .= '
});';
	}
	return $out;
	
}



function ep_replace_responsiveimg($params) {
	global $REX;
	$out = $params['subject'];
	// JS im Header
	$sql = rex_sql::factory();
	$sql->getArray('SELECT * FROM '.$REX['TABLE_PREFIX'].'responsiveimg ORDER BY mobile_first ASC, minwidth ASC');
	$tmp_array = array();
	if($sql->getRows()>0) {
	    for($i=0;$i<$sql->getRows();$i++) {
	    $tmp_array[$sql->getValue('mobile_first')][intval($sql->getValue('minwidth'))] = $sql->getValue('responsive');
    	#$out = preg_replace('#src="index.php\?rex_img_type='.$sql->getValue('default_type').'&rex_img_file=(.*)"#', 'class="hisrc" src="index.php?rex_img_type='.$sql->getValue('mobile_type').'&rex_img_file=\1" data-1x="index.php?rex_img_type='.$sql->getValue('default_type').'&rex_img_file=\1" data-2x="index.php?rex_img_type='.$sql->getValue('retina_type').'&rex_img_file=\1"', $out);
	    $sql->next();
	    }
	}
	foreach ($tmp_array as $m1 => $breakpoints) {
		$alternate_src = 'class="responsiveimg" src="index.php?rex_img_type='.$m1.'&rex_img_file=\1" data-1px="index.php?rex_img_type='.$m1.'&rex_img_file=\1" ';
		foreach ($breakpoints as $minwidth => $responsive) {
			$alternate_src .= 'data-'.$minwidth.'px="index.php?rex_img_type='.$responsive.'&rex_img_file=\1" ';
		}
		$out = preg_replace('#src="index.php\?rex_img_type='.$m1.'&rex_img_file=([a-zA-Z0-9-_\.]*)"#', $alternate_src, $out);
	}
	return $out;
}
	
?>
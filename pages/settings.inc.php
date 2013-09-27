<?php


$debug = false;
if($func=='add' || $func=='edit') {
	$form = rex_form::factory($REX['TABLE_PREFIX'].'responsiveimg', 'Bildtypen festlegen', 'id='.$id, 'post', $debug);
	
	$field =& $form->addSelectField('mobile_first');
	$field->setLabel("Hauptbild (Mobile first)");
	$select =& $field->getSelect();
	$select->setSize(1);
	$sql = rex_sql::factory();
	$sql->getArray('SELECT name FROM '.$REX['TABLE_PREFIX'].'679_types ORDER BY name ASC');
	
	if($sql->getRows()>0) {
	    for($i=0;$i<$sql->getRows();$i++) {
	    $select->addOption($sql->getValue('name'),$sql->getValue('name'));
	    $sql->next();
	    }
	}
	$select->setAttribute('style','width:50%');

	$field = &$form->addTextField('minwidth');
	$field->setLabel("Mindestbreite (PX)");

	$field =& $form->addSelectField('responsive');
	$field->setLabel("Responsive");
	$select =& $field->getSelect();
	$select->setSize(1);
	$sql = rex_sql::factory();
	$sql->getArray('SELECT name FROM '.$REX['TABLE_PREFIX'].'679_types ORDER BY name ASC');
	
	if($sql->getRows()>0) {
	    for($i=0;$i<$sql->getRows();$i++) {
	    $select->addOption($sql->getValue('name'),$sql->getValue('name'));
	    $sql->next();
	    }
	}
	$select->setAttribute('style','width:50%');

	if($func == 'edit') $form->addParam('id', $id);
	$form->show();
}
else {
	$list = new rex_list('SELECT id, mobile_first, minwidth, responsive FROM '.$REX['TABLE_PREFIX'].'responsiveimg ORDER BY mobile_first ASC, minwidth ASC',10000, '', $debug);

	$list->removeColumn('id');
	$list->setColumnLabel('mobile_first', "Hauptbild (Mobile first)");
	$list->setColumnLabel('minwidth', "Mindestbreite");
	$list->setColumnLabel('responsive', "Img-Type");

	$imgHeader = '<a href="'. $list->getUrl(array('func' => 'add')) .'"><img src="media/document_plus.gif" alt="add" title="add" /></a>';
	$list->addColumn($imgHeader,'<img src="media/document.gif" alt="Details" title="Details" />', 0, array('<th class="rex-icon">###VALUE###</th>','<td class="rex-icon">###VALUE###</td>'));
	$list->setColumnParams ( $imgHeader, array('func' => 'edit', 'id' => '###id###') );

	$list->show();	
}
?>
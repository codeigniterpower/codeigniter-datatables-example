<?php

/** vista que pinta la parte de formulario para pedir algun filtro en presentacion de data */
 
	$this->load->helper(array('form', 'url','html','inflector'));

	echo form_fieldset('Existecia diaria general') . PHP_EOL;

	$htmlformaattributos = array('name'=>'oaexistenciaform1filtros');
	echo form_open_multipart('datatables/verdata', $htmlformaattributos) . PHP_EOL;

	echo br().form_submit('datatables_obtener', '(Re)Consultar', 'class="btn-primary btn"');

	echo form_close() . PHP_EOL;

	echo form_fieldset_close();

?>

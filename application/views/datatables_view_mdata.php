	<?php

/** vista que pinta la presentacion de data enlaza lso scripts datatables y renderiza los datos */

	echo '<link rel="stylesheet" type="text/css" href="'.base_url('assets/datatables/datatables.min.css').'"/>'.PHP_EOL;
	echo '<script type="text/javascript" src="'.base_url('assets/datatables/datatables.min.js').'"></script>'.PHP_EOL;

	echo "<!-- ini tabla datatables -->";

		$cabeceras_columns = array_keys($arrayresultset_datatable_inicia[0]);
		$tablehtmldata = "<table id=\"oaexistenciasabana\" class=\"table table-bordered table-striped table-hover\">";
		$tablehtmldata .= "<thead>";
			$tablehtmldata .= "<tr>";
			foreach(cabeceras_columns as $keyrow=>$columnanombre)
				$tablehtmldata .= "<th>" . mb_convert_encoding($columnanombre, "UTF-8", "Windows-1252") . "</th>";
			$tablehtmldata .= "</tr>";
		$tablehtmldata .= "</thead>";
		$tablehtmldata .= "<tbody></tbody>";
		$tablehtmldata .= "</table>";
		
		echo $tablehtmldata;

		$tablehtmljscript = "<script type=\"text/javascript\">";
		$tablehtmljscript .= "
				$(document).ready(function() {
					$('#oaexistenciasabana').DataTable({
						\"pageLength\" : 4,
						\"processing\" : true,
						\"serverSide\": true,
						\"ajax\": {
							url : \"".site_url("datatables/obtenerdata_porjson") ."\",
							type : 'GET'
						},
					});
				});";
		$tablehtmljscript .= "</script>";
		
		echo $tablehtmljscript;

	echo "<!-- fin div/div/div tabla sabana data -->";
	

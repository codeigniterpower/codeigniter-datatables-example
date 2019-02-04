<?php
/**
 * @autor       Tyrone Lucero
 * @package     datatables_model
 * @Descripción Modelo para acceder a base de datos y toda operacion a db fuera del controlador
 * @Fecha: 22 diciembre 2018
 */ 
class datatables_model extends CI_Model {

	public $ladb; // este objeto representa la db abstraida o representada en un objeto

	public function __construct() 
	{
		parent::__construct();
	}

	/**
	 * @name        ini_data
	 * @description si accede la db crea/inicia la tabla que se usuara en el ejemplo
	 * @access      public
	 * @return      void
	 */
	public function ini_data()
	{
		$this->ladb = $this->load->database('tableexample', TRUE);
		$driverconected = $this->ladb->initialize();

		$sqlejecutar = "CREATE TABLE IF NOT EXISTS tabledata (col-key TEXT,col1-data TEXT);";
		$sqlresult = $this->ladb->simple_query($sqlejecutar);
		if($sqlresult !== FALSE AND $sqlresult !== NULL)
		{
			$sqlejecutar="";
			$sqlejecutar.="insert into tabledata (col-key, col1-data) values ('pepe', 'valor 1');";
			$sqlejecutar.="insert into tabledata (col-key, col1-data) values ('pablo', 'valor 2');";
			$sqlejecutar.="insert into tabledata (col-key, col1-data) values ('pedro', 'valor 3');";
			$sqlejecutar.="insert into tabledata (col-key, col1-data) values ('lapa', 'valor 4');";
			$sqlejecutar.="insert into tabledata (col-key, col1-data) values ('luis', 'valor 5');";
			$sqlejecutar.="insert into tabledata (col-key, col1-data) values ('popo', 'valor 6');";
			$sqlejecutar.="insert into tabledata (col-key, col1-data) values ('piblo', 'valor 7');";
			$sqlejecutar.="insert into tabledata (col-key, col1-data) values ('pudo', 'valor 8');";
			$sqlejecutar.="insert into tabledata (col-key, col1-data) values ('lepe', 'valor 9');";
			$sqlejecutar.="insert into tabledata (col-key, col1-data) values ('luisa', 'valor 10');";
			$sqlresult = $this->ladb->simple_query($sqlejecutar);
			return $sqlresult;
		}
		return FALSE;
	}

	/**
	 * @name        get_columnas
	 * @description autodetecta o obtiene las columnas a mostrar antes de obtener la data
	 * @access      public
	 * @return      string "codigo,descripcon etc etc" segun autodetectado o configurado cn set_columnas
	 */
	public function get_columnas()
	{
		$this->ladb = $this->load->database('tableexample', TRUE);
		$driverconected = $this->ladb->initialize();

		if($this->filtrocolumnas == NULL) $this->filtrocolumnas = '*';
		$sqlejecutar = "SELECT ".$this->filtrocolumnas." FROM tabledata LIMIT 1 OFFSET 0";
		$sqlresult = $this->ladb->query($sqlejecutar);
		$resultarray = $sqlresult->result_array();
		$arraycolumnas = array_keys($resultarray[0]);
		if(is_array($arraycolumnas))
		{
			$this->filtrocolumnas = '';
			foreach($arraycolumnas as $indexcolum=>$columnanombre)
				$this->filtrocolumnas .= mb_convert_encoding($columnanombre, "UTF-8", "Windows-1252") . ",";
		}
		$this->filtrocolumnas = substr($this->filtrocolumnas, 0, -1);
		return $this->filtrocolumnas;
	}

	/**
	 * @name        set_columnas
	 * @description asigna las columnas a mostrar antes de extraer data
	 * @access      public
	 * @param       mixed  $filtrocolumnas     arreglo o string de las columnas que se quieren usar desde al tabla tr_existencia_global
	 * @return      void
	 */
	public function set_columnas($filtrocolumnas = NULL)
	{
		// autodeteccion de las columnas deseadas o filtrar
		$filtrocolumnas = $filtrocolumnas === null ? $this->filtrocolumnas : $filtrocolumnas;
		$filtrocolumnas = trim($filtrocolumnas) == '' ? $this->filtrocolumnas : $filtrocolumnas;
		// asignacion de valores o sino usando las por defecto
		if(!is_array($filtrocolumnas)) $this->filtrocolumnas = $filtrocolumnas;
		// asignacion de multivalores o sino usando las por defecto
		if(is_array($filtrocolumnas))
		{
			$this->filtrocolumnas = '';
			foreach($filtrocolumnas as $indexcolum=>$columnanombre)
				$this->filtrocolumnas .= mb_convert_encoding($columnanombre, "UTF-8", "Windows-1252") . ",";
		}
		$this->filtrocolumnas = substr($this->filtrocolumnas, 0, -1);
	}

	/**
	 * @name        count_data
	 * @description cuenta el total en la tabla en db
	 * @access      public
	 * @param       string  $cuantos   cuantos registros devuelve esta consulta en sync con la funcon de total
	 * @return      int   count
	 */
	public function count_data()
	{
		$this->ladb = $this->load->database('tableexample', TRUE);
		$driverconected = $this->ladb->initialize();

		$sqlejecutar = "SELECT count(*) as cuantos FROM tabledata";
		$sqlresult = $this->ladb->query($sqlejecutar);
		$arreglo_reporte = $sqlresult->result_array();
		$cuantos = $arreglo_reporte['0']['cuantos'];

		return $cuantos;
	}

	/**
	 * @name        get_data
	 * @description obtiene en crudo el resultado de la tabla en db
	 * @access      publicdboa
	 * @param       string  $cuantos   cuantos registros devuelve esta consulta
	 * @param       string  $iniciar   desde que indice se devuelve los registros
	 * @return      array   array(col1, valor1, etc aprox)
	 */
	public function get_data($cuantos = 1, $iniciar = 0)
	{
		$this->ladb = $this->load->database('tableexample', TRUE);
		$driverconected = $this->ladb->initialize();

		if(!is_numeric($cuantos))
			$cuantos = intval($cuantos,10);
		if(!is_numeric($iniciar))
			$iniciar = intval($iniciar,10);
		if($cuantos < $iniciar OR $cuantos == 0)
			$cuantos = $iniciar+1;
		if($this->filtrocolumnas == NULL)
			$this->get_columnas();

		$sqlejecutar = "SELECT ".$this->filtrocolumnas." FROM tabledata ORDER BY codigo ASC LIMIT ".$cuantos." OFFSET ".$iniciar."";
		$sqlresult = $this->ladb->query($sqlejecutar);
		$arreglo_reporte = $sqlresult->result_array();

		return $arreglo_reporte;
	}

}

?>

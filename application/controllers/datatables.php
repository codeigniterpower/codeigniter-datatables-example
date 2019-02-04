<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package		controlyjson
 * @description	Controller Class de obtension de datos desde el modelo, y que tambien ofrece un metodo con json de la data a demanda
 * @author		PICCORO Lenz McKAY
 */
class datatables extends CI_Controller {

	/** constructor revisa sesion con prvia invocacion de contructor heredado */
	function __construct()
	{
		parent::__construct();
	}

	/** entrada index si no se especifica destino del controlador, redireccionara a primer formulario de presentacion */
	public function index()
	{
		$datavista = array();
		$this->load->view('datatables_view_index',$datavista);
	}

	/**
	 * @name: 		verdata
	 * @description		metodo del controlador invocado donde la vista invocara tambien el metodo que trae la data en json
	 * @return		void renderiza html, ya que es un controler
	 */
	public function verdata()
	{
		$datavista = array();


		$this->load->helper(array('form', 'url','html','inflector'));


		$this->load->model('datatables_model');
		$arrayresultset_datatable_inicia = $this->datatables_model->get_data();
		$arrayresultset_datatable_total = $this->datatables_model->count_data();

		$datavista['arrayresultset_datatable_inicia'] = $arrayresultset_datatable_inicia;
		$datavista['arrayresultset_datatable_total'] = $arrayresultset_datatable_total;
		
		$this->load->view('datatables_view_mdata',$datavista);
	}

	/**
	 * @name		obtenerdata_porjson
	 * @description	accion para salida json consulta la data y la saca en formato json para ser usada en el mismo metodo por datatables
	 * @access		public
	 * @param		$profiling mixed si no es null muestra y habilita el profiler debug de codeigniter para este request o metodo del controler
	 * @return		void
	 */
	public function obtenerdata_porjson($profiling = NULL)
	{
		// datatables/jquery parametros: usados para paginar en table/html con javascrip
		$datatablerender = intval($this->input->get("draw"));
		$desdedonde = intval($this->input->get("start"));
		$comocuanto = intval($this->input->get("length"));

		if($profiling == NULL)	$this->output->enable_profiler(FALSE);

		$this->load->model('datatables_model');
		$arrayresultset_datatable = $this->datatables_model->get_data($desdedonde,$comocuanto);
		$arrayresultset_datatotal = $this->datatables_model->count_data();

		$datadb = array();	// data debe capsulado con "[" y sin "{"
		$indexdata = 0;
		foreach($arrayresultset_datatable as $keyrowlineas=>$valuerowfilas)
		{
			$datarow = array(); // cada row debe ser solo UTF8, ademas no tener "{"
			$indexrow = 0;
			foreach($valuerowfilas as $columnname=>$rowvalue)
			{
				$datarow[$indexrow] = mb_convert_encoding($rowvalue, "UTF-8", "Windows-1252");
				$indexrow += 1;
			}
			$datadb[$indexdata] = $datarow;
			$indexdata += 1;
		}

		// data  solo UTF8 con "[" y sin "{", por eso los foreach
		$output = array();
		$output['draw'] = $datatablerender;
		$output['recordsTotal'] = $arrayresultset_datatotal;
		$output['recordsFiltered'] = $arrayresultset_datatotal;//count($oaexisten_arraydata);
		$output['data'] = $datadb;

		echo json_encode($output);
	}

}

/* End of file oa_existencias.php */
/* Location: ./application/controllers/mproductos/oa_existencias.php */

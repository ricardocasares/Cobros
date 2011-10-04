<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ciudades extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('id')) redirect('auth/login');
	}

	public function index($offset = 0)
	{
		if(!$offset)
			$this->session->unset_userdata('filtros_ciudades');
			
		$datos = $this->session->all_userdata();
		
		$string = isset($datos['filtros_ciudades']['ciudad'])?$datos['filtros_ciudades']['ciudad']:'%%';
		$prov = isset($datos['filtros_ciudades']['prov'])?$datos['filtros_ciudades']['prov']:0;
		$c = isset($datos['filtros_ciudades']['pais'])?$datos['filtros_ciudades']['pais']:0;
		
		$condiciones = '';
		$valores = array();
		
		if($string != '%%'){
			$condiciones .= " nombre LIKE ?";
			$valores[] = $string;
			}
		
		if($prov > 0){
			if($condiciones != ''){
				$condiciones .= " AND ";
				}
			$condiciones .= " state_id = ?";
			$valores[] = $prov;
		}
		
		if($c > 0){
			if($condiciones != ''){
				$condiciones .= " AND ";
				}
			$condiciones .= " country_id = ?";
			$valores[] = $c;
		}
		
		$conditions = array_merge(array($condiciones), $valores);
		
		$config['base_url'] = site_url('ciudades/index');
		$config['total_rows'] = City::count(array('joins'=>array('state'),'conditions' => $conditions));
		$config['per_page'] = '10'; 
		$config['num_links'] = '10'; 
		$config['first_link'] = '&larr; primero';
		$config['last_link'] = 'último &rarr;';
		$this->load->library('pagination', $config);
		
		$ciudades = City::all(array('joins'=>array('state'),'conditions' => $conditions, 'limit' => $config['per_page'], 'offset' => $offset) );
		
		$this->table->set_heading('Orden','Pais', 'Provincia','Ciudad', 'Acciones');
		foreach($ciudades as $ciudad)
		{
			$this->table->add_row(
				$ciudad->id,
				$ciudad->state->country->pais,
				$ciudad->state->provincia,
				$ciudad->nombre,
				anchor('ciudades/editar/'.$ciudad->id,img('static/img/icon/pencil.png'), 'class="tipwe" title="Editar"').' '.
				anchor('ciudades/eliminar/'.$ciudad->id,img('static/img/icon/trash.png'), 'class="tipwe eliminar" title="Eliminar"')
			);
		}
		
		$data['ciudades'] = $this->table->generate();
		$data['pagination'] = $this->pagination->create_links();
		$data['paises']= Country::all();
		$data['provincias']= State::all();
		$data['filtros']= array($string, $prov, $c);
		
		$this->template->write_view('content', 'ciudades/index',$data);
		$this->template->render();
	}
	
	public function filters($offset=0)
	{
		$string = '%'.$this->input->post('ciudad').'%';
		$c = $this->input->post('country_id');
		$prov = $this->input->post('state_id');
		
		$condiciones = '';
		$valores = array();
		
		if($string != '%%'){
			$condiciones .= " nombre LIKE ?";
			$valores['ciudad'] = $string;
			}
		
		if($prov > 0){
			if($condiciones != ''){
				$condiciones .= " AND ";
				}
			$condiciones .= " state_id = ?";
			$valores['prov'] = $prov;
		}
		
		if($c > 0){
			if($condiciones != ''){
				$condiciones .= " AND ";
				}
			$condiciones .= " country_id = ?";
			$valores['pais'] = $c;
		}
		
		$this->session->set_userdata('filtros_ciudades', $valores);
		$conditions = array_merge(array($condiciones), $valores);
		
		$config['base_url'] = site_url('ciudades/index');
		$config['total_rows'] = City::count(array('joins'=>array('state'),'conditions' => $conditions));
		$config['per_page'] = '10'; 
		$config['num_links'] = '10'; 
		$config['first_link'] = '&larr; primero';
		$config['last_link'] = 'último &rarr;';
		$this->load->library('pagination', $config);
		
		$ciudades = City::all(array('joins'=>array('state'),'conditions' => $conditions, 'limit' => $config['per_page'], 'offset' => $offset) );
		
		$this->table->set_heading('Orden','País', 'Provincia','Ciudad', 'Acciones');
		foreach($ciudades as $ciudad)
		{
			$this->table->add_row(
				$ciudad->id,
				$ciudad->state->country->pais,
				$ciudad->state->provincia,
				$ciudad->nombre,
				anchor('ciudades/editar/'.$ciudad->id,img('static/img/icon/pencil.png'), 'class="tipwe" title="Editar"').' '.
				anchor('ciudades/eliminar/'.$ciudad->id,img('static/img/icon/trash.png'), 'class="tipwe eliminar" title="Eliminar"')
			);
		}
		echo $this->table->generate();
		
		echo '<div class="pagination">';
		echo $this->pagination->create_links();
		echo '</div>';
	}
	
	public function agregar()
	{				
		$data = array();
		if ( $_POST )
		{
			$ciudad = new City( 
				elements( array('nombre', 'state_id'), $_POST )
			);
			if( $ciudad->is_valid( ) )
			{
				$ciudad->save();
				$this->session->set_flashdata( 'msg','<div class="success">La ciudad se guardó correctamente.</div>' );
				redirect('ciudades');
			}
			else
			{
				$data['errors'] = $ciudad->errors;
			}
		}
		
		$data['paises']= Country::all();
		$data['provincias']= State::all();
		$data['titulo'] = "Agregar Ciudad";
		$data['action'] = "ciudades/agregar";
		
		$this->template->write_view('content', 'ciudades/agregar',$data);
		$this->template->render();
	}
	
	public function editar( $id )
	{	
		if(!$id)
		{
			$this->session->set_flashdata( 'msg','<div class="error">La ciudad solicitada no existe.</div>' );
			redirect('ciudades');
		}
		elseif ( $_POST )
		{
			$this->load->helper('date');
			$this->load->library('Utils');
					
			$ciudad = City::find($id);
			
			$ciudad->update_attributes(elements( array('nombre', 'state_id' ), $_POST ));
			
			if( $ciudad->is_valid( ) )
			{
				if($ciudad->save())
				{
					$this->session->set_flashdata( 'msg','<div class="success">La ciudad se guardó correctamente.</div>' );
					redirect('ciudades');
				}
				else
				{
					$this->session->set_flashdata( 'msg','<div class="error">Hubo un error al guardar los datos.</div>' );
					redirect('ciudades/editar/'.$id);
				}
			}
			else
			{
				$data['errors'] = $ciudad->errors;
			}
		}
		else $data['a'] = City::find($id);
		
		$data['paises']= Country::all();
		$data['provincias']= State::all();
		$data['titulo'] = "Editar Ciudad";
		$data['action'] = "ciudades/editar/".$id;
		
		$this->template->write_view('content', 'ciudades/agregar',$data);
		$this->template->render();
	}
	
	function eliminar($id)
	{
		$a = City::find($id);
		$a->delete();
		$this->session->set_flashdata('msg','<div class="success">El ciudad fué eliminada correctamente.</div>');
		redirect('ciudades');
	}
}

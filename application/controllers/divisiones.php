<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Divisiones extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('id')) redirect('auth/login');
	}

	public function index($offset = 0)
	{
		$config['base_url'] = site_url('divisiones/index');
		$config['total_rows'] = Division::count();
		$config['per_page'] = '10'; 
		$config['num_links'] = '10'; 
		$config['first_link'] = '&larr; primero';
		$config['last_link'] = 'último &rarr;';
		$this->load->library('pagination', $config);
		
		$divisiones = Division::all(array('limit' => $config['per_page'], 'offset' => $offset) );
		
		$this->table->set_heading('Orden','División', 'Acciones');
		foreach($divisiones as $division)
		{
			$this->table->add_row(
				$division->id,
				$division->division,
				anchor('divisiones/editar/'.$division->id,img('static/img/icon/pencil.png'), 'class="tipwe" title="Editar"').' '.
				anchor('divisiones/eliminar/'.$division->id,img('static/img/icon/trash.png'), 'class="tipwe eliminar" title="Eliminar"')
			);
		}
		
		$data['divisiones'] = $this->table->generate();
		$data['pagination'] = $this->pagination->create_links();
				
		$this->template->write_view('content', 'divisiones/index',$data);
		$this->template->render();
	}
	
	public function filters($offset=0)
	{
		$string = '%'.$this->input->post('division').'%';
				
		$condiciones = '';
		$valores = array();
		
		if($string != '%%'){
			$condiciones .= " division LIKE ?";
			$valores['division'] = $string;
			}
		
		$conditions = array_merge(array($condiciones), $valores);
		
		$config['base_url'] = site_url('divisiones/index');
		$config['total_rows'] = Division::count(array('conditions' => $conditions));
		$config['per_page'] = '10'; 
		$config['num_links'] = '10'; 
		$config['first_link'] = '&larr; primero';
		$config['last_link'] = 'último &rarr;';
		$this->load->library('pagination', $config);
		
		$divisiones = Division::all(array('conditions' => $conditions, 'limit' => $config['per_page'], 'offset' => $offset) );
		
		$this->table->set_heading('Orden','División', 'Acciones');
		foreach($divisiones as $division)
		{
			$this->table->add_row(
				$division->id,
				$division->division,
				anchor('divisiones/editar/'.$division->id,img('static/img/icon/pencil.png'), 'class="tipwe" title="Editar"').' '.
				anchor('divisiones/eliminar/'.$division->id,img('static/img/icon/trash.png'), 'class="tipwe eliminar" title="Eliminar"')
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
			$division = new Division( 
				elements( array('division'), $_POST )
			);
			if( $division->is_valid( ) )
			{
				$division->save();
				$this->session->set_flashdata( 'msg','<div class="success">La División se guardó correctamente.</div>' );
				redirect('divisiones');
			}
			else
			{
				$data['errors'] = $division->errors;
			}
		}
		
		$data['titulo'] = "Agregar División";
		$data['action'] = "divisiones/agregar";
		
		$this->template->write_view('content', 'divisiones/agregar',$data);
		$this->template->render();
	}
	
	public function editar( $id )
	{	
		if(!$id)
		{
			$this->session->set_flashdata( 'msg','<div class="error">La División solicitada no existe.</div>' );
			redirect('divisiones');
		}
		elseif ( $_POST )
		{
			$this->load->helper('date');
			$this->load->library('Utils');
					
			$division = Division::find($id);
			
			$division->update_attributes(elements( array('division' ), $_POST ));
			
			if( $division->is_valid( ) )
			{
				if($division->save())
				{
					$this->session->set_flashdata( 'msg','<div class="success">La División se guardó correctamente.</div>' );
					redirect('divisiones');
				}
				else
				{
					$this->session->set_flashdata( 'msg','<div class="error">Hubo un error al guardar los datos.</div>' );
					redirect('divisiones/editar/'.$id);
				}
			}
			else
			{
				$data['errors'] = $division->errors;
			}
		}
		else $data['a'] = Division::find($id);
		
		$data['titulo'] = "Editar División";
		$data['action'] = "divisiones/editar/".$id;
		
		$this->template->write_view('content', 'divisiones/agregar',$data);
		$this->template->render();
	}
	
	function eliminar($id)
	{
		$a = Division::find($id);
		$a->delete();
		$this->session->set_flashdata('msg','<div class="success">La División se eliminó correctamente.</div>');
		redirect('divisiones');
	}
}

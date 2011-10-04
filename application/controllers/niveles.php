<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Niveles extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('id')) redirect('auth/login');
	}

	public function index($offset = 0)
	{
		$config['base_url'] = site_url('niveles/index');
		$config['total_rows'] = Level::count();
		$config['per_page'] = '10'; 
		$config['num_links'] = '10'; 
		$config['first_link'] = '&larr; primero';
		$config['last_link'] = 'último &rarr;';
		$this->load->library('pagination', $config);
		
		$niveles = Level::all(array('limit' => $config['per_page'], 'offset' => $offset) );
		
		$this->table->set_heading('Orden','Nivel', 'Acciones');
		foreach($niveles as $nivel)
		{
			$this->table->add_row(
				$nivel->id,
				$nivel->nivel,
				anchor('niveles/editar/'.$nivel->id,img('static/img/icon/pencil.png'), 'class="tipwe" title="Editar"').' '.
				anchor('niveles/eliminar/'.$nivel->id,img('static/img/icon/trash.png'), 'class="tipwe eliminar" title="Eliminar"')
			);
		}
		
		$data['niveles'] = $this->table->generate();
		$data['pagination'] = $this->pagination->create_links();
				
		$this->template->write_view('content', 'niveles/index',$data);
		$this->template->render();
	}
	
	public function filters($offset=0)
	{
		$string = '%'.$this->input->post('nivel').'%';
				
		$condiciones = '';
		$valores = array();
		
		if($string != '%%'){
			$condiciones .= " nivel LIKE ?";
			$valores['nivel'] = $string;
			}
		
		$conditions = array_merge(array($condiciones), $valores);
		
		$config['base_url'] = site_url('niveles/index');
		$config['total_rows'] = Level::count(array('conditions' => $conditions));
		$config['per_page'] = '10'; 
		$config['num_links'] = '10'; 
		$config['first_link'] = '&larr; primero';
		$config['last_link'] = 'último &rarr;';
		$this->load->library('pagination', $config);
		
		$niveles = Level::all(array('conditions' => $conditions, 'limit' => $config['per_page'], 'offset' => $offset) );
		
		$this->table->set_heading('Orden','Nivel', 'Acciones');
		foreach($niveles as $nivel)
		{
			$this->table->add_row(
				$nivel->id,
				$nivel->nivel,
				anchor('niveles/editar/'.$nivel->id,img('static/img/icon/pencil.png'), 'class="tipwe" title="Editar"').' '.
				anchor('niveles/eliminar/'.$nivel->id,img('static/img/icon/trash.png'), 'class="tipwe eliminar" title="Eliminar"')
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
			$nivel = new Level( 
				elements( array('nivel'), $_POST )
			);
			if( $nivel->is_valid( ) )
			{
				$nivel->save();
				$this->session->set_flashdata( 'msg','<div class="success">El Nivel se guardó correctamente.</div>' );
				redirect('niveles');
			}
			else
			{
				$data['errors'] = $nivel->errors;
			}
		}
		
		$data['titulo'] = "Agregar Nivel";
		$data['action'] = "niveles/agregar";
		
		$this->template->write_view('content', 'niveles/agregar',$data);
		$this->template->render();
	}
	
	public function editar( $id )
	{	
		if(!$id)
		{
			$this->session->set_flashdata( 'msg','<div class="error">El Nivel solicitada no existe.</div>' );
			redirect('niveles');
		}
		elseif ( $_POST )
		{
			$this->load->helper('date');
			$this->load->library('Utils');
					
			$nivel = Level::find($id);
			
			$nivel->update_attributes(elements( array('nivel' ), $_POST ));
			
			if( $nivel->is_valid( ) )
			{
				if($nivel->save())
				{
					$this->session->set_flashdata( 'msg','<div class="success">El Nivel se guardó correctamente.</div>' );
					redirect('niveles');
				}
				else
				{
					$this->session->set_flashdata( 'msg','<div class="error">Hubo un error al guardar los datos.</div>' );
					redirect('niveles/editar/'.$id);
				}
			}
			else
			{
				$data['errors'] = $nivel->errors;
			}
		}
		else $data['a'] = Level::find($id);
		
		$data['titulo'] = "Editar Nivel";
		$data['action'] = "niveles/editar/".$id;
		
		$this->template->write_view('content', 'niveles/agregar',$data);
		$this->template->render();
	}
	
	function eliminar($id)
	{
		$a = Level::find($id);
		$a->delete();
		$this->session->set_flashdata('msg','<div class="success">El Nivel fué eliminado correctamente.</div>');
		redirect('niveles');
	}
}

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Provincias extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('id')) redirect('auth/login');
	}

	public function index($offset = 0)
	{
		$this->load->library('pagination');
		$config['base_url'] = site_url('provincias/index');
		$config['total_rows'] = State::count();
		$config['per_page'] = '10'; 
		$config['num_links'] = '1'; 
		$config['first_link'] = '&larr; primero';
		$config['last_link'] = 'último &rarr;';
		$this->pagination->initialize($config);
		
		$provincias = State::find('all', array('limit' => $config['per_page'], 'offset' => $offset));
		
		$this->table->set_heading('Orden','Pais', 'Provincia', 'Acciones');
		foreach($provincias as $pro)
		{
			$this->table->add_row(
				$pro->id,
				$pro->country->pais,
				$pro->provincia,
				anchor('provincias/editar/'.$pro->id,img('static/img/icon/pencil.png'), 'class="tipwe" title="Editar"').' '.
				anchor('provincias/eliminar/'.$pro->id,img('static/img/icon/trash.png'), 'class="tipwe eliminar" title="Eliminar"')
			);
		}
		
		$data['provincias'] = $this->table->generate();
		$data['pagination'] = $this->pagination->create_links();
		$data['paises']= Country::all();
		
		$this->template->write_view('content', 'provincias/index',$data);
		$this->template->render();
	}
	
	public function filters()
	{
		$string = '%'.$this->input->post('provincia').'%';
		$c = $this->input->post('country_id');
		if($string != '%%' && $c > 0 )
		{
			$provincias = State::find('all', array('conditions' => array('country_id = ? AND provincia LIKE ?', $c, $string)));
		}
		elseif($string != '%%') $provincias = State::find('all', array('conditions' => array('provincia LIKE ?', $string)));
		elseif($c != '0') $provincias = State::find('all', array('conditions' => array('country_id = ?', $c)));
		else $provincias = State::find('all');
		
		$this->table->set_heading('Orden','País', 'Provincia', 'Acciones');
		foreach($provincias as $pro)
		{
			$this->table->add_row(
				$pro->id,
				$pro->country->pais,
				$pro->provincia,
				anchor('provincias/editar/'.$pro->id,img('static/img/icon/pencil.png'), 'class="tipwe" title="Editar"').' '.
				anchor('provincias/eliminar/'.$pro->id,img('static/img/icon/trash.png'), 'class="tipwe eliminar" title="Eliminar"')
			);
		}
		echo $this->table->generate();
		
		$config['base_url'] = site_url('provincias/index');
		$config['total_rows'] = State::count();
		$config['per_page'] = '10'; 
		$config['num_links'] = '10'; 
		$config['first_link'] = '&larr; primero';
		$config['last_link'] = 'último &rarr;';
		$this->load->library('pagination', $config);
		echo '<div class="pagination">';
		echo $this->pagination->create_links();
		echo '</div>';
	}
	
	public function agregar()
	{				
		$data = array();
		if ( $_POST )
		{
			$provincia = new State( 
				elements( array('provincia', 'country_id'), $_POST )
			);
			if( $provincia->is_valid( ) )
			{
				$provincia->save();
				$this->session->set_flashdata( 'msg','<div class="success">El provincia se guardó correctamente.</div>' );
				redirect('provincias');
			}
			else
			{
				$data['errors'] = $provincia->errors;
			}
		}
		
		$data['paises']= Country::all();
		$data['titulo'] = "Agregar Provincia";
		$data['action'] = "provincias/agregar";
		
		$this->template->write_view('content', 'provincias/agregar',$data);
		$this->template->render();
	}
	
	public function editar( $id )
	{	
		if(!$id)
		{
			$this->session->set_flashdata( 'msg','<div class="error">El provincia solicitada no existe.</div>' );
			redirect('provincias');
		}
		elseif ( $_POST )
		{
			$this->load->helper('date');
			$this->load->library('Utils');
					
			$provincia = State::find($id);
			
			$provincia->update_attributes(elements( array('provincia', 'country_id' ), $_POST ));
			
			if( $provincia->is_valid( ) )
			{
				if($provincia->save())
				{
					$this->session->set_flashdata( 'msg','<div class="success">La provincia se guardó correctamente.</div>' );
					redirect('provincias');
				}
				else
				{
					$this->session->set_flashdata( 'msg','<div class="error">Hubo un error al guardar los datos.</div>' );
					redirect('provincias/editar/'.$id);
				}
			}
			else
			{
				$data['errors'] = $provincia->errors;
			}
		}
		else $data['a'] = State::find($id);
		
		$data['paises']= Country::all();
		$data['titulo'] = "Editar provincia";
		$data['action'] = "provincias/editar/".$id;
		
		$this->template->write_view('content', 'provincias/agregar',$data);
		$this->template->render();
	}
	
	function eliminar($id)
	{
		$a = State::find($id);
		$a->delete();
		$this->session->set_flashdata('msg','<div class="success">El provincia fué eliminada correctamente.</div>');
		redirect('provincias');
	}
}

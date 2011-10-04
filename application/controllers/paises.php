<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paises extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('id')) redirect('auth/login');
	}

	public function index($offset = 0)
	{
		$this->load->library('pagination');
		$config['base_url'] = site_url('paises/index');
		$config['total_rows'] = Country::count();
		$config['per_page'] = '10'; 
		$config['num_links'] = '1'; 
		$config['first_link'] = '&larr; primero';
		$config['last_link'] = 'último &rarr;';
		$this->pagination->initialize($config);
		
		$paises = Country::find('all', array('limit' => $config['per_page'], 'offset' => $offset));
		
		$this->table->set_heading('Orden','Pais','Acciones');
		foreach($paises as $pa)
		{
			$this->table->add_row(
				$pa->id,
				$pa->pais,
				anchor('paises/editar/'.$pa->id,img('static/img/icon/pencil.png'), 'class="tipwe" title="Editar"').' '.
				anchor('paises/eliminar/'.$pa->id,img('static/img/icon/trash.png'), 'class="tipwe eliminar" title="Eliminar"')
			);
		}
		
		$data['paises'] = $this->table->generate();
		$data['pagination'] = $this->pagination->create_links();
		
		$this->template->write_view('content', 'paises/index',$data);
		$this->template->render();
	}
	
	public function filters()
	{
		$string = '%'.$this->input->post('pais').'%';
		$paises = array();
		
		$paises = Country::find('all', array('conditions' => array('pais LIKE ?', $string)));
		
		$this->table->set_heading('Orden','País','Acciones');
		foreach($paises as $pa)
		{
			$this->table->add_row(
				$pa->id,
				$pa->pais,
				anchor('paises/editar/'.$pa->id,img('static/img/icon/pencil.png'), 'class="tipwe" title="Editar"').' '.
				anchor('paises/eliminar/'.$pa->id,img('static/img/icon/trash.png'), 'class="tipwe eliminar" title="Eliminar"')
			);
		}
		echo $this->table->generate();
		
		$config['base_url'] = site_url('paises/index');
		$config['total_rows'] = Country::count();
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
			$pais = new Country( 
				elements( array('pais'	), $_POST )
			);
			if( $pais->is_valid( ) )
			{
				$pais->save();
				$this->session->set_flashdata( 'msg','<div class="success">El pais se guardó correctamente.</div>' );
				redirect('paises');
			}
			else
			{
				$data['errors'] = $pais->errors;
			}
		}
		
		$data['titulo'] = "Agregar pais";
		$data['action'] = "paises/agregar";
		
		$this->template->write_view('content', 'paises/agregar',$data);
		$this->template->render();
	}
	
	public function editar( $id )
	{	
		if(!$id)
		{
			$this->session->set_flashdata( 'msg','<div class="error">El pais solicitado no existe.</div>' );
			redirect('paises');
		}
		elseif ( $_POST )
		{
			$this->load->helper('date');
			$this->load->library('Utils');
					
			$pais = Country::find($id);
			
			$pais->update_attributes(elements( array('pais' ), $_POST ));
			
			if( $pais->is_valid( ) )
			{
				if($pais->save())
				{
					$this->session->set_flashdata( 'msg','<div class="success">El pais se guardó correctamente.</div>' );
					redirect('paises');
				}
				else
				{
					$this->session->set_flashdata( 'msg','<div class="error">Hubo un error al guardar los datos.</div>' );
					redirect('paises/editar/'.$id);
				}
			}
			else
			{
				$data['errors'] = $pais->errors;
			}
		}
		else $data['a'] = Country::find($id);
		
		$data['titulo'] = "Editar pais";
		$data['action'] = "paises/editar/".$id;
		
		$this->template->write_view('content', 'paises/agregar',$data);
		$this->template->render();
	}
	
	function eliminar($id)
	{
		$a = Country::find($id);
		$a->delete();
		$this->session->set_flashdata('msg','<div class="success">El pais fué eliminado correctamente.</div>');
		redirect('paises');
	}
}

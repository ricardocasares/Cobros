<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tutores extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('id')) redirect('auth/login');
	}

	public function index($offset = 0)
	{
		$this->load->library('pagination');
		$config['base_url'] = site_url('tutores/index');
		$config['total_rows'] = Tutor::count();
		$config['per_page'] = '10'; 
		$config['num_links'] = '1'; 
		$config['first_link'] = '&larr; primero';
		$config['last_link'] = 'último &rarr;';
		$this->pagination->initialize($config);
		
		$a = Tutor::find('all', array('limit' => $config['per_page'], 'offset' => $offset));
		
		$this->table->set_heading('Nombre','Apellido', 'Telefono','Celular','Acciones');
		foreach($a as $al)
		{
			$this->table->add_row(
				$al->nombre,
				$al->apellido,
				$al->telefono,
				$al->celular,
				anchor('tutores/editar/'.$al->id,img('static/img/icon/notepad_2.png'), 'class="tipwe" title="Editar tutor"').' '.
				anchor('tutores/eliminar/'.$al->id,img('static/img/icon/trash.png'), 'class="tipwe eliminar" title="Eliminar tutor"')
			);
		}
		
		$data['tutores'] = $this->table->generate();
		$data['pagination'] = $this->pagination->create_links();
		
		$this->template->write_view('content', 'tutores/index',$data);
		$this->template->render();
	}

	public function agregar()
	{				
		$data = array();
		if ( $_POST )
		{
			$this->load->helper('date');
			$this->load->library('Utils');
			$insert = $_POST;
			$insert['fecha_nacimiento'] = $this->utils->fecha_formato('%Y-%m-%d', $insert['fecha_nacimiento']);
			$insert['fecha_inscripcion'] = $this->utils->fecha_formato('%Y-%m-%d', $insert['fecha_inscripcion']);
			$tutor = new Student( 
				elements( array(
					'city_id',
					'nombre',
					'apellido',
					'fecha_nacimiento',
					'sexo',
					'tipo_documento',
					'nro_documento',
					'domicilio',
					'tenencia',
					'nacionalidad',
					'grupo_sanguineo',
					'telefono',
					'celular',
					'obs_medicas',
					'observaciones',
					'colegio_procedencia',
					'fecha_inscripcion',
				), $insert )
			);
			if( $tutor->is_valid( ) )
			{
				$tutor->save();
				$this->session->set_flashdata( 'msg','<div class="success">El tutor se guardó correctamente.</div>' );
				redirect('tutores/agregar');
			}
			else
			{
				$data['errors'] = $tutor->errors;
			}
		}
		
		$data['paises'] = Country::all();
		$data['provincias'] = State::all();
		$data['ciudades'] = City::all();
		$data['titulo'] = "Agregar tutor";
		$data['action'] = "tutores/agregar";
		
		$this->template->write_view('content', 'tutores/agregar',$data);
		$this->template->render();
	}
	
	public function editar( $id )
	{	
		if(!$id)
		{
			$this->session->set_flashdata( 'msg','<div class="error">El tutor solicitado no existe.</div>' );
			redirect('tutores');
		}
		elseif ( $_POST )
		{
			$this->load->helper('date');
			$this->load->library('Utils');
			$insert = $_POST;
			$insert['fecha_nacimiento'] = $this->utils->fecha_formato('%Y-%m-%d', $insert['fecha_nacimiento']);
			$insert['fecha_inscripcion'] = $this->utils->fecha_formato('%Y-%m-%d', $insert['fecha_inscripcion']);
			
			$tutor = Student::find($id);
			
			$tutor->update_attributes(elements( array(
					'city_id',
					'nombre',
					'apellido',
					'fecha_nacimiento',
					'sexo',
					'tipo_documento',
					'nro_documento',
					'domicilio',
					'tenencia',
					'nacionalidad',
					'grupo_sanguineo',
					'telefono',
					'celular',
					'obs_medicas',
					'observaciones',
					'colegio_procedencia',
					'fecha_inscripcion',
				), $insert )
			);
			
			if( $tutor->is_valid( ) )
			{
				if($tutor->save())
				{
					$this->session->set_flashdata( 'msg','<div class="success">El tutor se guardó correctamente.</div>' );
					redirect('tutores/editar/'.$id);
				}
				else
				{
					$this->session->set_flashdata( 'msg','<div class="error">Hubo un error al guardar los datos.</div>' );
					redirect('tutores/editar/'.$id);
				}
			}
			else
			{
				$data['errors'] = $tutor->errors;
			}
		}
		else $data['a'] = Student::find($id);
		
		$data['paises'] = Country::all();
		$data['provincias'] = State::all();
		$data['ciudades'] = City::all();
		$data['titulo'] = "Editar tutor";
		$data['action'] = "tutores/editar/".$id;
		
		$this->template->write_view('content', 'tutores/agregar',$data);
		$this->template->render();
	}
	
	function eliminar($id)
	{
		$a = Student::find($id);
		$a->delete();
		$this->session->set_flashdata('msg','<div class="success">El tutor fué eliminado correctamente.</div>');
		redirect('tutores');
	}
}

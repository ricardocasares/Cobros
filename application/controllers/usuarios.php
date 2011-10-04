<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('id')) redirect('auth/login');
	}

	public function index($offset = 0)
	{
		$this->load->library('pagination');
		$config['base_url'] = site_url('usuarios/index');
		$config['total_rows'] = User::count();
		$config['per_page'] = '10'; 
		$config['num_links'] = '1'; 
		$config['first_link'] = '&larr; primero';
		$config['last_link'] = 'último &rarr;';
		$this->pagination->initialize($config);
		
		$a = User::find('all', array('limit' => $config['per_page'], 'offset' => $offset));
		
		$this->table->set_heading('Usuario','Nombre','Apellido', 'Teléfono', 'Celular', 'Email','Dirección','Acciones');
		foreach($a as $al)
		{
			$this->table->add_row(
				$al->usuario,
				$al->nombre,
				$al->apellido,
				$al->telefono,
				$al->celular,
				$al->email,
				$al->direccion,
				anchor('usuarios/ver/'.$al->id,img('static/img/icon/doc_lines.png'), 'class="tipwe" title="Ver detalles de usuario"').' '.
				anchor('usuarios/editar/'.$al->id,img('static/img/icon/pencil.png'), 'class="tipwe" title="Editar usuario"').' '.
				anchor('usuarios/eliminar/'.$al->id,img('static/img/icon/trash.png'), 'class="tipwe eliminar" title="Eliminar usuario"')
			);
		}
		
		$data['alumnos'] = $this->table->generate();
		$data['pagination'] = $this->pagination->create_links();
		
		$this->template->write_view('content', 'usuarios/index',$data);
		$this->template->render();
	}
	
	public function filter()
	{
		$string = '%'.$this->input->post('string').'%';
		$a = array();
		if($string)
		{
			$a = User::find('all', array('conditions' => array('nombre LIKE ? OR apellido LIKE ? OR usuario LIKE ?', $string, $string, $string)));
		} else $a = User::find('all');
		$this->table->set_heading('Usuario','Nombre','Apellido', 'Teléfono', 'Celular', 'Email','Dirección','Acciones');
		foreach($a as $al)
		{
			$this->table->add_row(
				$al->usuario,
				$al->nombre,
				$al->apellido,
				$al->telefono,
				$al->celular,
				$al->email,
				$al->direccion,
				anchor('usuarios/ver/'.$al->id,img('static/img/icon/doc_lines.png'), 'class="tipwe" title="Ver detalles de usuario"').' '.
				anchor('usuarios/editar/'.$al->id,img('static/img/icon/pencil.png'), 'class="tipwe" title="Editar usuario"').' '.
				anchor('usuarios/eliminar/'.$al->id,img('static/img/icon/trash.png'), 'class="tipwe eliminar" title="Eliminar usuario"')
			);
		}
		echo $this->table->generate();
		
		$config['base_url'] = site_url('usuarios/index');
		$config['total_rows'] = User::count();
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
		if($this->session->userdata('grupo') == 'admin')
		{
			$data = array();
			if ( $_POST )
			{
				$this->load->helper('date');
				$this->load->library('Utils');
				$insert = $_POST;
				$usuario = new User( 
					elements( array(
						'nombre',
						'apellido',
						'direccion',
						'telefono',
						'email',
						'celular',
						'usuario',
						'grupo',
						'password'
					), $insert )
				);
				if( $usuario->is_valid() )
				{
					$usuario->save();
					$this->session->set_flashdata( 'msg','<div class="success">El usuario se guardó correctamente.</div>' );
					redirect('usuarios/index/');
				}
				else
				{
					$data['errors'] = $usuario->errors;
				}
			}
		
			$data['titulo'] = "Agregar usuario";
			$data['action'] = "usuarios/agregar";
		
			$this->template->write_view('content', 'usuarios/agregar',$data);
			$this->template->render();
		}
		else
		{
			$this->session->set_flashdata( 'msg','<div class="error">No tiene privilegios para realizar esta acción.</div>' );
			redirect('usuarios/index/');
		}
	}
	
	public function editar( $id )
	{	
		if($this->session->userdata('grupo') == 'admin' OR $this->session->userdata('id') == $id)
		{
			if(!$id)
			{
				$this->session->set_flashdata( 'msg','<div class="notice">El usuario solicitado no existe.</div>' );
				redirect('usuarios');
			}
			elseif ( $_POST )
			{
				$this->load->helper('date');
				$this->load->library('Utils');
				$insert = $_POST;
			
				$usuario = User::find($id);
			
				$usuario->update_attributes(elements( array(
						'nombre',
						'apellido',
						'direccion',
						'telefono',
						'email',
						'celular',
						'usuario',
						'grupo',
						'password'
					), $insert )
				);
			
				if( $usuario->is_valid( ) )
				{
					if($usuario->save())
					{
						$this->session->set_flashdata( 'msg','<div class="success">El usuario se guardó correctamente.</div>' );
						redirect($this->agent->referrer());
					}
					else
					{
						$this->session->set_flashdata( 'msg','<div class="error">Hubo un error al guardar los datos.</div>' );
						redirect($this->agent->referrer());
					}
				}
				else
				{
					$data['errors'] = $usuario->errors;
				}
			}
			else $data['a'] = User::find($id);
		
			$data['paises'] = Country::all();
			$data['provincias'] = State::all();
			$data['ciudades'] = City::all();
			$data['titulo'] = "Editar usuario";
			$data['action'] = "usuarios/editar/".$id;
		
			$this->template->write_view('content', 'usuarios/agregar',$data);
			$this->template->render();
		}
		else
		{
			$this->session->set_flashdata( 'msg','<div class="error">No tiene privilegios para realizar esta acción.</div>' );
			redirect('usuarios/index/');
		}
	}
	
	function eliminar($id)
	{
		if($this->session->userdata('grupo') == 'admin')
		{
			$a = User::find($id);
			$a->delete();
			$this->session->set_flashdata('msg','<div class="success">El usuario fué eliminado correctamente.</div>');
			redirect('usuarios');
		}
		else
		{
			$this->session->set_flashdata( 'msg','<div class="error">No tiene privilegios para realizar esta acción.</div>' );
			redirect('usuarios/index/');
		}
	}
}

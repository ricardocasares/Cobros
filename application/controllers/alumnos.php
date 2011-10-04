<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Alumnos extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('id')) redirect('auth/login');
	}

	public function index($offset = 0)
	{
		$this->load->library('pagination');
		$config['base_url'] = site_url('alumnos/index');
		$config['total_rows'] = Student::count();
		$config['per_page'] = '10'; 
		$config['num_links'] = '1'; 
		$config['first_link'] = '&larr; primero';
		$config['last_link'] = 'último &rarr;';
		$this->pagination->initialize($config);
		
		$a = Student::find('all', array('limit' => $config['per_page'], 'offset' => $offset));
		
		$this->table->set_heading('Nombre','Apellido', 'Fecha de nacimiento', 'Documento','Telefono','Celular','Acciones');
		foreach($a as $al)
		{
			$this->table->add_row(
				$al->nombre,
				$al->apellido,
				$al->fecha_nacimiento->format('d/m/Y'),
				$al->tipo_documento.' '.$al->nro_documento,
				$al->telefono,
				$al->celular,
				anchor('alumnos/ver/'.$al->id,img('static/img/icon/doc_lines.png'), 'class="tipwe" title="Ver detalles de alumno"').' '.
				anchor('alumnos/editar/'.$al->id,img('static/img/icon/pencil.png'), 'class="tipwe" title="Editar alumno"').' '.
				anchor('alumnos/eliminar/'.$al->id,img('static/img/icon/trash.png'), 'class="tipwe eliminar" title="Eliminar alumno"')
			);
		}
		
		$data['alumnos'] = $this->table->generate();
		$data['pagination'] = $this->pagination->create_links();
		
		$this->template->write_view('content', 'alumnos/index',$data);
		$this->template->render();
	}
	
	public function filter()
	{
		$string = '%'.$this->input->post('string').'%';
		$a = array();
		if($string)
		{
			$a = Student::find('all', array('conditions' => array('nombre LIKE ? OR apellido LIKE ?', $string, $string)));
		} else $a = Student::find('all');
		$this->table->set_heading('Nombre','Apellido', 'Fecha de nacimiento', 'Documento','Telefono','Celular','Acciones');
		foreach($a as $al)
		{
			$this->table->add_row(
				$al->nombre,
				$al->apellido,
				$al->fecha_nacimiento->format('d/m/Y'),
				$al->tipo_documento.' '.$al->nro_documento,
				$al->telefono,
				$al->celular,
				anchor('alumnos/ver/'.$al->id,img('static/img/icon/doc_lines.png'), 'class="tipwe" title="Ver detalles de alumno"').' '.
				anchor('alumnos/editar/'.$al->id,img('static/img/icon/pencil.png'), 'class="tipwe" title="Editar alumno"').' '.
				anchor('alumnos/eliminar/'.$al->id,img('static/img/icon/trash.png'), 'class="tipwe eliminar" title="Eliminar alumno"')
			);
		}
		echo $this->table->generate();
		
		$config['base_url'] = site_url('alumnos/index');
		$config['total_rows'] = Student::count();
		$config['per_page'] = '10'; 
		$config['num_links'] = '10'; 
		$config['first_link'] = '&larr; primero';
		$config['last_link'] = 'último &rarr;';
		$this->load->library('pagination', $config);
		echo '<div class="pagination">';
		echo $this->pagination->create_links();
		echo '</div>';
	}
	
	function test()
	{
		print_r($_POST);
	}
	
	public function ver($id = FALSE)
	{
		if($id)
		{
			$data['a'] = Student::find($id);
			
			$this->table->set_heading('# Deuda','Concepto', 'Vencimiento', 'Importe', 'Descuento','A pagar','Saldo','Pagado');
			foreach($data['a']->debt as $d)
			{
				$pagado = 0;
				$descuento = 0;
				foreach($d->detail as $p) { 
					if(!$p->payment->anulado)
						$pagado += $p->importe; 
						}
				foreach($d->student->scolarship as $des) (($des->student_id == $d->student_id) AND ($des->amount_id == $d->amount_id)) ? $descuento = $des->porcien_descuento : '';

				$pagar = ($d->amount->importe-($d->amount->importe*($descuento/100)));
				$saldo = $pagar - $pagado;
				if($saldo > 0) {
					$this->table->add_row(
						$d->id,
						$d->amount->concept->concepto.' '.$d->amount->fecha->format('L/Y'),
						$d->amount->fecha->format('d/m/Y'),
						'$'.$d->amount->importe,
						($descuento) ? $descuento.'%' : 'No',
						'$'.$pagar,
						'$'.$saldo,
						form_input(array('name' => 'parcial['.$d->id.']', 'class' => 'small', 'max' => $saldo, 'min' => 1)).' '.form_checkbox(array('name' => 'suma', 'class' => 'check', 'value' => $saldo))
					);
				}
			}
			$data['deudas'] = $this->table->generate(); // TABLA DEUDAS
			
			$this->table->set_heading('# Pago','Concepto','Fecha de pago','Importe', 'Cobrador', 'Acciones');
			foreach($data['a']->payment as $p)
			{	
				if(!$p->anulado){
					foreach($p->detail as $d) {
						$this->table->add_row(
							$p->id,
							$d->debt->amount->concept->concepto.' '.$d->debt->amount->concept->ciclo_lectivo,
							$p->fecha->format('d/m/Y'),
							'$'.$d->importe,
							$p->user->apellido.', '.$p->user->nombre,
							anchor('alumnos/recibos/',img('static/img/icon/print.png'), 'class="tipwe" title="Imprimir recibo"').' '.anchor('pagos/eliminar/'.$p->id,img('static/img/icon/trash.png'), 'class="tipwe eliminar" title="Anular pago"')
						);
					}
				}
			}
			$data['pagos'] = $this->table->generate(); // TABLA PAGOS
			
			$this->table->set_heading('Curso','División', 'Nivel', 'Acciones');
			foreach($data['a']->inscription as $i)
			{
				$this->table->add_row(
					$i->course->course,
					$i->course->division->division,
					$i->course->level->nivel,
					anchor('alumnos/recibos/',img('static/img/icon/trash.png'), 'class="tipwe eliminar" title="Anular inscripción"')
				);
			}
			$data['inscripciones'] = $this->table->generate(); // TABLA INSCRIPCIONES
			
			$this->template->write_view('content', 'alumnos/ver',$data);
			$this->template->render();
		}
		else
		{
			$this->session->set_flashdata('msg','<div class="notice">El alumno no existe.</div>');
			redirect('alumnos');
		}
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
			$alumno = new Student( 
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
			if( $alumno->is_valid( ) )
			{
				$alumno->save();
				$this->session->set_flashdata( 'msg','<div class="success">El alumno se guardó correctamente.</div>' );
				redirect('alumnos/index/');
			}
			else
			{
				$data['errors'] = $alumno->errors;
			}
		}
		
		$data['paises'] = Country::all();
		$data['provincias'] = State::all();
		$data['ciudades'] = City::all();
		$data['titulo'] = "Agregar alumno";
		$data['action'] = "alumnos/agregar";
		
		$this->template->write_view('content', 'alumnos/agregar',$data);
		$this->template->render();
	}
	
	public function editar( $id )
	{	
		if(!$id)
		{
			$this->session->set_flashdata( 'msg','<div class="notice">El alumno solicitado no existe.</div>' );
			redirect('alumnos');
		}
		elseif ( $_POST )
		{
			$this->load->helper('date');
			$this->load->library('Utils');
			$insert = $_POST;
			$insert['fecha_nacimiento'] = $this->utils->fecha_formato('%Y-%m-%d', $insert['fecha_nacimiento']);
			$insert['fecha_inscripcion'] = $this->utils->fecha_formato('%Y-%m-%d', $insert['fecha_inscripcion']);
			
			$alumno = Student::find($id);
			
			$alumno->update_attributes(elements( array(
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
			
			if( $alumno->is_valid( ) )
			{
				if($alumno->save())
				{
					$this->session->set_flashdata( 'msg','<div class="success">El alumno se guardó correctamente.</div>' );
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
				$data['errors'] = $alumno->errors;
			}
		}
		else $data['a'] = Student::find($id);
		
		$data['paises'] = Country::all();
		$data['provincias'] = State::all();
		$data['ciudades'] = City::all();
		$data['titulo'] = "Editar alumno";
		$data['action'] = "alumnos/editar/".$id;
		
		$this->template->write_view('content', 'alumnos/agregar',$data);
		$this->template->render();
	}
	
	function eliminar($id)
	{
		if ($this->session->userdata('grupo') == 'admin')
		{
			$a = Student::find($id);
			$a->delete();
			$this->session->set_flashdata('msg','<div class="success">El alumno fué eliminado correctamente.</div>');
			redirect('alumnos');			
		}
		else
		{		
			$this->session->set_flashdata('msg','<div class="error">No tiene permisos para realizar esta acción.</div>');
			redirect('alumnos');
		}
		
	}
}

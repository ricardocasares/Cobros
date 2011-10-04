<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pagos extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('id')) redirect('auth/login');
	}

	public function index($offset = 0)
	{
		$condiciones = 'anulado = ?';
		$valores[] = 0;
		
		$conditions = array_merge(array($condiciones), $valores);
		
		$this->load->library('pagination');
		$config['base_url'] = site_url('pagos/index');
		$config['total_rows'] = Payment::count(array('conditions' => $conditions));
		$config['per_page'] = '10'; 
		$config['num_links'] = '1'; 
		$config['first_link'] = '&larr; primero';
		$config['last_link'] = 'último &rarr;';
		$this->pagination->initialize($config);
		
		$pagos = Payment::find('all', array('conditions' => $conditions,'limit' => $config['per_page'], 'offset' => $offset));
		
		$this->table->set_heading('Fecha','Nro Comprobante', 'Estudiante', 'Importe','Usuario','Acciones');
		foreach($pagos as $pago)
		{
			$this->table->add_row(
				$pago->fecha->format('d/m/Y'),
				$pago->nro_comprobante,
				$pago->student->apellido.' '.$pago->student->nombre,
				$pago->importe,
				$pago->user->apellido.' '.$pago->user->nombre,
				anchor('pagos/ver/'.$pago->id,img('static/img/icon/doc_lines.png'), 'class="tipwe" title="Ver detalles pago"').' '.
				anchor('pagos/editar/'.$pago->id,img('static/img/icon/pencil.png'), 'class="tipwe" title="Editar pago"').' '.
				anchor('pagos/eliminar/'.$pago->id,img('static/img/icon/trash.png'), 'class="tipwe eliminar" title="Eliminar pago"')
			);
		}
		
		$data['pagos'] = $this->table->generate();
		$data['usuarios'] = User::all();
		$data['pagination'] = $this->pagination->create_links();
		
		$this->template->write_view('content', 'pagos/index',$data);
		$this->template->render();
	}
	
	public function filters($offset = 0)
	{
		$this->load->helpers('date');
		$string = '%'.$this->input->post('estudiante').'%';
		$usuario = $this->input->post('user_id');
		$fecha_desde = $this->input->post('fecha_desde');
		$fecha_hasta = $this->input->post('fecha_hasta');
		
		$condiciones = 'anulado = ?';
		$valores[] = 0;
		
		if($string != '%%'){
			$condiciones .= " AND CONCAT(students.apellido,' ', students.nombre) LIKE ?";
			$valores[] = $string;
			}
		
		if($usuario > 0){
			/*if($condiciones != ''){
				$condiciones .= " AND ";
				}*/
			$condiciones .= " AND user_id = ?";
			$valores[] = $usuario;
		}
		
		if($fecha_desde != ''){
			$fecha_desde = mdate('%Y-%m-%d' ,normal_to_unix($fecha_desde));
					
			if($fecha_hasta != ''){
				$fecha_hasta = mdate('%Y-%m-%d' ,normal_to_unix($fecha_hasta));
			}
			else
				$fecha_hasta = date('Y-m-d');
			
			/*if($condiciones != ''){
				$condiciones .= " AND ";
				}*/
			$condiciones .= " AND fecha BETWEEN ? AND ?";
			$valores[] = $fecha_desde;
			$valores[] = $fecha_hasta;			
		
		}
		
		$conditions = array_merge(array($condiciones), $valores);
		
		$config['base_url'] = site_url('pagos/index');
		$config['total_rows'] = Payment::count(array('joins'=>array('student'),'conditions' => $conditions));
		$config['per_page'] = '10'; 
		$config['num_links'] = '10'; 
		$config['first_link'] = '&larr; primero';
		$config['last_link'] = 'último &rarr;';
		$this->load->library('pagination', $config);
		
		$pagos = array();
		$pagos = Payment::all(array('joins'=>array('student'),'conditions' => $conditions, 'limit' => $config['per_page'], 'offset' => $offset) );
		
		$this->table->set_heading('Fecha','Nro Comprobante', 'Estudiante', 'Importe','Usuario','Acciones');
		foreach($pagos as $pago)
		{
			$this->table->add_row(
				$pago->fecha->format('d/m/Y'),
				$pago->nro_comprobante,
				$pago->student->apellido.' '.$pago->student->nombre,
				$pago->importe,
				$pago->user->apellido.' '.$pago->user->nombre,
				anchor('pagos/ver/'.$pago->id,img('static/img/icon/doc_lines.png'), 'class="tipwe" title="Ver detalles pago"').' '.
				anchor('pagos/editar/'.$pago->id,img('static/img/icon/pencil.png'), 'class="tipwe" title="Editar pago"').' '.
				anchor('pagos/eliminar/'.$pago->id,img('static/img/icon/trash.png'), 'class="tipwe eliminar" title="Eliminar pago"')
			);
		}
		
		echo $this->table->generate();
		echo '<div class="pagination">';
		echo $this->pagination->create_links();
		echo '</div>';
	}
	
	function historial($student_id, $offset = 0)
	{
		$this->load->library('pagination');
		$config['base_url'] = site_url('historial/'.$student_id.'/');
		$config['total_rows'] = Payment::count(array('conditions' => array('student_id = ?', $student_id)));
		$config['per_page'] = '10'; 
		$config['num_links'] = '1'; 
		$config['first_link'] = '&larr; primero';
		$config['last_link'] = 'último &rarr;';
		$this->pagination->initialize($config);
		
		$h = Payment::find('all', array('conditions' => array('student_id = ?', $student_id), 'limit' => $config['per_page'], 'offset' => $offset));
		
		$this->table->set_heading('# Pago','Concepto','Fecha de pago','Importe', 'Cobrador', 'Acciones');
			foreach($h as $p)
			{
				foreach($p->detail as $d)
				{
					$this->table->add_row(
						$p->id,
						$d->debt->amount->concept->concepto.' '.$d->debt->amount->concept->ciclo_lectivo,
						$p->fecha->format('d/m/Y H:i a'),
						'$'.$d->importe,
						$p->user->apellido.', '.$p->user->nombre,
						anchor('alumnos/recibos/',img('static/img/icon/print.png'), 'class="tipwe" title="Imprimir recibo"').' '.anchor('alumnos/recibos/',img('static/img/icon/trash.png'), 'class="tipwe eliminar" title="Anular pago"')
					);
				}
			}
		$data['a'] = Student::find_by_id($student_id);
		$data['pagos'] = $this->table->generate();
		$data['pagination'] = $this->pagination->create_links();
		
		$this->template->write_view('content', 'pagos/historial',$data);
		$this->template->render();
	}

	public function agregar()
	{				
		if ( $_POST )
		{
			$this->load->helper('date');
			$this->load->library('Utils');
			$insert = $_POST;
			$insert['user_id'] = 1;
			$insert['fecha'] = date('Y-m-d');
			$pago = new Payment(
				elements( array(
					'student_id',
					'user_id',
					'fecha',
					'importe'
				), $insert )
			);
			if( $pago->is_valid( ) )
			{
				$pago->save();
				foreach($insert['parcial'] as $k => $v)
				{
					$detalle = array('debt_id' => $k, 'payment_id' => $pago->id , 'importe' => $v);
					$d = new Detail($detalle);
					if($d->is_valid())
					{
						$d->save();
					}
				}
				$this->session->set_flashdata('msg','<div class="success">El pago se realizó correctamente.</div>');
				redirect($this->agent->referrer());
			}
			else
			{
				$this->session->set_flashdata('msg','<div class="error">No pudo procesarse el pago, intente nuevamente.</div>');
			}
		}
	}
	
	function eliminar($id)
	{
		$a = Payment::find($id);
		$a->anulado = 1;
		$a->fecha_anulado = date('Y-m-d');
		$a->save();
		$this->session->set_flashdata('msg','<div class="success">El pago fué anulado.</div>');
		if ($this->agent->is_referral())
		{
			$str = $this->agent->referrer();
			$desde = strlen(base_url());
			redirect(substr($str,$desde));
		}
		redirect('pagos');
	}
}

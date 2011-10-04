<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Conceptos extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('id')) redirect('auth/login');
	}
	
	public function index($offset = 0)
	{
		$config['base_url'] = site_url('conceptos/index');
		$config['total_rows'] = Concept::count();
		$config['per_page'] = '10'; 
		$config['num_links'] = '10'; 
		$config['first_link'] = '&larr; primero';
		$config['last_link'] = 'último &rarr;';
		$this->load->library('pagination', $config);
		
		$conceptos = Concept::all(array('limit' => $config['per_page'], 'offset' => $offset) );
		
		$this->table->set_heading('Orden','Concepto', 'Pagos Parciales','Ciclo Lectivo','Acciones');
		foreach($conceptos as $concepto)
		{
			$this->table->add_row(
				$concepto->id,
				$concepto->concepto,
				($concepto->pago_parcial)?'Si':'No',
				$concepto->ciclo_lectivo,
				anchor('conceptos/ver/'.$concepto->id,img('static/img/icon/doc_lines.png'), 'class="tipwe" title="Ver detalles"').' '.
				anchor('conceptos/editar/'.$concepto->id,img('static/img/icon/pencil.png'), 'class="tipwe" title="Editar"').' '.
				anchor('conceptos/eliminar/'.$concepto->id,img('static/img/icon/trash.png'), 'class="tipwe eliminar" title="Eliminar"')
			);
		}
		
		$data['conceptos'] = $this->table->generate();
		$data['pagination'] = $this->pagination->create_links();
				
		$this->template->write_view('content', 'conceptos/index',$data);
		$this->template->render();
	}
	
	public function filters($offset=0)
	{
		$string = '%'.$this->input->post('concepto').'%';
		$ciclo = '%'.$this->input->post('ciclo').'%';
				
		$condiciones = '';
		$valores = array();
		
		if($string != '%%'){
			$condiciones .= " concepto LIKE ?";
			$valores['concepto'] = $string;
			}
		
		if($ciclo != '%%'){
			$condiciones .= " ciclo_lectivo LIKE ?";
			$valores['ciclo_lectivo'] = $ciclo;
			}
		
		$conditions = array_merge(array($condiciones), $valores);
		
		$config['base_url'] = site_url('conceptos/index');
		$config['total_rows'] = Concept::count(array('conditions' => $conditions));
		$config['per_page'] = '10'; 
		$config['num_links'] = '10'; 
		$config['first_link'] = '&larr; primero';
		$config['last_link'] = 'último &rarr;';
		$this->load->library('pagination', $config);
		
		$conceptos = Concept::all(array('conditions' => $conditions, 'limit' => $config['per_page'], 'offset' => $offset) );
		
		$this->table->set_heading('Orden','Concepto', 'Pagos Parciales','Ciclo Lectivo','Acciones');
		foreach($conceptos as $concepto)
		{
			$this->table->add_row(
				$concepto->id,
				$concepto->concepto,
				($concepto->pago_parcial)?'Si':'No',
				$concepto->ciclo_lectivo,
				anchor('conceptos/ver/'.$concepto->id,img('static/img/icon/doc_lines.png'), 'class="tipwe" title="Ver detalles"').' '.
				anchor('conceptos/editar/'.$concepto->id,img('static/img/icon/pencil.png'), 'class="tipwe" title="Editar"').' '.
				anchor('conceptos/eliminar/'.$concepto->id,img('static/img/icon/trash.png'), 'class="tipwe eliminar" title="Eliminar"')
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
			$concepto = new Concept( 
				elements( array('concepto', 'pago_parcial','ciclo_lectivo'), $_POST )
			);
			if( $concepto->is_valid( ) )
			{
				$concepto->save();
				$this->session->set_flashdata( 'msg','<div class="success">El Concepto se guardó correctamente.</div>' );
				redirect('conceptos');
			}
			else
			{
				$data['errors'] = $concepto->errors;
			}
		}
		
		$data['titulo'] = "Agregar Concepto";
		$data['action'] = "conceptos/agregar";
		
		$this->template->write_view('content', 'conceptos/agregar',$data);
		$this->template->render();
	}
	
	public function editar( $id )
	{	
		if(!$id)
		{
			$this->session->set_flashdata( 'msg','<div class="error">El Concepto solicitada no existe.</div>' );
			redirect('conceptos');
		}
		elseif ( $_POST )
		{
			$this->load->helper('date');
			$this->load->library('Utils');
					
			$concepto = Concept::find($id);
			
			$concepto->update_attributes(elements(array('concepto', 'pago_parcial','ciclo_lectivo'), $_POST ));
			
			if( $concepto->is_valid( ) )
			{
				if($concepto->save())
				{
					$this->session->set_flashdata( 'msg','<div class="success">El Concepto se guardó correctamente.</div>' );
					redirect('conceptos');
				}
				else
				{
					$this->session->set_flashdata( 'msg','<div class="error">Hubo un error al guardar los datos.</div>' );
					redirect('conceptos/editar/'.$id);
				}
			}
			else
			{
				$data['errors'] = $concepto->errors;
			}
		}
		else $data['a'] = Concept::find($id);
		
		$data['titulo'] = "Editar Concepto";
		$data['action'] = "conceptos/editar/".$id;
		
		$this->template->write_view('content', 'conceptos/agregar',$data);
		$this->template->render();
	}
	
	function eliminar($id)
	{
		$a = Concept::find($id);
		$a->delete();
		$this->session->set_flashdata('msg','<div class="success">El Concepto fué eliminado correctamente.</div>');
		redirect('conceptos');
	}
}

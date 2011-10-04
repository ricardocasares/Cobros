<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

	class City extends ActiveRecord\Model {
		
		static $belongs_to = array(
			array('state')
		);
		
		static $validates_presence_of = array(
			array('nombre', 'message' => '<span class="ferror">Debe ingresar una Ciudad</span>'),
			array('state_id', 'message' => '<span class="ferror">Seleccionar un Provincia</span>')
		);
			
		static $validates_uniqueness_of = array(
			array(array('nombre','state_id'), 'message' => '<span class="ferror">La ciudad ya existe para la provincia y país seleccionados</span>')
		);
	}

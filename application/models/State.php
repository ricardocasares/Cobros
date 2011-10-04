<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

	class State extends ActiveRecord\Model {
		
		static $has_many = array(
			array('city')
		);
		
		static $belongs_to = array(
			array('country')
		);
		
		static $validates_presence_of = array(
			array('provincia', 'message' => '<span class="ferror">Debe ingresar una Provincia</span>'),
			array('country_id', 'message' => '<span class="ferror">Seleccionar un País</span>')
		);
			
		static $validates_uniqueness_of = array(
			array(array('provincia','country_id'), 'message' => '<span class="ferror">La provincia ya existe para el país seleccionado</span>')
		);
	}

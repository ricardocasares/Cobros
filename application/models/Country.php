<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

	class Country extends ActiveRecord\Model {
		
		static $has_many = array(
			array('state')
		);
		
		static $validates_presence_of = array(
			array('pais', 'message' => '<span class="ferror">Debe ingresar un País</span>')
		);
			
		static $validates_uniqueness_of = array(
			array('pais', 'message' => '<span class="ferror">El país ya se encuentra cargado.</span>')
		);
	}

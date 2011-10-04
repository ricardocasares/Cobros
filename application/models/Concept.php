<?php 

	class Concept extends ActiveRecord\Model
	{
		static $has_many = array(
			array('amounts')
		);
		
		static $validates_presence_of = array(
			array('concepto', 'message' => '<span class="ferror">El Concepto no puede estar vacio</span>'),
			array('ciclo_lectivo', 'message' => '<span class="ferror">El Ciclo Lectivo no puede estar vacío</span>')
		);
		
		static $validates_uniqueness_of = array(
			array(array('concepto','ciclo_lectivo'), 'message' => '<span class="ferror">El Concepto ya existe para este ciclo lectivo</span>')
		);	
	}

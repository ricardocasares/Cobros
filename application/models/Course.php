<?php 

	class Course extends ActiveRecord\Model
	{
		static $belongs_to = array(
			array('division'),
			array('level')
		);
		
		static $validates_presence_of = array(
			array('course', 'message' => '<span class="ferror">Debe ingresar una Ciudad</span>'),
			array('division_id', 'message' => '<span class="ferror">Seleccionar una Division</span>'),
			array('level_id', 'message' => '<span class="ferror">Seleccionar una Division</span>')
		);
			
		static $validates_uniqueness_of = array(
			array(array('course','division_id','level_id'), 'message' => '<span class="ferror">El Curso ya existe</span>')
		);
	}

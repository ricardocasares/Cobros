<?php 

	class Level extends ActiveRecord\Model
	{
		static $has_many = array(
			array('modality'),
			array('course')
		);
		
		static $validates_presence_of = array(
			array('nivel', 'message' => '<span class="ferror">Debe ingresar la descripcion del nivel</span>')
		);
			
		static $validates_uniqueness_of = array(
			array(array('nivel'), 'message' => '<span class="ferror">El nivel ya existe</span>')
		);
	}

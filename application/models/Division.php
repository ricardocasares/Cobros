<?php 

	class Division extends ActiveRecord\Model
	{
		static $has_many = array(
			array('course')
		);
		
		static $validates_presence_of = array(
			array('division', 'message' => '<span class="ferror">Debe ingresar la división</span>')
		);
			
		static $validates_uniqueness_of = array(
			array(array('division'), 'message' => '<span class="ferror">La división ya existe</span>')
		);
	}

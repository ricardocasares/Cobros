<?php 
	
	class Amount extends ActiveRecord\Model
	{
		static $belongs_to = array(
			array('concept'),
			array('course')
		);
		
		static $has_many = array(
			array('debt'),
			array('scolarship')
		);
	}
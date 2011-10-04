<?php 

	class Detail extends ActiveRecord\Model
	{
		static $belongs_to = array(
			array('debt'),
			array('student','throug' => 'debt'),
			array('payment')
		);
		
		static $validates_numericality_of = array(
			array('importe', 'greater_than' => 0)
		);
	}
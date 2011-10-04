<?php 

	class Debt extends ActiveRecord\Model
	{
		static $has_many = array(
			array('detail'),
			array('payment', 'through' => 'detail')
		);
		
		static $belongs_to = array(
			array('amount'),
			array('student')
		);
	}
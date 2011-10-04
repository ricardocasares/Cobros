<?php 

	class Payment extends ActiveRecord\Model
	{
		static $has_many = array(
			array('detail'),
			array('debt', 'through' => 'detail')
		);
		
		static $belongs_to = array(
			array('student'),
			array('user')
		);
	}
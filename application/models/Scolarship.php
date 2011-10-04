<?php 

	class Scolarship extends ActiveRecord\Model
	{
		static $belongs_to = array(
			array('amount'),
			array('student')
		);
	}
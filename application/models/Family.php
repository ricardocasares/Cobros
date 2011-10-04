<?php 

	class Family extends ActiveRecord\Model
	{
		static $belongs_to = array(
			array('student'),
			array('tutor')
		);
	}
<?php 

	class Inscription extends ActiveRecord\Model
	{
		static $belongs_to = array(
			array('student'),
			array('course')
		);
	}
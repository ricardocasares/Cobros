<?php 

	class Tutor extends ActiveRecord\Model
	{
		static $has_many = array(
			array('family')
		);
	}
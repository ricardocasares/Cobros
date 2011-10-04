<?php 

	class Modality extends ActiveRecord\Model
	{
		static $belongs_to = array(
			array('level')
		);
	}
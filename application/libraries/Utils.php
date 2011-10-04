<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

	class Utils {
		
		function fecha_formato( $formato = "%Y-%m-%d", $fecha )
		{
			if(!empty($fecha))
			{
				$f = mdate( $formato , normal_to_unix( $fecha ) );
				return $f;
			}
			else return FALSE;
		}
		
	}
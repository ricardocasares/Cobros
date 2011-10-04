<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

	class User extends ActiveRecord\Model {
		
		static $before_save = array('encriptar_password');
		
		static $has_many = array(
			array('payment')
		);
		
		static $validates_presence_of = array(
			array('usuario', 'message' => '<span class="ferror">Se debe incluir el nombre de usuario.</span>'),
			array('email', 'message' => '<span class="ferror">Se debe incluir el email.</span>'),
			array('telefono', 'message' => '<span class="ferror">Se debe incluir al menos un nº de telefono.</span>'),
			array('nombre', 'message' => '<span class="ferror">Se debe incluir el nombre.</span>'),
			array('grupo', 'message' => '<span class="ferror">Debe elegir un nivel de acceso.</span>'),
			array('password', 'message' => '<span class="ferror">Debe ingresar una contraseña nueva o la anterior.</span>'),
			array('apellido', 'message' => '<span class="ferror">Se debe incluir el apellido.</span>')
		);
		
		static $validates_uniqueness_of = array(
			array('usuario', 'message' => '<span class="ferror">El nombre de usuario ya existe.</span>'),
			array('email', 'message' => '<span class="ferror">El email ya existe.</span>')
		);
		
		function encriptar_password()
		{
			if(array_key_exists('password',$this->dirty_attributes()))
				$this->password = sha1($this->password);
		}
		
		function validar($user, $pass)
		{
			$u = User::find_by_usuario($user);
			if($u)
			{
				if(sha1($pass) == $u->password)
				{
					return $u;
				}
				else
				{
					return FALSE;
				}
			}
			else
			{
				return FALSE;
			}
		}
		
		function recuperar($email)
		{
			$u = User::find_by_email($email);
			if($u)
			{
				$hash = uniqid();
				$u->hash = $hash;
				$u->save();
				return $hash;
			}
			else return FALSE;
		}
		
	}
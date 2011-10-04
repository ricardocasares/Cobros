<?php 

	class Auth extends CI_Controller {
	
		function login()
		{
			$this->load->view('auth/login');
		}
		
		function recuperar()
		{
			if($_POST)
			{
				$recuperar = User::recuperar($_POST['email']);
				if($recuperar)
				{
					$config['protocol'] = 'smtp';
					$config['smtp_host'] = 'mail.itexa.com.ar';
					$config['smtp_user'] = 'dante@itexa.com.ar';
					$config['smtp_pass'] = '1qaz2wsx3edc4rfv';
					$config['charset'] = 'utf-8';
					$config['wordwrap'] = TRUE;
					$config['mailtype'] = 'html';
					
					$this->load->library('email');
					$this->email->initialize($config);
					$this->email->from('dante@itexa.com.ar', 'Sistema de gestión');
					$this->email->to($_POST['email']);
					$this->email->subject('Instrucciones para recuperar tu clave');
					$msg = '<p>Si has pedido recuperar tu clave en el sistema haz '.anchor('auth/reset/'.$recuperar,'click aquí');
					$msg .= '</p><p>Si Ud. no solicitó el cambio de clave ignore este mensaje y elimínelo.</p>';
					$this->email->message($msg);

					if($this->email->send()) $this->session->set_flashdata('msg','<div class="success">Se envió un correo a su dirección con instrucciones para recuperar la clave.</div>');
					else $this->session->set_flashdata('msg','<div class="notice">Hubo un problema al enviar el correo, intenta nuevamente.</div>');
					
					redirect('auth/login');
				}
				else
				{
					$this->session->set_flashdata('msg','<div class="notice">La dirección de correo no existe en el sistema.</div>');
					redirect('auth/recuperar');
				}
			}
			else $this->load->view('auth/recuperar');
		}
		
		function reset($hash)
		{
			$u = User::find_by_hash($hash);
			if($u)
			{
				$pass = uniqid();
				$u->password = $pass;
				$u->hash = NULL;
				$u->save();
				$data['msg'] = '<p>Su clave ha sido reestablecida a:</p>';
				$data['msg'] .= '<p><strong class="resaltado">'.$pass.'</strong></p>';
				$data['msg'] .= '<p>Anotela en un lugar seguro e inicie sesión nuevamente para cambiarla.</p>';
			}
			else
			{
				$data['msg'] = 'Ha sido imposible recuperar su contraseña, intente nuevamente o pongase en contacto con el administrador del sistema.';
			}
			
			$this->load->view('auth/reset',$data);
		}
		
		function validar()
		{
			$auth = User::validar($_POST['usuario'],$_POST['password']);
			if($auth)
			{
				$data = array(
					'usuario' => $auth->usuario,
					'grupo' => $auth->grupo,
					'id' => $auth->id
				);
				$this->session->set_userdata($data);
				redirect('alumnos');
			}
			else
			{
				$this->session->set_flashdata('msg','<div class="notice">El nombre de usuario o contraseña son incorrectos.</div>');
				redirect('auth/login');
			}
		}
		
		function logout()
		{
			$this->session->sess_destroy();
			redirect('auth/login');
		}
	}

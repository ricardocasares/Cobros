<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Gestión de cobros</title>
	<?=link_tag('static/css/yui.css')?>
	<?=link_tag('static/css/estilo.css')?>
	<?=link_tag('static/css/dropdown.css')?>
	<!--[if lte IE 6]>
	<?=link_tag('static/css/dropdown_ie.css')?>
	<![endif]-->
	<?=link_tag('static/css/sgi-ui/jquery-ui-1.8.9.custom.css')?>
	<script src="<?=site_url('static/js/jquery-1.4.4.min.js')?>" type="text/javascript"></script>
	<script src="<?=site_url('static/js/jquery-ui-1.8.9.custom.min.js')?>" type="text/javascript"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			
			$(function() {
				setTimeout(function() {
					$('.error, .success, .notice').hide("blind", { direction: "vertical" }, 1000);
				}, 5000);
			});
		});
	</script>
</head>

<body>
	<div id="doc3" class="yui-t5">
		<div><?=$this->session->flashdata('msg');?></div>
		<div id="hd">
			<div class="menu">
				<ul>
					<li><?=anchor('auth/login', img('static/img/icon/user.png').' Inicie sesión', ($this->uri->segment(1) == 'alumnos') ? 'class="active"' : '')?>
				</ul>
			</div>
		</div>
		<div id="bd">
			<div id="yui-main">
				<div id="login" class="pad forms">
					<?=form_open('auth/recuperar')?>
						<?=form_label('Ingrese su dirección de e-mail','email')?>
					    <?=form_input(array('name' => 'email', 'id' => 'email'))?>
						<p><small>Enviaremos un correo a su dirección de e-mail con instrucciones para recuperar la clave.</small></p>
						<?=form_submit('login','Recuperar clave')?>
					<?=form_close()?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>

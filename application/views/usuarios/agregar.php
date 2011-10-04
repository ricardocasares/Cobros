<script type="text/javascript" src="<?php echo base_url().'static/js/chained.js'; ?>"></script>
<div class="yui-gb">
	<div class="pad">
		<h2><?=$titulo?></h2>
	</div>
	<div class="yui-u first">
		<div class="pad forms">
			<?=form_open($action)?>
			<?=form_label('Nombre','nombre')?>
			<?php echo isset($errors) ? $errors->on('nombre') : ''; ?>
			<?=form_input('nombre', isset($a->nombre) ? $a->nombre : set_value('nombre'),'id="nombre" tabindex=1')?>
			<?=form_label('Dirección','direccion')?>
			<?php echo isset($errors) ? $errors->on('direccion') : ''; ?>
			<?=form_input('direccion', isset($a->direccion) ? $a->direccion : set_value('direccion'),'id="direccion" tabindex=4')?>
			<?=form_label('Nombre de usuario','usuario')?>
			<?php echo isset($errors) ? $errors->on('usuario') : ''; ?>
			<?=form_input('usuario', isset($a->usuario) ? $a->usuario : set_value('usuario'),'id="usuario" tabindex=7')?>
		</div>
	</div>
	<div class="yui-u">
		<div class="pad forms">
			<?=form_label('Apellido','apellido')?>
			<?php echo isset($errors) ? $errors->on('apellido') : ''; ?>
			<?=form_input('apellido', isset($a->apellido) ? $a->apellido : set_value('apellido'),'id="apellido" tabindex=2')?>
			<?=form_label('Email','email')?>
			<?php echo isset($errors) ? $errors->on('email') : ''; ?>
			<?=form_input('email', isset($a->email) ? $a->email : set_value('email'),'id="email" tabindex=5')?>
			<?=form_label('Contraseña','password')?>
			<?php echo isset($errors) ? $errors->on('password') : ''; ?>
			<?=form_password('password','','id="password" tabindex=8')?>
		</div>
	</div>
	<div class="yui-u">
		<div class="pad forms">
			<?=form_label('Teléfono','telefono')?>
			<?php echo isset($errors) ? $errors->on('telefono') : ''; ?>
			<?=form_input('telefono', isset($a->telefono) ? $a->telefono : set_value('telefono'),'id="telefono" tabindex=3')?>
			<?=form_label('Celular','celular')?>
			<?php echo isset($errors) ? $errors->on('celular') : ''; ?>
			<?=form_input('celular', isset($a->celular) ? $a->celular : set_value('celular'),'id="celular" tabindex=6')?>
			<?php if($this->session->userdata('grupo') == 'admin'):?>
			<?=form_label('Nivel de acceso','grupo')?>
			<?php echo isset($errors) ? $errors->on('grupo') : ''; ?>
			<? $gs = array('' => 'Seleccione un nivel','admin' => 'Administrador', 'user' => 'Usuario regular');?>
			<?=form_dropdown('grupo', $gs, isset($a->grupo) ? $a->grupo : set_value('grupo'),'id="grupo" tabindex=10')?>
			<?php endif ?>
		</div>
	</div>
</div>
<div class="pad">
	<?=form_submit('enviar','Guardar','tabindex=11')?>
	<?
		$url = site_url('usuarios');
		$js = "window.location='".$url."'";
		$atri = array(
				'content'=>'Cancelar',
				'class'=>"button red",
				'name'=>"cancelar",
				'id'=>"cancelar",
				'value'=>"Cancelar",
				'onClick'=>$js,
				'tabindex'=> 12
				);
		echo form_button($atri); ?>
	<?=form_reset('enviar','Limpiar formulario',' tabindex=13')?>
	<?=form_close()?>
</div>
<script type="text/javascript">
	$(document).ready(function ()
	{
		$('#city_id').chainedTo('#state_id');
		$('#state_id').chainedTo('#country_id');
	})
</script>

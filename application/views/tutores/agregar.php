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
			<?=form_label('Sexo','sexo')?>
			<?php echo isset($errors) ? $errors->on('sexo') : ''; ?>
			<div class="radios">
				<?=form_radio(array(
					'name' => 'sexo',
					'tabindex' => '4',
					'id' => 'm',
					'value' => 'M',
					'checked' => (isset($a->sexo) && $a->sexo == 'M') ? 'checked' : set_radio('sexo','M')
				))?>
				<?=form_label('Masculino','m')?>
				<?=form_radio(array(
					'name' => 'sexo',
					'tabindex' => '4',
					'id' => 'f',
					'value' => 'F',
					'checked' => (isset($a->sexo) && $a->sexo == 'F') ? 'checked' : set_radio('sexo','F')
				))?>
				<?=form_label('Femenino','f')?>
			</div>
			<?=form_label('Ocupación','ocupacion')?>
			<?php echo isset($errors) ? $errors->on('ocupacion') : ''; ?>
			<?=form_input('ocupacion', isset($a->ocupacion) ? $a->ocupacion : set_value('ocupacion'),'id="ocupacion" tabindex=7')?>
			<?=form_label('País','pais')?>
			<?php echo isset($errors) ? $errors->on('pais') : ''; ?>
			<? $ps = array('Seleccione un país');
				foreach($paises as $p) $ps[$p->id] = $p->pais ?>
			<?=form_dropdown('pais', $ps, isset($a->city->state->country->id) ? $a->city->state->country->id : set_value('pais'),'id="country_id" tabindex=10')?>
			<?=form_label('Domicilio','domicilio')?>
			<?php echo isset($errors) ? $errors->on('domicilio') : ''; ?>
			<?=form_input('domicilio', isset($a->domicilio) ? $a->domicilio : set_value('domicilio'),'id="domicilio" tabindex=13')?>
			<?=form_label('Teléfono Trabajo','telefono_trabajo')?>
			<?php echo isset($errors) ? $errors->on('telefono_trabajo') : ''; ?>
			<?=form_input('telefono_trabajo', isset($a->telefono_trabajo) ? $a->telefono_trabajo : set_value('telefono_trabajo'),'id="telefono_trabajo" tabindex=16')?>
		</div>
	</div>
	<div class="yui-u">
		<div class="pad forms">
			<?=form_label('Apellido','apellido')?>
			<?php echo isset($errors) ? $errors->on('apellido') : ''; ?>
			<?=form_input('apellido', isset($a->apellido) ? $a->apellido : set_value('apellido'),'id="apellido" tabindex=2')?>
			<?=form_label('Tipo de documento','tipo_documento')?>
			<?php echo isset($errors) ? $errors->on('tipo_documento') : ''; ?>
			<? $dni = array('DNI' => 'DNI','LE' => 'LE','Pasaporte' => 'Pasaporte','Cédula' => 'Cédula');?>
			<?=form_dropdown('tipo_documento', $dni, isset($a->tipo_documento) ? $a->tipo_documento : set_value('tipo_documento'),'id="tipo_documento" tabindex=5')?>
			<?=form_label('Relación','relacion')?>
			<? $gs = array('Padre' => 'Padre', 'Madre' => 'Madre','Compartida' => 'Compartida');?>
			<?=form_dropdown('relacion', $gs, isset($a->relacion) ? $a->relacion : set_value('relacion'),'id="relacion" tabindex=8')?>
			<?=form_label('Provincia','state_id')?>
			<?php echo isset($errors) ? $errors->on('state_id') : ''; ?>
			<? $pro = array('Seleccione una provincia');
				foreach($provincias as $pr) $pro[$pr->id] = $pr->provincia.','.$pr->country_id?>
			<?=form_dropdown('state_id', $pro, isset($a->city->state->id) ? $a->city->state->id : set_value('state_id'),'id="state_id" tabindex=11')?>
			<?=form_label('Teléfono','telefono_fijo')?>
			<?php echo isset($errors) ? $errors->on('telefono_fijo') : ''; ?>
			<?=form_input('telefono_fijo', isset($a->telefono_fijo) ? $a->telefono_fijo : set_value('telefono_fijo'),'id="telefono_fijo" tabindex=14')?>
			<?=form_label('Email','email')?>
			<?php echo isset($errors) ? $errors->on('email') : ''; ?>
			<?=form_input('email', isset($a->email) ? $a->email : set_value('email'),'id="email" tabindex=17')?>
			</div>
	</div>
	<div class="yui-u">
		<div class="pad forms">
			<?=form_label('Fecha de nacimiento','fecha_nacimiento')?>
			<?php echo isset($errors) ? $errors->on('fecha_nacimiento') : ''; ?>
			<?=form_input('fecha_nacimiento', isset($a->fecha_nacimiento) ? $a->fecha_nacimiento->format('d/m/Y') : set_value('fecha_nacimiento'),'id="fecha_nacimiento" class="date" tabindex=3')?>
			<?=form_label('Nº de documento','nro_documento')?>
			<?php echo isset($errors) ? $errors->on('nro_documento') : ''; ?>
			<?=form_input('nro_documento', isset($a->nro_documento) ? $a->nro_documento : set_value('nro_documento'),'id="nro_documento" tabindex=6')?>
			<?=form_label('Nacionalidad','nacionalidad')?>
			<?php echo isset($errors) ? $errors->on('nacionalidad') : ''; ?>
			<?=form_input('nacionalidad', isset($a->nacionalidad) ? $a->nacionalidad : set_value('nacionalidad'),'id="nacionalidad" tabindex=9')?>
			<?=form_label('Ciudad','city_id')?>
			<?php echo isset($errors) ? $errors->on('city_id') : ''; ?>
			<? $cd = array('Seleccione una ciudad');
				foreach($ciudades as $c) $cd[$c->id] = $c->nombre.','.$c->state_id?>
			<?=form_dropdown('city_id', $cd, isset($a->city_id) ? $a->city_id : set_value('city_id'),'id="city_id" tabindex=12')?>
			<?=form_label('Celular','celular')?>
			<?php echo isset($errors) ? $errors->on('celular') : ''; ?>
			<?=form_input('celular', isset($a->celular) ? $a->celular : set_value('celular'),'id="celular" tabindex=15')?>
		</div>
	</div>
</div>
<div class="pad">
	<?=form_submit('enviar','Guardar','tabindex=20')?>
	<?
		$url = site_url('tutores');
		$js = "window.location='".$url."'";
		$atri = array(
				'content'=>'Cancelar',
				'class'=>"button red",
				'name'=>"cancelar",
				'id'=>"cancelar",
				'value'=>"Cancelar",
				'onClick'=>$js,
				'tabindex'=>21
				);
		echo form_button($atri); ?>
	<?=form_reset('enviar','Limpiar formulario',' tabindex=22')?>
	<?=form_close()?>
</div>
<script type="text/javascript">
	$(document).ready(function ()
	{
		$('#city_id').chainedTo('#state_id');
		$('#state_id').chainedTo('#country_id');
	})
</script>

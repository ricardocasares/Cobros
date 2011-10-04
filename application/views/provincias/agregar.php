<div class="yui-gb">
	<div class="pad">
		<h2><?=$titulo?></h2>
	</div>
	<div class="yui-u first">
		<div class="pad forms">
			<?=form_open($action)?>
			<?=form_label('País','country_id')?>
			<?php echo isset($errors) ? $errors->on('country_id') : ''; ?>
			<? 	$ps = array();
				foreach($paises as $p) $ps[$p->id] = $p->pais; ?>
			<?=form_dropdown('country_id', $ps, isset($a->country_id) ? $a->country_id : set_value('country_id'),'id="country_id"')?>
			<?=form_label('Provincia','provincia')?>
			<?php echo isset($errors) ? $errors->on('provincia_and_country_id') : ''; ?>
			<?php echo isset($errors) ? $errors->on('provincia') : ''; ?>
			<?=form_input('provincia', isset($a->provincia) ? $a->provincia : set_value('provincia'),'id="provincia"')?>
		</div>
	</div>
</div>
<div class="pad">
	<?=form_submit('enviar','Guardar')?>
	<?
		$url = site_url('provincias');
		$js = "window.location='".$url."'";
		$atri = array(
				'content'=>'Cancelar',
				'class'=>"button red",
				'name'=>"cancelar",
				'id'=>"cancelar",
				'value'=>"Cancelar",
				'onClick'=>$js
				);
		echo form_button($atri);
	?>
	<?=form_reset('limpiar','Limpiar formulario')?>
	<?=form_close()?>
</div>

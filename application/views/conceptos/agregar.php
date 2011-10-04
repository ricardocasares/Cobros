<div class="yui-gb">
	<div class="pad">
		<h2><?=$titulo?></h2>
	</div>
	<div class="yui-u first">
		<div class="pad forms">
			<?=form_open($action)?>
			<?=form_label('Concepto','concepto')?>
			<?php echo isset($errors) ? $errors->on('concepto') : ''; ?>
			<?=form_input('concepto', isset($a->concepto) ? $a->concepto : set_value('concepto'),'id="concepto"')?>
			<?=form_label('Ciclo Lectivo','ciclo_lectivo')?>
			<?php echo isset($errors) ? $errors->on('ciclo_lectivo') : ''; ?>
			<?=form_input('ciclo_lectivo', isset($a->ciclo_lectivo) ? $a->ciclo_lectivo : set_value('ciclo_lectivo'),'id="ciclo_lectivo"')?>
			<?php echo isset($errors)? $errors->on('concepto_and_ciclo_lectivo') : ''; ?>
			<?=form_label('Pago Parcial','pago_parcial')?>
			<?php echo isset($errors)? $errors->on('pago_parcial') : ''; ?>
			<?=form_checkbox(array('name' => 'pago_parcial', 'class' => 'check', 'value'=>'1'),'',(isset($a->pago_parcial)&&($a->pago_parcial)))?>
		</div>
	</div>
</div>
<div class="pad">
	<?=form_submit('enviar','Guardar')?>
	<?
		$url = site_url('conceptos');
		$js = "window.location='".$url."'";
		$atri = array(
				'content'=>'Cancelar',
				'class'=>"button red",
				'name'=>"cancelar",
				'id'=>"cancelar",
				'value'=>"Cancelar",
				'onClick'=>$js
				);
		echo form_button($atri); ?>
	<?=form_reset('limpiar','Limpiar formulario')?>
	<?=form_close()?>
</div>

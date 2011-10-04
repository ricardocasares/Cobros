<script type="text/javascript" src="<?php echo base_url().'static/js/chained.js'; ?>"></script>
<script type="text/javascript">
	$(function() {
		$('#state_id').chainedTo('#country_id');
	});
	</script>
<div class="yui-gb">
	<div class="pad">
		<h2><?=$titulo?></h2>
	</div>
	<div class="yui-u first">
		<div class="pad forms">
			<?=form_open($action)?>
			<?=form_label('País','country_id')?>
			<?php echo isset($errors) ? $errors->on('country_id') : ''; ?>
			<? 	$ps = array(0=>'Seleccione un País');
				foreach($paises as $p) $ps[$p->id] = $p->pais; ?>
			<?=form_dropdown('country_id', $ps, isset($a->state->country_id) ? $a->state->country_id : set_value('country_id'),'id="country_id"')?>
			<?=form_label('Provincia','state_id')?>
			<?php echo isset($errors) ? $errors->on('state_id') : ''; ?>
			<select name="state_id" id="state_id">
				<option value=0>Seleccionar</option>
				<?php foreach ($provincias as $p): ?>
					<option
						value="<?=$p->id; ?>"
						class="<?= $p->country_id;?>"
						<? if(isset($a->state_id)&&($a->state_id == $p->id)) echo "selected";
							elseif(isset($_POST['state_id']) && $_POST['state_id']==$p->id) echo "selected";
							?>>
						<?= $p->provincia; ?>
					</option>
				<?php endforeach?>
			</select>
			<?=form_label('Ciudad','nombre')?>
			<?php echo isset($errors) ? $errors->on('nombre') : ''; ?>
			<?php echo isset($errors) ? $errors->on('nombre_and_state_id') : ''; ?>
			<?=form_input('nombre', isset($a->nombre) ? $a->nombre : set_value('nombre'),'id="nombre"')?>
		</div>
	</div>
</div>
<div class="pad">
	<?=form_submit('enviar','Guardar')?>
	<?
		$url = site_url('ciudades');
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
		//form_button('cancelar','Cancelar','class="button red"'); ?>
	<?=form_reset('limpiar','Limpiar formulario')?>
	<?=form_close()?>
</div>

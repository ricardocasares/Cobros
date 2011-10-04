<script type="text/javascript" src="<?php echo base_url().'static/js/chained.js'; ?>"></script>
<script type="text/javascript">
	$(function() {
		$('#state_id').chainedTo('#country');
	});
	</script>
<div class="pad">
	<div id="filtros">
		<form action="" method="post" id="f">
			<?=img('static/img/icon/zoom.png')?>
			<?=form_input(array('name' => 'ciudad', 'class' => 'tipns', 'title' => 'Nombre de la ciudad', 'autocomplete' => 'off', 'value'=>isset($filtros[0]) ? str_replace("%", "", $filtros[0]): ""))?>
			<?=img('static/img/icon/filter.png')?>
			<select name="state_id" id="state_id" original-title="Filtrar por provincia" class="tipns">
				<option value=0>Todos</option>
				<?php foreach ($provincias as $p): ?>
					<option value="<?=$p->id; ?>" class="<?=$p->country_id?>"
						<? if(isset($filtros[1])&&($filtros[1] == $p->id)) echo "selected"; ?>>
						<?= $p->provincia; ?>
					</option>
				<?php endforeach?>
			</select>
			<?=img('static/img/icon/filter.png')?>
			<?$ps = array();
				$ps[0] = 'Todos';
				foreach($paises as $p) $ps[$p->id] = $p->pais;
				echo form_dropdown('country_id',$ps,isset($filtros[2]) ? $filtros[2] : set_value('country_id'),'id="country" class="tipns" title="Filtrar por país"')?>
			<?=anchor('ciudades','Remover','id="clean"')?>
		</form>
	</div>
	<br/>
		<div align="right"><?=anchor('ciudades/agregar', img('static/img/icon/sq_plus.png').' Agregar')?></div>
	<div id="results">
		<?=$ciudades?>
		<div class="pagination">
			<?=$pagination?>
		</div>
	</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function(){
		$('#filtros select').change(function(){
			$('#results').html('<img src="/sgi/static/img/ui-anim_basic_16x16.gif" /> Buscando...');
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('ciudades/filters'); ?>",
				data: $('#filtros form').serialize(),
				success: function(data){
					$('#results').html(data);
				}
			});
		})
		
		$('#clean').click(function(e){
			e.preventDefault();
			$(':input','#f')
			.not(':button, :submit, :reset, :hidden')
			.val('')
			.removeAttr('checked')
			.removeAttr('selected');
			$('#results').html('<img src="/sgi/static/img/ui-anim_basic_16x16.gif" /> Buscando...');
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('ciudades/filters'); ?>",
				data: $('#filtros form').serialize(),
				success: function(data){
					$('#results').html(data);
				}
			});
		})
		
		$('#filtros input').keyup(function(){
			$('#results').html('<img src="/sgi/static/img/ui-anim_basic_16x16.gif" /> Buscando...');
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('ciudades/filters'); ?>",
				data: $('#filtros form').serialize(),
				success: function(data){
					$('#results').html(data);
				}
			});
		})
	});
</script>

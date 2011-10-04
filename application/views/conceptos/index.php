<div class="pad">
	<div id="filtros">
		<form action="" method="post" id="f">
			<?=img('static/img/icon/zoom.png')?>
			<?=form_input(array('name' => 'concepto', 'class' => 'tipns', 'title' => 'Concepto', 'autocomplete' => 'off', 'value'=>isset($filtros[0]) ? str_replace("%", "", $filtros[0]): ""))?>
			<?=img('static/img/icon/zoom.png')?>
			<?=form_input(array('name' => 'ciclo', 'class' => 'tipns', 'title' => 'Ciclo', 'autocomplete' => 'off', 'value'=>isset($filtros[0]) ? str_replace("%", "", $filtros[0]): ""))?>
			<?=anchor('conceptos','Remover','id="clean"')?>
		</form>
	</div>
	<br/>
		<div align="right"><?=anchor('conceptos/agregar', img('static/img/icon/sq_plus.png').' Agregar')?></div>
	<div id="results">
		<?=$conceptos?>
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
				url: "<?php echo site_url('conceptos/filters'); ?>",
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
				url: "<?php echo site_url('conceptos/filters'); ?>",
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
				url: "<?php echo site_url('conceptos/filters'); ?>",
				data: $('#filtros form').serialize(),
				success: function(data){
					$('#results').html(data);
				}
			});
		})
	});
</script>

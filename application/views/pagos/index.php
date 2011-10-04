<div class="pad">
	<div id="filtros">
		<form action="" method="post" id="f">
			<?//=form_input('fecha_desde', date('d/m/Y', mktime(0,0,0,date('m')-1,date('d'),date('Y'))),'id="fecha_desde" class="date"')?>
			<?=form_input('fecha_desde','','id="fecha_desde" class="date tipns" title="Fecha Inicial"')?>
			<?=form_input('fecha_hasta',date('d/m/Y'),'id="fecha_hasta" class="date tipns" title="Fecha Final"')?>
			<?=img('static/img/icon/zoom.png')?>
			<?=form_input(array('name' => 'estudiante', 'class' => 'tipns', 'title' => 'Estudiante', 'autocomplete' => 'off'))?>
			<div class="selects">
			<?=img('static/img/icon/filter.png')?>
			<?$ps = array();
				$ps[0] = 'Todos';
				foreach($usuarios as $p) $ps[$p->id] = $p->apellido.' '.$p->nombre;
				echo form_dropdown('user_id',$ps,'','id="user_id" class="tipns" title="Filtrar por Usuario"')?>
			<?=anchor('pagos','Remover','id="clean"')?>
			</div>
		</form>
	</div>
	<br/>
		<div align="right"><?=anchor('pagos/agregar', img('static/img/icon/sq_plus.png').' Agregar')?></div>
	<div id="results">
		<?=$pagos?>
		<div class="pagination">
			<?=$pagination?>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#filtros select').change(function(){
			$('#results').html('<img src="/sgi/static/img/ui-anim_basic_16x16.gif" /> Buscando...');
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('pagos/filters'); ?>",
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
				url: "<?php echo site_url('pagos/filters'); ?>",
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
				url: "<?php echo site_url('pagos/filters'); ?>",
				data: $('#filtros form').serialize(),
				success: function(data){
					$('#results').html(data);
				}
			});
		})
		
		$('#filtros input').change(function(){
			$('#results').html('<img src="/sgi/static/img/ui-anim_basic_16x16.gif" /> Buscando...');
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('pagos/filters'); ?>",
				data: $('#filtros form').serialize(),
				success: function(data){
					$('#results').html(data);
				}
			});
		})
	});
</script>

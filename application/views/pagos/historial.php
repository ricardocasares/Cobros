<script type="text/javascript">
 $(document).ready(function() { 
	$('#filtros select').change(function(){
		$('#results').html('<img src="/sgi/static/img/ui-anim_basic_16x16.gif" /> Buscando...');
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('alumnos/filters'); ?>",
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
			url: "<?php echo site_url('alumnos/filter'); ?>",
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
			url: "<?php echo site_url('alumnos/filter'); ?>",
			data: $('#filtros form').serialize(),
			success: function(data){
				$('#results').html(data);
			}
		});
	})
});
</script>
<div class="pad">
	<h2>Historial de pagos para <?=anchor('alumnos/ver/'.$a->id, $a->nombre.' '.$a->apellido)?></h2>
	<div id="filtros">
		<form action="" method="post" id="f">
			<?=img('static/img/icon/zoom.png')?>
			<?=form_input(array('name' => 'string', 'class' => 'tipns', 'title' => 'Nombre, apellido o DNI'))?>
			<div class="selects"><?=anchor('#','Remover','id="clean"')?>
			</div>
		</form>
	</div>
	<div id="results">
		<?=$pagos?>
		<div class="pagination">
			<?=$pagination?>
		</div>
	</div>
</div>

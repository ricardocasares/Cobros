<script type="text/javascript">
$(document).ready(function(){
	
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
			url: "<?php echo site_url('paises/filters'); ?>",
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
			url: "<?php echo site_url('paises/filters'); ?>",
			data: $('#filtros form').serialize(),
			success: function(data){
				$('#results').html(data);
			}
		});
	})
});
</script>
<div class="pad">
	<h2>Listado de pa&iacute;ses</h2>
	<div id="filtros">
		<form action="" method="post" id="f">
			<?=img('static/img/icon/zoom.png')?>
			<?=form_input(array('name' => 'pais', 'class' => 'tipns', 'title' => 'Ingrese el nombre del pais'))?>
			<div class="selects">
			<?=anchor('paises','Remover','id="clean"')?>
			</div>
		</form>
	</div>
	<br/>
		<div align="right"><?=anchor('paises/agregar', img('static/img/icon/sq_plus.png').' Agregar')?></div>
	<div id="results">
		<?=$paises?>
		<div class="pagination">
			<?=$pagination?>
		</div>
	</div>
</div>

<div class="pad">
	<div id="filtros">
		<form action="" method="post" id="f">
			<?=img('static/img/icon/zoom.png')?>
			<?=form_input(array('name' => 'curso', 'class' => 'tipns', 'title' => 'Nombre del curso', 'autocomplete' => 'off', 'value'=>isset($filtros[0]) ? str_replace("%", "", $filtros[0]): ""))?>
			<?=img('static/img/icon/filter.png')?>
			<select name="division_id" id="division_id" original-title="Filtrar por división" class="tipns">
				<option value=0>Todos</option>
				<?php foreach ($divisiones as $p): ?>
					<option value="<?=$p->id; ?>"
						<? if(isset($filtros[1])&&($filtros[1] == $p->id)) echo "selected"; ?>>
						<?= $p->division; ?>
					</option>
				<?php endforeach?>
			</select>
			<?=img('static/img/icon/filter.png')?>
			<?$ps = array();
				$ps[0] = 'Todos';
				foreach($niveles as $p) $ps[$p->id] = $p->descripcion;
				echo form_dropdown('level_id',$ps,isset($filtros[2]) ? $filtros[2] : set_value('level_id'),'id="level" class="tipns" title="Filtrar por Nivel"')?>
			<?=anchor('cursos','Remover','id="clean"')?>
		</form>
	</div>
	<br/>
		<div align="right"><?=anchor('cursos/agregar', img('static/img/icon/sq_plus.png').' Agregar')?></div>
	<div id="results">
		<?=$cursos?>
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
				url: "<?php echo site_url('cursos/filters'); ?>",
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
				url: "<?php echo site_url('cursos/filters'); ?>",
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
				url: "<?php echo site_url('cursos/filters'); ?>",
				data: $('#filtros form').serialize(),
				success: function(data){
					$('#results').html(data);
				}
			});
		})
	});
</script>

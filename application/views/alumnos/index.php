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
	<div id="filtros">
		<form action="" method="post" id="f">
			<?=img('static/img/icon/zoom.png')?>
			<?=form_input(array('name' => 'string', 'class' => 'tipns', 'title' => 'Nombre, apellido o DNI'))?>
			<div class="selects">
			<?if($this->session->userdata('admin')):?>
				<?=img('static/img/icon/user.png')?>
				<?=form_dropdown('user_id',array('Varón','Mujer'),'','id="users" class="tipns" title="Filtrar por usuario"')?>
				<?=img('static/img/icon/globe_2.png')?>
				<?=form_dropdown('branch_id',array('hola'=>'hola'),'','id="branches" class="tipns" title="Filtrar por sucursal"')?>
			<?php endif;?>
			<?=img('static/img/icon/filter.png')?>
			<?=form_dropdown('role_id',array('Todos','Básico'=>'Básico', 'Primario' => 'Primario', 'Secundario' => 'Secundario'),'','id="roles" class="tipns" title="Filtrar por niveles"')?>
			<?=img('static/img/icon/filter.png')?>
			<?=form_dropdown('status_id',array('Todos', '1'=>'1º', '2' => '2º'),'','id="status" class="tipns" title="Filtrar por curso"')?>
			<?=img('static/img/icon/filter.png')?>
			<?=form_dropdown('type_id',array('Todos', 'A','B','C','D'),'','id="types" class="tipns" title="Filtrar por división"')?>
			<?=anchor('#','Remover','id="clean"')?>
			</div>
		</form>
	</div>
	<br/>
		<div align="right"><?=anchor('alumnos/agregar', img('static/img/icon/sq_plus.png').' Agregar')?></div>
	<div id="results">
		<?=$alumnos?>
		<div class="pagination">
			<?=$pagination?>
		</div>
	</div>
</div>

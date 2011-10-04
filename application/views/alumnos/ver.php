<div class="yui-gd">
	<div class="yui-u first">
		<div class="pad">
			<h2>Datos personales</h2>
			<dl>
				<dt>Nombre</dt>
				<dd><?=$a->nombre.' '.$a->apellido?></dd>
				<dt>Fecha de nacimiento</dt>
				<dd><?=$a->fecha_nacimiento->format('d/m/Y')?></dd>
				<dt>Sexo</dt>
				<dd><?=$a->sexo?></dd>
				<dt>Grupo sanguíneo</dt>
				<dd><?=$a->grupo_sanguineo?></dd>
				<dt>Documento</dt>
				<dd><?=$a->tipo_documento.' '.$a->nro_documento?></dd>
				<dt>Teléfono</dt>
				<dd><?=$a->telefono?></dd>
				<dt>Celular</dt>
				<dd><?=$a->celular?></dd>
				<dt>Domicilio</dt>
				<dd><?=$a->domicilio?></dd>
				<dt>Ciudad</dt>
				<dd><?=$a->city->nombre?></dd>
				<dt>Provincia</dt>
				<dd><?=$a->city->state->provincia?></dd>
				<dt>País</dt>
				<dd><?=$a->city->state->country->pais?></dd>
				<dt>Nacionalidad</dt>
				<dd><?=$a->nacionalidad?></dd>
				<dt>Nº Documento</dt>
				<dd><?=$a->nro_documento?></dd>
			</dl>
		</div>
	</div>
	<div class="yui-u">
		<div class="pad">
		<h2>Información relacionada</h2>
		<div class="accordion">
			<h3 class="slide">Deudas</h3>
			<div class="hide" id="cuotas">
			<? $hidden = array('student_id' => $a->id, 'importe' => 0);?>
			<?=form_open('pagos/agregar', array('id' => 'pagar'),$hidden)?>
			<?=$deudas?>
			<p><?=form_submit('tutores/agregar', 'Seleccione las cuotas a pagar','class="button" id="total" disabled')?></p>
			<?=form_close()?>
			<div id="results"></div>
			</div>
			<h3 class="slide">Pagos realizados (Últimos 10)</h3>
			<div class="hide" id="pagos">
			<?=$pagos?>
			<p><?=anchor('historial/'.$a->id, 'Ver historial completo de pagos', 'class="button"')?></p>
			</div>
			<h3 class="slide">Tutores</h3>
			<div class="hide">
			<table>
				<tr>
					<th>Nombre</th>
					<th>Teléfono</th>
					<th>Celular</th>
				</tr>
				<tr>
					<td>Ricardo Casares Puga</td>
					<td>264-423214</td>
					<td>15232324</td>
				</tr>
				<tr>
					<td>Beatriz Puga</td>
					<td>264-4241759</td>
					<td>15232348</td>
				</tr>
			</table>
			<p><?=anchor('tutores/agregar', 'Agregar nuevo tutor','class="button"')?></p>
			</div>
			<h3 class="slide">Inscripciones</h3>
			<div class="hide">
			<?=$inscripciones?>
			<p><?=anchor('tutores/agregar', 'Agregar inscripción','class="button"')?></p>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function()
	{
		$('tr').click(function ()
		{
			$(this).next('td.hide').toggle();
		});
		
		$('.accordion .slide').click(function()
		{
			$(this).next().toggle('blind','','fast');
			return false;
		}).next().hide();
		
		$('input.small').keyup(function()
		{
			var d = $(this).attr('numeric');
			var val = $(this).val();
			var orignalValue = val;
			val = val.replace(/[0-9]*/g, "");
			
			var msg="Solo puede ingresar números enteros"; 
			
			if (d=='decimal')
			{
			  value=value.replace(/\./, "");
			  msg="Solo se permiten valores numérico.";
			}
			
			if (val!='')
			{
				orignalValue=orignalValue.replace(/([^0-9].*)/g, "")
				$(this).val(orignalValue);
				alert(msg);
			}
			
		});

		$('input.small').change(function()
		{
			// value is present
			_alertColor = 'red';
			var tval=$.trim($(this).val());
			if (tval=='') return true;
			reg=/^0*/;
			tval=tval.replace(reg,'')

			if (tval!='') 
			val=parseInt(tval);
			else
			val=0;
			var min=parseInt($(this).attr('min'));
			var max=parseInt($(this).attr('max'));
			var msg="";

			if(min!='' && max !='')
			{
				msg='El valor del campo debería ser entre '+min + ' y ' + max + '.' ;
			}
			else{
				if(min!='') {msg='El valor debe ser mayor que '+min +'.';}
				else{
					if(max!='') {msg='El valor no puede ser mayor al saldo $'+ max +'.';}
				}
			}
			if(min!='')
			{
				if (min>val)
				{
					alert(msg);
					$(this).val('');
					$(this).css('border-color',_alertColor);
				}
				else $(this).css('border-color','green');
			}

			if (max!='')
			{
				if (val>max)
				{
					alert(msg);
					$(this).val('');
					$(this).css('border-color',_alertColor);
				}
				else $(this).css('border-color','green');
			}
			
			calculateSum();
		});
		
		$(".small").each(function()
		{
			$(this).keyup(function()
			{
                calculateSum();
            });
        });
		
		$('.check').click(function()
		{
			if($(this).attr('checked') == false)
			{
				$(this).prev().val('').attr('readonly',false);
				calculateSum();
			}
			else
			{
				$(this).prev().val($(this).val()).attr('readonly',true);
				calculateSum();
			}
		});
	});
	function calculateSum()
	{
 
        var sum = 0;
        //iterate through each textboxes and add the values
        $(".small").each(function()
		{ 
            //add only if the value is number
            if(!isNaN(this.value) && this.value.length!=0)
			{
                sum += parseFloat(this.value);
            }
 
        });
        //.toFixed() method will roundoff the final sum to 2 decimal places
		if(sum > 0)
		{
			$("#total").val('Total a pagar $ '+sum.toFixed(2)).attr('disabled',false);
			$("input[name=importe]").val(sum.toFixed(2));
		}
		else
		{
			$('#total').val('Seleccione las cuotas a pagar').attr('disabled',true);
			$("input[name=importe]").val(0);
		}
        
    }
</script>
@extends('layouts.app')

@section('control-panel')

{{-- Panel de control --}}
<div class="f_control-panel">
    <div class="f_cp__top">
        <div class="f_cp__top_left">
        	{{-- Informacion de pagina --}}
        	<span class="f_cp_title">Grupo</span>
            <span class="f_cp_title--secondary"> / Editar</span>
            {{-- Informacion de pagina --}}
        </div>
        <div class="f_cp__top_right"></div>
    </div>
    <div class="f_cp__bottom">
        <div class="f_cp__bottom_left">
        	{{-- Acciones buttons --}}
        	<div class="f_cp_bl_action-buttons">
                <button type="submit" form="formGrupoEditar" class="f_button f_button--primary tight">GUARDAR</button>
                <a href="{{ route('grupo.lista') }}" class="f_button f_button--secondary tight">DESCARTAR</a>
            </div>
            {{-- /Acciones buttons--}}
        </div>
        <div class="f_cp__bottom_right"></div>
    </div>
</div>
{{-- /Panel de control --}}

@endsection



@section('content-main')

{{-- Tarjeta de seccion --}}
<div class="f_card f_card--border mt-4">
    <div class="f_card__header">
    	<div class="f_card__title">
    		<span class="f_card__title-icon"><i class="fas fa-users mr-3"></i></span>
    		Editar grupo
    	</div>
    </div>
    <div class="f_card__body">
    	
    	<div class="w-full">
            <form action="{{ route('grupo.actualizar', [$grupo]) }}" 
            		method="post" class="f_input-box--flat" id="formGrupoEditar" enctype="multipart/form-data">
            		
            	@method('PUT')
            	@csrf
            	
    			<table class="f_table f_table--form">
    				<tbody>
    					<tr>
    						<td><label class="f_item_label f_field--required">Nivel</label></td>
    						<td>
    							<div class="f_item_content sm:w-60">
    								<select name="nivel" class="pretty_default f_input-box--flat" data-selectr="default">
                						<option value="">&nbsp</option>
        								@foreach($niveles as $nivel)
                    					<option value="{{ $nivel->NIV_CODIGO }}"
                    							@if ($nivel->NIV_CODIGO == old('nivel', $grupo->NIV_CODIGO)) selected @endif
                							>{{ $nivel->NIV_NOMBRE }}</option>
                    					@endforeach
                					</select>
    							</div>
    						</td>
    					</tr>
    					<tr>
    						<td><label class="f_item_label f_field--required">Sección</label></td>
    						<td>
    							<div class="f_item_content sm:w-60">
    								<input type="text" name="seccion" value="{{ old('seccion', $grupo->GRP_SECCION) }}" required>
    							</div>
    						</td>
    					</tr>
    					<tr>
    						<td><label class="f_item_label f_field--required">Fecha de inicio</label></td>
    						<td>
    							<div class="f_item_content sm:w-60">
    								<input type="date" name="fecha_inicio" value="{{ old('fecha_inicio', $grupo->GRP_FECHA_INICIO) }}" required>
    							</div>
    						</td>
    					</tr>
    					<tr>
    						<td><label class="f_item_label f_field--required">Fecha de cierre</label></td>
    						<td>
    							<div class="f_item_content sm:w-60">
    								<input type="date" name="fecha_cierre" value="{{ old('fecha_cierre', $grupo->GRP_FECHA_CIERRE) }}" required>
    							</div>
    						</td>
    					</tr>
    					<tr>
    						<td><label class="f_item_label f_field--required">Tipo de periodo</label></td>
    						<td>
    							<div class="f_item_content sm:w-60">
    								<input type="text" name="tipo_periodo" value="{{ old('tipo_periodo', $grupo->GRP_TIPO_PERIODO) }}" required>
    							</div>
    						</td>
    					</tr>
    					<tr>
    						<td><label class="f_item_label f_field--required">Total de periodos</label></td>
    						<td>
    							<div class="f_item_content sm:w-60">
    								<input type="number" name="total_periodos" value="{{ old('total_periodos', $grupo->GRP_TOTAL_PERIODOS) }}" min="1" required>
    							</div>
    						</td>
    					</tr>
    					<tr>
    						<td><label class="f_item_label f_field--required">Periodo actual</label></td>
    						<td>
    							<div class="f_item_content sm:w-60">
    								<input type="number" name="periodo_actual" value="{{ old('periodo_actual', $grupo->GRP_PERIODO_ACTUAL) }}" min="1" required>
    							</div>
    						</td>
    					</tr>
    					<tr>
    						<td><label class="f_item_label f_field--required">Estado</label></td>
    						<td>
    							<div class="f_item_content sm:w-60">
    								<select name="estado" class="pretty_default f_input-box--flat" data-selectr="default">
                						<option value="">&nbsp</option>
                    					<option value="0"
                    							@if (0 == old('estado', $grupo->GRP_ESTADO)) selected @endif>Cerrado</option>
                    					<option value="1"
                    							@if (1 == old('estado', $grupo->GRP_ESTADO)) selected @endif>Activo</option>
                					</select>
    							</div>
    						</td>
    					</tr>
    				</tbody>
    			</table>
            </form>
        </div>
        
    </div>
</div>
{{-- /Tarjeta de seccion --}}

@endsection


@section('scripts')

<script type="text/javascript">

f_formPreventSendWithEnter.init("formGrupoEditar");
prettySelect.create("formGrupoEditar");

</script>
@endsection

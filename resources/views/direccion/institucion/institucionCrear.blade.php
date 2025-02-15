@extends('layouts.app')

@section('control-panel')

{{-- Panel de control --}}
<div class="f_control-panel">
    <div class="f_cp__top">
        <div class="f_cp__top_left">
        	{{-- Informacion de pagina --}}
        	<span class="f_cp_title">Institución</span>
            <span class="f_cp_title--secondary"> / Nuevo</span>
            {{-- Informacion de pagina --}}
        </div>
        <div class="f_cp__top_right"></div>
    </div>
    <div class="f_cp__bottom">
        <div class="f_cp__bottom_left">
        	{{-- Acciones buttons --}}
        	<div class="f_cp_bl_action-buttons">
                <button type="submit" form="formInstitucionGuardar" class="f_button f_button--primary tight">GUARDAR</button>
                <a href="{{ route('institucion.mostrar') }}" class="f_button f_button--secondary tight">DESCARTAR</a>
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
    		<span class="f_card__title-icon"><i class="fas fa-school mr-3"></i></span>
    		Nuevo institución
    	</div>
    </div>
    <div class="f_card__body">
    
    	<div class="w-full">
            <form action="{{ route('institucion.guardar') }}"
            		method="post" class="f_input-box--flat" id="formInstitucionGuardar" enctype="multipart/form-data">
            	@csrf
            	
    			<table class="f_table f_table--form">
    				<tbody>
    					<tr>
    						<td><label class="f_item_label f_field">Logo</label></td>
    						<td>
    							<div class="f_item_content sm:w-60">
    								<div class="f_image--ref">
    									<img alt="" src="" id="imgLogo">
    								</div>
    								<div class="pt-2">
    									<input type="file" name="logo" id="fileLogo" class="hidden" accept="image/*">
    									<label for="fileLogo" class="f_button f_button--square small">Seleccionar</label>
    								</div>
    							</div>
    						</td>
    					</tr>
    					<tr>
    						<td><label class="f_item_label f_field--required">Código modular</label></td>
    						<td>
    							<div class="f_item_content sm:w-60">
    								<input type="text" name="codigo_modular" value="{{ old('codigo_modular')}}" required>
    							</div>
    						</td>
    					</tr>
    					<tr>
    						<td><label class="f_item_label f_field--required">Nombre</label></td>
    						<td>
    							<div class="f_item_content sm:w-60">
    								<input type="text" name="nombre" value="{{ old('nombre') }}" required>
    							</div>
    						</td>
    					</tr>
    					<tr>
    						<td><label class="f_item_label f_field--required">Director</label></td>
    						<td>
    							<div class="f_item_content sm:w-60">
    								<input type="text" name="director" value="{{ old('director') }}" required>
    							</div>
    						</td>
    					</tr>
    					<tr>
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

f_formPreventSendWithEnter.init("formInstitucionGuardar");

f_image.show({
	idInput: "fileLogo",
	idImg: "imgLogo"
});

</script>
@endsection


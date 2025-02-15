@extends('layouts.app')

@section('control-panel')

{{-- Panel de control --}}
<div class="f_control-panel">
    <div class="f_cp__top">
        <div class="f_cp__top_left">
        	{{-- Informacion de pagina --}}
        	<span class="f_cp_title">Clase</span>
            <span class="f_cp_title--secondary"> / Nuevo</span>
            {{-- Informacion de pagina --}}
        </div>
        <div class="f_cp__top_right"></div>
    </div>
    <div class="f_cp__bottom">
        <div class="f_cp__bottom_left">
        	{{-- Acciones buttons --}}
        	<div class="f_cp_bl_action-buttons">
                <button type="submit" form="formClaseGuardar" class="f_button f_button--primary tight">GUARDAR</button>
                <a href="{{ route('clase.lista') }}" class="f_button f_button--secondary tight">DESCARTAR</a>
            </div>
            {{-- /Acciones buttons--}}
        </div>
        <div class="f_cp__bottom_right"></div>
    </div>
</div>
{{-- /Panel de control --}}

@endsection



@section('content-main')

{{-- Información del grupo --}}
<div class="f_message f_message--full info">
	<strong>Grado y Sección: </strong> {{ $grupo->nivel->NIV_NOMBRE . " " . $grupo->GRP_SECCION }}
</div>
{{-- /Información del grupo --}}

{{-- Tarjeta de seccion --}}
<div class="f_card f_card--border mt-4">
    <div class="f_card__header">
    	<div class="f_card__title">
    		<span class="f_card__title-icon"><i class="fas fa-users mr-3"></i></span>
    		Agregar clase (Masiva)
    	</div>
    </div>
    <div class="f_card__body">
    
    	<div class="w-full">
            <form action="{{ route('clase.guardar') }}" 
            		method="post" class="f_input-box--flat" id="formClasesGuardar" enctype="multipart/form-data">
            	@csrf
            	
            	<div class="md:flex mb-6">
                    <div class="f_width_200 font-bold underline">Área</div>
                    <div class="f_width_200 font-bold underline">Profesor</div>
                    <div class="f_width_200 font-bold underline">Hora inicio</div>
                    <div class="f_width_200 font-bold underline">Hora cierre</div>
                </div>
                    
				@foreach($areasNoAsignadas as $area)
                    <div class="md:flex pb-6 mb-6 border-b border-gray-300">
                        <div class="f_width_200 flex">
                        	<div class="w-5 min-w-5">
                        		<input type="checkbox" id="clase_{{ $area->ARE_CODIGO }}" class="cursor-pointer"
                                    data-grupo="{{ $grupo->GRP_CODIGO }}" data-clase="{{ $area->ARE_CODIGO }}" value="">
                        	</div>
                        	<div><label for="chb_{{ $area->ARE_CODIGO }}" class="cursor-pointer font-bold">{{ $area->ARE_NOMBRE }}</label></div>
                        </div>
                        <div class="f_width_200">
                            <select id="profesor_{{ $area->ARE_CODIGO }}" class="pretty_default f_input-box--flat"
                            	data-clase="{{ $area->ARE_CODIGO }}">
                                <option value="">&nbsp</option>
                                @foreach($profesores as $profesor)
                                    <option value="{{ $profesor->PFS_CODIGO }}">
                                        {{ $profesor->PFS_NOMBRE ." ". $profesor->PFS_APELLIDO_PAT ." ". $profesor->PFS_APELLIDO_MAT }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="f_width_200">
                        	<input type="time" id="horaInicio_{{ $area->ARE_CODIGO }}" data-clase="{{ $area->ARE_CODIGO }}" value="">
                        </div>
                        <div class="f_width_200">
                        	<input type="time" id="horaCierre_{{ $area->ARE_CODIGO }}" data-clase="{{ $area->ARE_CODIGO }}" value="">
                        </div>
                    </div>
                @endforeach
            </form>
        </div>
        
    </div>
</div>
{{-- /Tarjeta de seccion --}}

@endsection




@section('scripts')
<script type="text/javascript">

f_formPreventSendWithEnter.init("formClasesGuardar");
prettySelect.create("formClasesGuardar");

</script>
@endsection


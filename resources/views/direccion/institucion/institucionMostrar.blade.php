@extends('layouts.app')

@section('control-panel')

{{-- Panel de control --}}
<div class="f_control-panel">
    <div class="f_cp__top">
        <div class="f_cp__top_left">
        	{{-- Informacion de pagina --}}
        	<span class="f_cp_title">Institución</span>
            <span class="f_cp_title--secondary"></span>
            {{-- Informacion de pagina --}}
        </div>
        <div class="f_cp__top_right"></div>
    </div>
    <div class="f_cp__bottom">
        <div class="f_cp__bottom_left">
        	{{-- Acciones buttons --}}
        	<div class="f_cp_bl_action-buttons">
                <a href="{{ route('institucion.editar') }}" 
                	class="f_button f_button--primary tight">EDITAR</a>
            	<a href="#" class="f_button f_button--refused tight">NUEVO</a>
    		</div>
            {{-- /Acciones buttons --}}
            
        </div>
        <div class="f_cp__bottom_right"></div>
    </div>
</div>
{{-- /Panel de control --}}

@endsection



@section('content-main')

{{-- Tarjeta de seccion --}}
<div class="f_card f_card--border mt-4 mb-4">
    <div class="f_card__header">
    	<div class="f_card__title">
    		<span class="f_card__title-icon"><i class="fas fa-school mr-3"></i></span>
    		Detalle de institución
    	</div>
    </div>
    <div class="f_card__body">
    	
    	<div class="mb-4">
			<div class="inline-block mr-2 md:mr-4">
      			<div class="f_image--ref">
      				@if($institucion->getLogo)
      					<img alt="" src="{{ $institucion->getLogo }}">
      				@else
      					<span class="fas fa-school" style=" color: #a69944"></span>
      				@endif
      			</div>
			</div>
			<div class="inline-block align-top">
				<span class="font-bold ">Ref. {{ $institucion->ITC_CODIGO }}</span><br/>
				<span class="font-bold ">{{ $institucion->ITC_NOMBRE }}</span>
			</div>
  		</div>
    	
    	<div class="w-full grid grid-cols-1 gap-8">
    		<div class="w-full">
                <table class="f_table f_table--list-item">
                    <tbody>
                        <tr>
                            <td><label class="f_item_label">Ref.</label></td>
                            <td><div class="f_item_content">{{ $institucion->ITC_CODIGO }}</div></td>
                        </tr>
                        <tr>
                            <td><label class="f_item_label">Código modular</label></td>
                            <td><div class="f_item_content">{{ $institucion->ITC_CODIGO_MODULAR }}</div></td>
                        </tr>
                        <tr>
                            <td><label class="f_item_label">Nombre</label></td>
                            <td><div class="f_item_content">{{ $institucion->ITC_NOMBRE }}</div></td>
                        </tr>
                        <tr>
                            <td><label class="f_item_label">Director</label></td>
                            <td><div class="f_item_content">{{ $institucion->ITC_DIRECTOR }}</div></td>
                        </tr>
                    </tbody>
                </table>
    		</div>
        </div>
        
    </div>
</div>
{{-- /Tarjeta de seccion --}}

@endsection



@section('scripts')
<script type="text/javascript">

</script>
@endsection
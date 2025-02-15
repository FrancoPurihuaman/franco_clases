@extends('layouts.app')

@section('control-panel')

{{-- Panel de control --}}
<div class="f_control-panel">
    <div class="f_cp__top">
        <div class="f_cp__top_left">
        	{{-- Informacion de pagina --}}
        	<span class="f_cp_title">Grupo</span>
            <span class="f_cp_title--secondary"></span>
            {{-- Informacion de pagina --}}
        </div>
        <div class="f_cp__top_right"></div>
    </div>
    <div class="f_cp__bottom">
        <div class="f_cp__bottom_left">
        	{{-- Acciones buttons --}}
        	<div class="f_cp_bl_action-buttons">
                <a href="{{ route('grupo.editar', ['id' => $grupo]) }}" 
                	class="f_button f_button--primary tight">EDITAR</a>
            	<a href="{{ route('grupo.crear') }}" class="f_button f_button--secondary tight">NUEVO</a>
    		</div>
            {{-- /Acciones buttons --}}
            
            {{-- Acciones menu --}}
            <div class="f_cp_bl_action-menu">
            	<div class="f_dropdown">
            		<button class="f_button f_button--other tight" id="btnDropCPanelActionsMenu"><i class="fas fa-cog pr-1"></i>Acciones</button>
            		<nav class="f_dropdown__menu f_dropdown__menu--left" id="dropCPanelActionsMenu">
            			<ul class="f_dropdown__list" id="dropCPanelActionsList">
        					<li class="f_dropdown__item">
        						<button type="button" id="btnShowModalEliminarGrupo" class="f_button--light tight">
        							Eliminar
            					</button>
        					</li>
        					<li class="f_dropdown__item"><a href="{{ route('clase.crear', ['idGrupo' => $grupo]) }}">Agregar clase</a></li>
            			</ul>
            		</nav>
            	</div>
            </div>
            {{-- /Acciones menu --}}
        </div>
        <div class="f_cp__bottom_right"></div>
    </div>
</div>
{{-- /Panel de control --}}

@endsection



@section('content-main')

<div class="lg:flex">
	{{-- Tarjeta de seccion - detale de grupo --}}
    <div class="f_card f_card--border mt-4 lg:w-1/2">
        <div class="f_card__header">
        	<div class="f_card__title">
        		<span class="f_card__title-icon"><i class="fas fa-users mr-3"></i></span>
        		Detalle de grupo
        	</div>
        </div>
        <div class="f_card__body">
        	
        	<div class="mb-4">
    			<div class="inline-block mr-2 md:mr-4">
          			<div class="f_image--ref">
          				<span class="fas fa-users" style=" color: #a69944"></span>
          			</div>
    			</div>
    			<div class="inline-block align-top">
    				<span class="font-bold ">Ref. {{ $grupo->GRP_CODIGO }}</span><br/>
    				<span class="font-bold ">{{ ucfirst($grupo->nivel->NIV_NOMBRE) . ' Sección ' . $grupo->GRP_SECCION }}</span>
    			</div>
      		</div>
        	
        	<div class="w-full">
                <table class="f_table f_table--list-item">
                    <tbody>
                        <tr>
                            <td><label class="f_item_label">Ref.</label></td>
                            <td><div class="f_item_content">{{ $grupo->GRP_CODIGO }}</div></td>
                        </tr>
                        <tr>
                            <td><label class="f_item_label">Nivel</label></td>
                            <td><div class="f_item_content">{{ $grupo->nivel->NIV_NOMBRE }}</div></td>
                        </tr>
                        <tr>
                            <td><label class="f_item_label">Sección</label></td>
                            <td><div class="f_item_content">{{ ucfirst($grupo->GRP_SECCION) }}</div></td>
                        </tr>
                        <tr>
                            <td><label class="f_item_label">Fecha de inicio</label></td>
                            <td><div class="f_item_content">{{ \Carbon\Carbon::parse($grupo->GRP_FECHA_INICIO)->format('d/m/Y') }}</div></td>
                        </tr>
                        <tr>
                            <td><label class="f_item_label">Fecha de cierre</label></td>
                            <td><div class="f_item_content">{{ \Carbon\Carbon::parse($grupo->GRP_FECHA_CIERRE)->format('d/m/Y') }}</div></td>
                        </tr>
                        <tr>
                            <td><label class="f_item_label">Tipo de periodo</label></td>
                            <td><div class="f_item_content">{{ ucfirst($grupo->GRP_TIPO_PERIODO) }}</div></td>
                        </tr>
                        <tr>
                            <td><label class="f_item_label">Número de periodos</label></td>
                            <td><div class="f_item_content">{{ $grupo->GRP_TOTAL_PERIODOS }}</div></td>
                        </tr>
                        <tr>
                            <td><label class="f_item_label">Periodo actual</label></td>
                            <td><div class="f_item_content">{{ $grupo->GRP_PERIODO_ACTUAL }}</div></td>
                        </tr>
                        <tr>
                            <td><label class="f_item_label">Estado</label></td>
                            <td><div class="f_item_content"><span class="f_badge @if($grupo->GRP_ESTADO == 0) {{ 'bg-red-500' }} @endif">{{ $grupo->getEstado }}</span></div></td>
                        </tr>
                        <tr>
                            <td><label class="f_item_label">Cantidad estudiantes</label></td>
                            <td>
                            	<div class="f_item_content">{{ $grupo->estudiantes()->count() }}
                            	<a href="{{ route('estudiante.lista') }}"></a>
                            	</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
    {{-- /Tarjeta de seccion - detale de grupo--}}
    
    
    {{-- Tarjeta de seccion - Clases --}}
    <div class="f_card f_card--border mt-4 lg:w-1/2 lg:ml-4">
        <div class="f_card__header">
        	<div class="f_card__title">
        		<span class="f_card__title-icon"><i class="fas fa-chalkboard-teacher mr-3"></i></span>
        		Clases
        	</div>
        </div>
        <div class="f_card__body">
        	{{-- Table --}}
            <div class="f_overflow_scroll-x">
                <table class="f_table" id="tableEstudiantes">
                    <thead>
                        <tr class="list_title">
                            <th class="f_nowrap_100">REF.</th>
                            <th class="f_nowrap_200">ÁREA</th>
                        </tr>
                    </thead>
                    <tbody>
                    	@foreach($grupo->clases as $clase)
                        <tr class="f_oddeven">
                            <td>
                                <a href="{{ route('clase.mostrar', ['id' => $clase]) }}" class="f_link" style="display: flex">
                                    <span style=" color: #a69944">
                                        <i class="fas fa-chalkboard-teacher mr-1"></i>
                                    </span>
                                    <span class="align-middtle">{{ $clase->CLS_CODIGO }}</span>
                                </a>
                            </td>
                            <td class="f_nowrap_200">{{ $clase->area->ARE_NOMBRE }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{-- /Table --}}
            
        </div>
    </div>
	{{-- /Tarjeta de seccion - Clases --}}
	
</div>
@endsection


@section('modals')

<div class="f_modal" id="modalEliminarGrupo">
    <div class="f_modal__content small">
        <div class="f_modal__header">
            <span class="f_modal__title">Eliminar Grupo</span>
            <button type="button" class="f_modal__close" data-dismis="close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="f_modal__body">
        	<div>¿Esta seguro de querer eliminar el grupo?</div>
        	<form action="{{ route('grupo.eliminar', ['id' => $grupo]) }}" 
        			method="post" class="hidden" id="formEliminarGrupo">
    			@method('DELETE');
				@csrf
        	</form>
        </div>
        <div class="f_modal__footer">
            <button type="submit" form="formEliminarGrupo" class="f_button f_button--outline tight">Si</button>
            <button type="button" class="f_button f_button--outline tight" data-dismis="close">No</button>
        </div>
    </div>
</div>

@endsection



@section('scripts')
<script type="text/javascript">

f_menu.init({
	containerId: "dropCPanelActionsMenu",
	menuId: "dropCPanelActionsList",
	toggleButtonId: "btnDropCPanelActionsMenu"
});

f_modal.init({
    btnShow: "btnShowModalEliminarGrupo",
    modal: "modalEliminarGrupo",
    backdrop: "static"
});

</script>
@endsection

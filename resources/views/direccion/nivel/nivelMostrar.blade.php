@extends('layouts.app')

@section('control-panel')

{{-- Panel de control --}}
<div class="f_control-panel">
    <div class="f_cp__top">
        <div class="f_cp__top_left">
        	{{-- Informacion de pagina --}}
        	<span class="f_cp_title">Nivel</span>
            <span class="f_cp_title--secondary"></span>
            {{-- Informacion de pagina --}}
        </div>
        <div class="f_cp__top_right"></div>
    </div>
    <div class="f_cp__bottom">
        <div class="f_cp__bottom_left">
        	{{-- Acciones buttons --}}
        	<div class="f_cp_bl_action-buttons">
                <a href="{{ route('nivel.editar', ['id' => $nivel]) }}" 
                	class="f_button f_button--primary tight">EDITAR</a>
            	<a href="{{ route('nivel.crear') }}" class="f_button f_button--secondary tight">NUEVO</a>
    		</div>
            {{-- /Acciones buttons --}}
            
            {{-- Acciones menu --}}
            <div class="f_cp_bl_action-menu">
            	<div class="f_dropdown">
            		<button class="f_button f_button--other tight" id="btnDropCPanelActionsMenu"><i class="fas fa-cog pr-1"></i>Acciones</button>
            		<nav class="f_dropdown__menu f_dropdown__menu--left" id="dropCPanelActionsMenu">
            			<ul class="f_dropdown__list" id="dropCPanelActionsList">
        					<li class="f_dropdown__item">
        						<button type="button" id="btnShowModalEliminarNivel" class="f_button--light tight">
        							Eliminar
            					</button>
        					</li>
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

{{-- Tarjeta de seccion --}}
<div class="f_card f_card--border mt-4">
    <div class="f_card__header">
    	<div class="f_card__title">
    		<span class="f_card__title-icon"><i class="fas fa-graduation-cap mr-3"></i></span>
    		Detalle de nivel
    	</div>
    </div>
    <div class="f_card__body">
    	
    	<div class="mb-4">
			<div class="inline-block mr-2 md:mr-4">
      			<div class="f_image--ref">
      				<span class="fas fa-graduation-cap" style=" color: #a69944"></span>
      			</div>
			</div>
			<div class="inline-block align-top">
				<span class="font-bold ">Ref. {{ $nivel->NIV_CODIGO }}</span><br/>
				<span class="font-bold ">{{ ucfirst($nivel->NIV_NOMBRE) }}</span>
			</div>
  		</div>
    	
    	<div class="w-full">
            <table class="f_table f_table--list-item">
                <tbody>
                    <tr>
                        <td><label class="f_item_label">Ref.</label></td>
                        <td><div class="f_item_content">{{ $nivel->NIV_CODIGO }}</div></td>
                    </tr>
                    <tr>
                        <td><label class="f_item_label">Nombre</label></td>
                        <td><div class="f_item_content">{{ ucfirst($nivel->NIV_NOMBRE) }}</div></td>
                    </tr>
                    <tr>
                        <td><label class="f_item_label">Descripción</label></td>
                        <td><div class="f_item_content">{{ ucfirst($nivel->NIV_DESCRIPCION) }}</div></td>
                    </tr>
                </tbody>
            </table>
        </div>
        
    </div>
</div>
{{-- /Tarjeta de seccion --}}

@endsection


@section('modals')

<div class="f_modal" id="modalEliminarNivel">
    <div class="f_modal__content small">
        <div class="f_modal__header">
            <span class="f_modal__title">Eliminar Nivel</span>
            <button type="button" class="f_modal__close" data-dismis="close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="f_modal__body">
        	<div>¿Esta seguro de querer eliminar el nivel?</div>
        	<form action="{{ route('nivel.eliminar', ['id' => $nivel]) }}" 
        			method="post" class="hidden" id="formEliminarNivel">
    			@method('DELETE');
				@csrf
        	</form>
        </div>
        <div class="f_modal__footer">
            <button type="submit" form="formEliminarNivel" class="f_button f_button--outline tight">Si</button>
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
    btnShow: "btnShowModalEliminarNivel",
    modal: "modalEliminarNivel",
    backdrop: "static"
});


</script>
@endsection

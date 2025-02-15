@extends('layouts.app')

@section("control-panel")

{{-- Panel de control --}}
<div class="f_control-panel">
    <div class="f_cp__top">
        <div class="f_cp__top_left">
        	{{-- Informacion de pagina --}}
        	<span class="f_cp_title">Grupos</span>
            <span class="f_cp_title--secondary"></span>
            {{-- Informacion de pagina --}}
        </div>
        <div class="f_cp__top_right">
        	<div class="f_cp_tr__search">
        		<form action="{{ route('grupo.lista') }}" class="f_input-box--flat">
					<input type="number" class="f_input-box--flat" name="filter_year" value="{{ old('filter_year') }}" placeholder="Año de apertura...">
        		</form>
    		</div>
        	<div class="f_cp_tr__filters">
            	<button type="button" class="f_filters__toggle f_button f_button--other tight" 
            			id="filtersBtnToggle" title="Aplicar filtros">
        			<i class="fas fa-filter"></i>
        		</button>
        	</div>
        </div>
    </div>
    <div class="f_cp__bottom">
        <div class="f_cp__bottom_left">
        	{{-- Acciones buttons --}}
        	<div class="f_cp_bl_action-buttons">
            	<a href="{{ route('grupo.crear') }}" class="f_button f_button--primary tight">NUEVO</a>
        	</div>
            {{-- /Acciones buttons --}}
        </div>
        <div class="f_cp__bottom_right">
        	{{-- Paginador --}}
			<div class="f_cp__pager">
				<span>
					{{ $pgdGruposLimits['from'] . ' - '.  $pgdGruposLimits['to']  }} / {{ $pgdGrupos->total() }}
				</span>
				@if ($pgdGrupos->hasPages())
				<span>
                    {{-- Previous Page Link --}}
                    @if (!$pgdGrupos->onFirstPage())
					<a rel="prev" href="{{ $pgdGrupos->previousPageUrl() }}"
                        class="f_button f_button--secondary tight" title="Página Anterior">
                        <i class="fas fa-chevron-left"></i>
					</a>
                    @else
                    <a href="#" class="f_button f_button--other tight">
                        <i class="fas fa-chevron-left"></i>
					</a>
                    @endif
                    
                    {{-- Next Page Link --}}
                    @if ($pgdGrupos->hasMorePages())
                    <a rel="next" href="{{ $pgdGrupos->nextPageUrl() }}"
                    	class="f_button f_button--secondary tight" title="Página Anterior">
                    	<i class="fas fa-chevron-right"></i>
                    </a>
                    @else
                    <a href="#" class="f_button f_button--other tight">
                        <i class="fas fa-chevron-right"></i>
					</a>
                    @endif
				</span>
				@endif
				
				<span>
					<a href="{{ route('grupo.lista') }}"
                        class="f_button f_button--other tight" title="Quitar filtros">
                        <i class="fas fa-times"></i>
					</a>
				</span>
            </div>
            {{-- /Paginador --}}
        </div>
    </div>
    
    {{-- Filtros --}}
	<div class="f_filters">
		<div class="f_filters__hidden-panel" id="filtersHiddenPanel">
			<button class="f_filters__close f_button f_button--other small" id="filtersBtnClose">
				<i class="fas fa-times"></i>
			</button>
        	<form action="{{ route('grupo.lista') }}" method="get" 
        			class="f_filters__options-panel f_input-box--flat"
        			id="formFilters">
    			<div class="f_filters__title">Filtrar grupos</div>
    			<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3  lg:grid-cols-4 gap-x-7 gap-y-4">
        			<div class="f_filters__item flex">
            			<label class="font-semibold mr-2">Ref.</label>
        				<div class="w-40">
        					<input type="text" name="filter_ref" value="{{ old('filter_ref') }}">
        				</div>
            		</div>
        			<div class="f_filters__item flex">
        				<label class="font-semibold mr-2">Nivel</label>
        				<div class="w-40">
        					<select name="filter_nivel" class="pretty_default f_input-box--flat">
        						<option value="">&nbsp</option>
								@foreach($niveles as $nivel)
            					<option value="{{ $nivel->NIV_CODIGO }}"
            							@if ($nivel->NIV_CODIGO == old('filter_nivel')) selected @endif
        							>{{ $nivel->NIV_NOMBRE }}</option>
            					@endforeach
        					</select>
        				</div>
        			</div>
            		<div class="f_filters__item flex">
        				<label class="font-semibold mr-2">Sección</label>
        				<div class="w-40">
        					<input type="text" name="filter_seccion" value="{{ old('filter_seccion') }}">
        				</div>
        			</div>
        			<div class="f_filters__item flex">
        				<label class="font-semibold mr-2">Año de apertura</label>
        				<div class="w-40">
        					<input type="number" name="filter_year" value="{{ old('filter_year') }}" min="1">
        				</div>
        			</div>
        			<div class="f_filters__item flex">
        				<label class="font-semibold mr-2">Mes de apertura</label>
        				<div class="w-40">
        					<select name="filter_mes" class="pretty_default f_input-box--flat">
        						<option value="">&nbsp</option>
            					<option value="1" @if ('1' == old('filter_mes')) selected @endif>Enero</option>
            					<option value="2" @if ('2' == old('filter_mes')) selected @endif>Febrero</option>
            					<option value="3" @if ('3' == old('filter_mes')) selected @endif>Marzo</option>
            					<option value="4" @if ('4' == old('filter_mes')) selected @endif>Abril</option>
            					<option value="5" @if ('5' == old('filter_mes')) selected @endif>Mayo</option>
            					<option value="6" @if ('6' == old('filter_mes')) selected @endif>Junio</option>
            					<option value="7" @if ('7' == old('filter_mes')) selected @endif>Julio</option>
            					<option value="8" @if ('8' == old('filter_mes')) selected @endif>Agosto</option>
            					<option value="9" @if ('9' == old('filter_mes')) selected @endif>Septiembre</option>
            					<option value="10" @if ('10' == old('filter_mes')) selected @endif>Octubre</option>
            					<option value="11" @if ('11' == old('filter_mes')) selected @endif>Noviembre</option>
            					<option value="12" @if ('12' == old('filter_mes')) selected @endif>Diciembre</option>
        					</select>
        				</div>
        			</div>
        			<div class="f_filters__item flex">
        				<label class="font-semibold mr-2">Estado</label>
        				<div class="w-40">
        					<select name="filter_estado" class="pretty_default f_input-box--flat">
        						<option value="">&nbsp</option>
            					<option value="1"  @if ('1' == old('filter_estado')) selected @endif>Activo</option>
            					<option value="0"  @if ('0' == old('filter_estado')) selected @endif>Cerrado</option>
        					</select>
        				</div>
        			</div>
    			</div>
    			<div class="f_filters__actions">
    				<button type="button" class="f_button f_button--other tight" onclick="cleanFormFilters()">LIMPIAR</button>
    				<button type="submit" class="f_button f_button--outline tight">FILTRAR</button>
    			</div>
        	</form>
		</div>
	</div>
	{{-- /Filtros --}}
</div>
{{-- /Panel de control --}}

@endsection



@section("content-main")

{{-- Tarjeta de seccion --}}
<div class="f_card">
    
    <div class="f_card__body">
    	<div class="flex">
    		{{-- Menu vertical de niveles --}}
    		<div class="basis-80 hidden lg:block">
                <nav class="f_menu-v f_menu-v--left" id="menu">
                    <ul class="f_menu-v__list">
                        @foreach($niveles as $nivel)
                        <li class="f_menu-v__item">
                            <a href="{{ route('grupo.lista') }}?filter_nivel={{ $nivel->NIV_CODIGO }}">
                            	<span class="icon"><i class="fas fa-folder"></i></span>{{ $nivel->NIV_NOMBRE }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </nav>
        	</div>
        	{{-- /Menu vertical de niveles  --}}
        	
    		{{-- Table --}}
            <div class="f_overflow_scroll-x">
                <table class="f_table" id="tableGrupos">
                    <thead>
                        <tr class="list_title">
                            <th class="f_nowrap_100">REF.</th>
                            <th class="f_nowrap_200">NIVEL</th>
                            <th class="f_nowrap_200">SECCIÓN</th>
                            <th class="f_nowrap_200">FECHA INICIO</th>
                            <th class="f_nowrap_200">FECHA CIERE</th>
                            <th class="f_nowrap_200">TIPO DE PERIODO</th>
                            <th class="f_nowrap_200">TOTAL DE PERIODOS</th>
                            <th class="f_nowrap_200">PERIODO ACTUAL</th>
                            <th class="f_nowrap_200">ESTADO</th>
                        </tr>
                    </thead>
                    <tbody>
                    	@foreach($pgdGrupos as $grupo)
                        <tr class="f_oddeven">
                            <td>
                                <a href="{{ route('grupo.mostrar', ['id' => $grupo]) }}" class="f_link" style="display: flex">
                                    <span style=" color: #a69944">
                                        <i class="fas fa-users mr-1"></i>
                                    </span>
                                    <span class="align-middtle">{{ $grupo->GRP_CODIGO }}</span>
                                </a>
                            </td>
                            <td class="f_nowrap_200">{{ $grupo->nivel->NIV_NOMBRE }}</td>
                            <td class="f_nowrap_200">{{ $grupo->GRP_SECCION }}</td>
                            <td class="f_nowrap_200">{{ $grupo->GRP_FECHA_INICIO}}</td>
                            <td class="f_nowrap_200">{{ $grupo->GRP_FECHA_CIERRE }}</td>
                            <td class="f_nowrap_200">{{ $grupo->GRP_TIPO_PERIODO }}</td>
                            <td class="f_nowrap_200">{{ $grupo->GRP_TOTAL_PERIODOS }}</td>
                            <td class="f_nowrap_200">{{ $grupo->GRP_PERIODO_ACTUAL }}</td>
                            <td class="f_nowrap_200"><span class="f_badge @if($grupo->GRP_ESTADO == 0) {{ 'bg-red-500' }} @endif">{{ $grupo->getEstado }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{-- /Table --}}
    	</div>
    </div>
</div>
{{-- /Tarjeta de seccion --}}

@endsection



@section('scripts')
<script type="text/javascript">

f_table.resizable("tableGrupos");
prettySelect.create("formFilters");
f_menu.init({
	containerId: "menu",
	menuId: "menu",
	closeSubmenuOnBlur: "no"
});

function cleanFormFilters(){
	window.f_form.clean({idForm: "formFilters"});
	window.prettySelect.cleanAll("formFilters");
}

</script>
@endsection

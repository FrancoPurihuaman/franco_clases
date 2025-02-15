<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Etiquetas meta --}}
    <title>{{ env('APP_NAME') }}</title>
    {{-- Favicon --}}
    <link rel="shortcut icon" type="image/png" href="{{ asset('img/icon.png') }}"/>
    {{-- Font Awesome --}}
	<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> -->
    <!-- SOLO PARA USO OFFLINE --> <link rel="stylesheet" href="{{ asset('resourse_offline/font/css/fontawesome.min.css') }}" />
    <!-- SOLO PARA USO OFFLINE --> <link rel="stylesheet" href="{{ asset('resourse_offline/font/css/solid.min.css') }}" />
	{{-- Tailwind --}}
	<!-- SOLO PARA USO OFFLINE --> <script src="{{ asset('resourse_offline/tailwind/tailwind.js') }}"></script>
	{{-- Slim select --}}
	<!-- <link href="https://unpkg.com/slim-select@2.10.0/dist/slimselect.css" rel="stylesheet" type="text/css">  -->
	<!-- SOLO PARA USO OFFLINE --> <link href="{{ asset('resourse_offline/slimselect/slimselect_2.10.0.css') }}" rel="stylesheet" type="text/css">
    {{-- Tema css --}}
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    
    {{-- Elementos para agragar al head --}}
    @yield('head')
    
</head>
<body class="f_web-page">
    {{-- Cabezera de pagina --}}
    <header class="f_web-page__header">
        {{-- Cabezera --}}
        <div class="f_header">
            
            <button class="f_menu__btnToggle f_menu_modules__btnToggle" id="btnToggleMenuModules"><i class="fas fa-bars"></i></button>

            {{-- Menu - opciones de modulo --}}
            <x-headerMenu class="f_menu--right" :modulo="$modulo"/>
            {{-- /Menu - opciones de modulo --}}
    
            {{-- Información addional --}}
            <div class="f_header__infoAux">
                <x-headerMessage />
                <x-headerNotification />
                <div class="f_header__btnToggle">
                    <button class="f_menu__btnToggle" id="btnToggleMenuHeader"><i class="fas fa-th"></i></button>
                </div>
                <x-headerCardInfoUser />
            </div>
            {{-- /Información addional --}}

        </div>
    </header>

    {{-- Cuerpo de pagina --}}
    <div class="f_web-page__body f_body-page">
    
		<div class="f_body-page__header">
			{{-- Panel de control --}}
			@yield('control-panel')
		</div>
		
		<div class="f_body-page__body">
			{{-- Contenido de principal --}}
        	@yield('content-main')
		</div>
    </div>


    {{-- Menu de modulos --}}
    <x-menuModulos />
    {{-- /Menu de modulos --}}
    
    @yield('modals')
    
    
    {{-- Slim select --}}
    <!-- <script src="https://unpkg.com/slim-select@2.10.0/dist/slimselect.min.js" type="text/javascript"></script> -->
    <!-- SOLO PARA USO OFFLINE --> <script src="{{ asset('resourse_offline/slimselect/slimselect_2.10.0.js') }}"></script>
    {{-- App js --}}
    <script src="{{ asset('js/app.js') }}"></script>
    
    <script type="text/javascript">
    	
    	{{-- Verificar si hay mensajes que mostrar --}}
    	
        {{-- Mensaje por error de validación --}}
        @if($errors->any())
            f_message.generate({
                type      : "error",
                subject   : "<b>Error de validación</b>",
                details   : Object.values({{ Illuminate\Support\Js::from($errors->all()) }})
            });
        @endif
        
        
        {{-- Mensaje de estado --}}
        @if(session('status'))
            var detailsSt = [];
            @isset(session('status')['details']) 
        		detailsSt = {{ Illuminate\Support\Js::from(session('status')['details']) }}
            @endisset
            
            f_message.generate({
                type      : "{{ session('status')['type'] }}",
                subject   : "<b> {{ session('status')['message'] }} </b>",
                details   : Object.values(detailsSt)
            });
        @endif
        
        
        {{-- Mensaje personalizado --}}
    	@isset($message)
    		@if($message)
                var messageJS = {{ Illuminate\Support\Js::from($message) }};
                var detailsMJS = (typeof(messageJS.details) === "undefined") ? [] : messageJS.details;
                if(messageJS){
                    f_message.generate({
                        type      : messageJS.type,
                        subject   : "<b>" + messageJS.message + "</b>",
                        details   : Object.values(detailsMJS)
                    });
                }
    		@endif
        @endisset
        
        {{-- /Verificar si hay alertas que mostrar --}}
        
        
        
        {{-- Crear inputs con slim select --}}
        
        var oContainerPrettySelect = {
        	oListSlimSelect : {},
        	create : function(idContainerSelect){
        		
        		if(idContainerSelect == ''){
            		console.error("Error.create: Debe ingresar el identificador para el contenedor de select");
            		return;
        	    }
        		
        		var nodeContainerSelect = document.querySelector('#'+idContainerSelect);
        		if(nodeContainerSelect){
        			this.oListSlimSelect[idContainerSelect] = [];
        			[].map.call(nodeContainerSelect.querySelectorAll('.pretty_default'), nodeSelect => {
            	    	
            	    	this.oListSlimSelect[idContainerSelect].push(new SlimSelect({
                        	select: nodeSelect
                        }));
            	    });
        		}else{
        			console.error("Error.create: No se encontró el contenedor con id "+ idContainerSelect);
        		}
        	},
        	cleanAll : function(idContainerSelect){
        	
        		if(idContainerSelect == ''){
            		console.error("Error.clearAll: Debe ingresar el identificador para el contenedor de select");
            		return;
        	    }
        		
        		if(this.oListSlimSelect[idContainerSelect]){
            	    this.oListSlimSelect[idContainerSelect].forEach(oPrettySelect => {
            	    	oPrettySelect.setSelected([]);
            	    });
        	    }else{
        	    	console.error("Error.clearAll: No se encontró el contenedor con id "+ idContainerSelect);
        	    }
        	},
        	clean : function(idContainerSelect, idSelect){
        	
        		if(idContainerSelect == '' || idSelect == ''){
            		console.error("Error.clear: Debe ingresar los identificadores para el select y su contenedor");
            		return;
        	    }
        		
        		if(this.oListSlimSelect[idContainerSelect]){
            		var oPrettySelect = this.oListSlimSelect[idContainerSelect].find((oPrettySelect) => oPrettySelect.settings.id === idSelect);
            		oPrettySelect.setSelected([]);
        	    }else{
        	    	console.error("Error.clear: No se encontró el contenedor con id "+ idContainerSelect);
        	    }
        	}
        };
        window.prettySelect = oContainerPrettySelect;
        
	    {{-- /Crear inputs slim select --}}
        
    </script>
    
    {{-- Scripts --}}
    @yield('scripts')
    
</body>
</html>
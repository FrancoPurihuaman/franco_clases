import { f_validation } from '../franco/libraries/f_validator';


	
const nl_chbs_clases = document.querySelectorAll('input[type="checkbox"][id^="clase_"]');

nl_chbs_clases.forEach(function(chb_clase){
	chb_clase.addEventListener('change', function(e){
		
		if(chb_clase.checked){
			desbloquearCampos(chb_clase.dataset.clase);
		}else{
			bloquearCampos(chb_clase.dataset.clase);
		}
	});
});


function identificadoresDeCampos(idClase){
	
	return  {
		grupo: 'grupo_' + idClase,
		area: 'area_' + idClase,
		profesor: 'profesor_' + idClase,
		horaInicio: 'horaInicio_' + idClase,
		horaCierre: 'horaCierre_' + idClase
	}
}

function desbloquearCampos(idClase){
	
	let idsCampos = identificadoresDeCampos(idClase);
	
	let profesor = document.getElementById(idsCampos.profesor);
	let horaInicio = document.getElementById(idsCampos.horaInicio);
	let horaCierre = document.getElementById(idsCampos.horaCierre);
	
	// desbloquear campos
	profesor.disabled = false;
	horaInicio.disabled = false;
	horaCierre.disabled = false;
	
}

function bloquearCampos(idClase){
	
	let idsCampos = identificadoresDeCampos(idClase);
	
	let profesor = document.getElementById(idsCampos.profesor);
	let horaInicio = document.getElementById(idsCampos.horaInicio);
	let horaCierre = document.getElementById(idsCampos.horaCierre);
	
	
	// Limpiar campos
	profesor.selectedIndex = -1;
	prettySelect.clean(profesor.form.id, profesor.dataset.id);
	horaInicio.value = '';
	horaCierre.value = '';
	
	// Bloquear campos
	profesor.disabled = true;
	horaInicio.disabled = true;
	horaCierre.disabled = true;
	
}

function validarCampos(){
	
	let oValidation = {
		invalidData : [],
		validData : [],
		errors : () => {
			if(this.invalidData.length === 0){
				return [];
			}else {
				return this.invalidData.map((element) => {
					return element.message;
				});
			}
		}
	}
	
	nl_chbs_clases.forEach(function(chb_clase){
		
		if(chb_clase.checked){
			let idsCampos = identificadoresDeCampos(idClase);
			
			let grupo = document.getElementById(idsCampos.grupo);
			let area = document.getElementById(idsCampos.area);
			let profesor = document.getElementById(idsCampos.profesor);
			let horaInicio = document.getElementById(idsCampos.horaInicio);
			let horaCierre = document.getElementById(idsCampos.horaCierre);
			
			oFValidacion = new f_validation({isChainable: true});
			oFValidacion.isEmpty(grupo.value, 'grupo')
						.isEmpty(area.value, 'área')
						.isEmpty(profesor.value, 'profesor')
						.isTime(horaInicio.value, 'hora de inicio')
						.isTime(horaCierre.value, 'hora de cierre')
						.isTimeEarlierThan(horaInicio, horaCierre, 'hora de inicio', 'hora de cierre');
			
			// Validar grupo
			if(grupo.value == ""){
				
				console.log("Algo salio mal! No se encontró el identificador del grupo");
			}
			
			// Validar area
			if(area.value == ""){
				console.log("Algo salio mal! No se encontró el identificador del área");
			}
			
			// Validar profesor
			if(profesor.value == ""){
				console.log("Seleccione el profesor");
			}
			
			// Validar que si un campo (hora inicio u hora cierre) esta lleno el otro también
			
			// Validar hora inicio
			if(horaInicio.value !== ""){
				var timePattern = /^([01]\d|2[0-3]):([0-5]\d)$/;
				
				return timePattern.test(horaInicio.value);
			}
			
			// Validar hora cierre
			if(horaCierre.value !== ""){
				var timePattern = /^([01]\d|2[0-3]):([0-5]\d)$/;
				
				return timePattern.test(time);
			}
			
			// Validar que la hora de inicio sea menor a la hora de cierre
			
			
		}
    });

	return oValidation;
}

function formatearDatos(form){
	
	data = {
		grupo: '',
		area: '',
		profesor: '',
		horaInicio: '',
		horaCierre: ''
	}
	
	return data;
}

function enviarDatos(){}

function mostrarRespuesta(){}
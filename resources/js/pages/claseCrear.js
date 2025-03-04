import FValidator from '../franco/libraries/FValidator';


	
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
	prettySelect.clean(profesor.dataset.id);
	horaInicio.value = '';
	horaCierre.value = '';
	
	// Bloquear campos
	profesor.disabled = true;
	horaInicio.disabled = true;
	horaCierre.disabled = true;
	
}

function guardarClases(){
	
	let oFValidator = new FValidator({isChainable: true, formData: formData});
	
	for (let i = 0; i < nl_chbs_clases.length; i++) {
	  if(nl_chbs_clases[i].checked){
			let clase = getClase(nl_chbs_clases[i].id);
			oFValidator = validarCampos(oFValidator, clase);
			
			if(oFValidator.getErrorMessages().length > 0){
				console.log(oFValidator.getErrorMessages());
				break;
			}
		}
	}
	
	console.log("Todo OK");
}

function enviarDatos(){}

function mostrarMensaje(){}

function validarCampos(oFValidator, clase){
			
	oFValidator.isNotEmpty('grupo').isNotEmpty('area').isNotEmpty('profesor').isValuePresentIf('hora_de_inicio', 'hora_de_cierre ')
	if(clase.hora_de_inicio){oFValidator.isTime('hora_de_inicio')}
	if(clase.hora_de_cierre){oFValidator.isTime('hora_de_cierre')}
	if(clase.hora_de_inicio && clase.hora_de_cierre){oFValidator.isTimeEarlierThan('hora_de_inicio', 'hora_de_cierre')}

	return oFValidator;
}

function getClase(idArea){
	
	let idsCampos = identificadoresDeCampos(idArea);
	let clase = {
		grupo: document.getElementById(idsCampos.grupo),
		area: document.getElementById(idsCampos.area),
		profesor: document.getElementById(idsCampos.profesor),
		hora_de_inicio: document.getElementById(idsCampos.horaInicio),
		hora_de_cierre: document.getElementById(idsCampos.horaCierre)
	}
	
	return clase;
}

function identificadoresDeCampos(idArea){
	
	return  {
		grupo: 'grupo_' + idArea,
		area: 'area_' + idArea,
		profesor: 'profesor_' + idArea,
		horaInicio: 'horaInicio_' + idArea,
		horaCierre: 'horaCierre_' + idArea
	}
}
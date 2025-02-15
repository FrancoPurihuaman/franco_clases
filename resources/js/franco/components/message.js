/**
 * Libreria para generar mensajes al usuario
 * Author: Franco Purihuaman
 * 
 */

 const f_message = {};

/**
 * Función para generar un mensaje
 *
 * @param { 
 *        	containerId => String - Id del contenedor donde se agregará el mensaje (default body),
 *          type => String - Especifica el tipo de mensaje (success, danger, warning, info, etc),
 *          message => String - Mensje a mostrar,
 *          details => array - Detalles a mostrar como item de lista,
 *          autoremove => boolean - Especifica si el mensaje debe eliminarse automaticamente
 *        }
 */
f_message.generate = ({
    containerId = "",
    type      = "info",
    subject   = "",
    details   = [],
    autoremove = true}) =>
{
    const message = document.createElement("div");
    let mainContainer = (containerId != "") ? document.getElementById(containerId) : null;
    if (!mainContainer) {[mainContainer] = document.getElementsByTagName("body");}

    let messageContainer = mainContainer.querySelector("div.f_message-container");
	if (!messageContainer) {
        messageContainer = document.createElement("div");
        messageContainer.setAttribute("class", "f_message-container");
        mainContainer.insertAdjacentElement("afterbegin", messageContainer);
    }
	
	// Agregando clase al mensaje
    message.setAttribute("class", `f_message ${type}`);

	// Agregando texto al mensaje
	message.innerHTML = subject;

    // Agregando item de lista al detalle de mensaje
    if(details){
        let ul = document.createElement('ul');

        details.forEach(element => {
	        let li = document.createElement('li');
	        li.innerHTML = element;
	        ul.appendChild(li);
        });

        message.appendChild(ul);
    }

	// Agregando boton close al mensaje
    let buttonClose = document.createElement('button');
    buttonClose.setAttribute('class', 'f_message__close');
    buttonClose.innerHTML = "&#x2715";
    buttonClose.addEventListener('click', function(){
        messageContainer.removeChild(message);
    });
	message.appendChild(buttonClose);

	// Eliminar mensaje despues de "n" segundos
    if(autoremove === true){
        setTimeout(function(){
        	if(messageContainer.contains(message)){messageContainer.removeChild(message)};
        },5000);
    }

	// Agregar mensaje al contenedor de mensajes
    messageContainer.appendChild(message);
}



/**
 * Función para convertir html en mensaje
 *
 * @param { 
 *			containerId => String - Id del contenedor donde se agregará el mensaje (default body),
 *			type => String - Especifica el tipo de mensaje (success, danger, warning, info, etc),
 *        	messageId => String - Id del mensaje,
 *          autoremove => boolean - Especifica si el mensaje debe eliminarse automaticamente
 *        }
 */
f_message.convert = ({
	containerId = "",
	type		= "",
    messageId 	= "",
    autoremove 	= true}) =>
{
	let messageOld = (messageId != "") ? document.getElementById(messageId) : null;
	let messageNew = null;
	
	if(messageOld){
		messageNew = messageOld.cloneNode(true);
		messageOld.parentNode.removeChild(messageOld);
		
		let mainContainer = (containerId != "") ? document.getElementById(containerId) : null;
	    if (!mainContainer) {[mainContainer] = document.getElementsByTagName("body");}
	
	    let messageContainer = mainContainer.querySelector("div.f_message-container");
		if (!messageContainer) {
	        messageContainer = document.createElement("div");
	        messageContainer.setAttribute("class", "f_message-container");
	        mainContainer.insertAdjacentElement("afterbegin", messageContainer);
	    }

		// Agregando clase al mensaje
		if(type != ""){
			messageNew.setAttribute("class", `f_message ${type}`);
		}

		// Agregando boton close al mensaje
		let buttonClose = messageNew.querySelector("f_message__close");
		if(!buttonClose){
			buttonClose = document.createElement('button');
			buttonClose.setAttribute('class', 'f_message__close');
	    	buttonClose.innerHTML = "&#x2715";
			messageNew.appendChild(buttonClose);
		}
	    buttonClose.addEventListener('click', function(){
	        messageContainer.removeChild(messageNew);
	    });
		
		// Eliminar mensaje despues de "n" segundos
	    if(autoremove === true){
	        setTimeout(function(){
				if(messageContainer.contains(messageNew)){messageContainer.removeChild(messageNew);}
			},8000);
	    }

		// Agregar mensaje al contenedor de mensajes
		messageContainer.appendChild(messageNew);
		
	}else{
		console.error("Mensaje no encontrado: " + messageId);
	}
    
}

export default f_message;
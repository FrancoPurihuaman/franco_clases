/**
 * Libreria para validar campos de formulario
 * Author: Franco Purihuaman
 * 
 */


class FValidator {
	
	/**
	 * Map que almacena los errores de validación para cada campo de formulario
	 * La clave del `Map` es el nombre del campo (`field`), y el valor es un array que contiene
     * los mensajes de error asociados con ese campo.
	 * 
	 * 	Ejemplo:
   	 *  validationErrors = new Map([
   	 *    ["name", ["El nombre no puede estar vacío", "El nombre debe ser alfabético"]],
   	 *    ["email", ["El campo debe ser un email válido"]]
   	 *  ]);
	 * 
	*/
	validationErrors = new Map();
	
	
	/**
	 * Objeto de configuración
	 */
	config = {
		isChainable: false,			// Indica si se permitirá las anidaciones en los métodos de validación
		formData = null,			// Map que almacena los campos de formulario y sus respectivos valores
		attributes = null			// Map que almacena los alias de Attributos de formulario
	}
	
	
	/**
	 * Constructor recibe un objeto de configuración
	 */
	constructor(_config = {}){
		this.config = {...this.config, ..._config}
	}
	
	
	/**
	 * Función valida que un campo tenga un valor establecido.
	 * Si es `undefined` se lanzara un error.
	 * Además si en configuración se agregaron los alias de los atributos se hará el cambio por los nuevos valores 
	 *
	 * @param  {string} field - Nombre del campo a verificar
	 * @param  {any} value - Valor del campo a verificar
	 *
	 * @return {array<string,any>} - Valores de field y value
	 */
	validateFieldAndValue = (field = "", value) => {
		// Si las funciones son encadenables el nombre del campo es requerido
		if(this.config.isChainable && field === "") {throw new Error("Nombre de campo no definido");}
		// Si en configuración se asignó los pares clave-valor del formulario, se usará el valor correspondiente para 'field'
		if(this.config.formData !== null) { value = this.config.formData.get(field); }
		if(typeof value === 'undefined') {throw new Error("Valor de campo no definido");}
		// Si en configuración se asignó los atributos del formulario, entonces el nombre del campo será cambiado este valor (alias)
		if(this.config.attributes !== null && this.config.attributes.has(field)) {field = this.config.attributes.get(field); }
			
		return [field, value];
	}
	
	
	/**
	 * Función valida que dos campos que serán comparados tengan un valor establecido.
	 * Si alguno tiene un valor `undefined` se lanzara un error.
	 * Además si en configuración se agregaron los alias de los atributos se hará el cambio por los nuevos valores 
	 *
	 * @param  {string} field - Nombre del campo a verificar
	 * @param  {any} value - Valor del campo a verificar
	 * @param  {string} otherField - Nombre del campo con el que será comparado
	 * @param  {any} valueToCompare - Valor con el que será comparado
	 *
	 * @return {array<string,any,string,any>} - Valores de field, value, otherField y valueToCompare
	 */
	validateFieldAndValueToCompare = (field = "", value, otherField = "", valueToCompare) => {
		// Se valida los campos 'field' y 'value'
		[field, value] = this.validateFieldAndValue(field, value);
		// Si se asignó el nombre del campo a comparar (otherField) y en configuración
		// se asignó los pares clave-valor del formulario, se usará el valor correspondiete para 'otherField'
		if(otherField !== "" && this.config.formData !== null) { valueToCompare = this.config.formData.get(otherField); }
		if(typeof valueToCompare === 'undefined') {throw new Error("Valor de campo para comparar no definido");}
		// Si en configuración se asignó los atributos del formulario, entonces el nombre del campo será cambiado este valor (alias)
		if(this.config.attributes !== null && this.config.attributes.has(otherField)) {otherField = this.config.attributes.get(otherField); }
		
		return [field, value, otherField, valueToCompare];
	}
	
	
	/**
	 * Función realiza acciones despues de validar el campo, en funcion a si hubo algún error en de validación
	 *
	 * @param  {string} field - Nombre del campo verificado
	 * @param  {boolean} passedRule - Resultado de verificación
	 * @param  {string} message - Mensaje de error en caso de que la validación falle
	 *
	 * @return {boolean | Object} - boolean resultado de verificacion | (this) si las funciones son encadenables
	 */
	processValidation = (field, passedRule, message) => {
		
		let response = passedRule;
		
		if(this.config.isChainable) {
			
			if(!passedRule){ this.addValidationError(field, message);}
			response = this;
		}
		
		return response;
	}
	
	
	/**
	 * Función para agregar un nuevo error de validacion
	 *
	 * @param  {string}	field - Nombre del campo verificado
	 * @param  {string}	message - Mensaje de error en caso de que la validación falle
	 */
	addValidationError = (field, message) => {
		
		// Si el campo ya tiene errores, agregamos el nuevo mensaje
	    if (this.validationErrors.has(field)) {
			const messages = this.validationErrors.get(field);
	      	messages.push(message);
	    } else {
			// Si el campo no existe en el Map, lo creamos
			this.validationErrors.set(field, [message]);
	    }
		
	}
	
	
	/**
	 * Función para obtener un array con todos los mensajes de error de validación
	 * (cuando las funciones son encadenables)
	 *
	 * @return {Array<string>} Array con mensajes de errores encontrados al validar
	 */
	getErrorMessages = () => {
		let errors = [];
		
		this.validationErrors.forEach((messages) => {
			errors = errors.concat(messages);
		});
		
		return errors;
	}
	
	
	/**
	 * Función para enviar respuesta de validación
	 * (cuando las funciones son encadenables)
	 *
	 * @return {Object} Objeto de validación
	 */
	validate = () => {
		
		if (this.invalidData.size === 0) {
		    return { success: true, message: "Todas las validaciones pasaron con éxito." };
		} else {
			return { success: false, errors: Array.from(this.invalidData.entries()) };
		}
	}
	
	
	/**
	 * Función verifica si el valor recibido no está vacio
	 *
	 * @param  {string} field - Nombre del campo a verificar
	 * @param  {string} message - Mensaje de error en caso de que la validación falle
	 * @param  {string|array} value - Valor a verificar
	 *
	 * @return {boolean | Object} - boolean resultado de verificacion | (this) si las funciones son encadenables
	 */
	isNotEmpty = (field = "", message = "", value) => {
		
		let is_not_empty = false;
		[field, value] = this.validateFieldAndValue(field, value);
		
		if (typeof value === 'string' && value !== "") { is_not_empty = true;}
		else if (Array.isArray(value) && value.length !== 0) { is_not_empty = true;}
		
		message = (message !== '') ? message : `El campo ${field} no debe estar vacío`;
		return this.processValidation(field, is_not_empty, message);
	}
	
	
	/**
	 * Función verifica si los valores recibidos son iguales
	 *
	 * @param  {string} field - Nombre del campo a verificar
	 * @param  {string} otherField - Nombre del campo con el que será comparado
	 * @param  {string} message - Mensaje de error en caso de que la validación falle
	 * @param  {any} value - Valor a verificar
	 * @param  {any} valueToCompare	- Valor con el que será comparado
	 *
	 * @return {boolean | Object} - boolean resultado de verificacion | (this) si las funciones son encadenables 
	 */
	equals = (field = "", otherField = "", message = "", value, valueToCompare) => {
		
		let equals = false;
		[field, value, otherField, valueToCompare] = this.validateFieldAndValueToCompare(field, value, otherField, valueToCompare);
		
		if (value == valueToCompare) {equals = true;}
		
		message = (message !== '') ? message : `El campo ${field} debe ser igual que ${(otherField !== '') ? "el campo " + otherField  : valueToCompare}`;
		return this.processValidation(field, equals, message);
	}
	
	
	/**
	 * Función verifica si los valores recibidos son exactamente iguales en tipo y valor
	 *
	 * @param  {string} field - Nombre del campo a verificar
	 * @param  {string} otherField - Nombre del campo con el que será comparado
	 * @param  {string} message - Mensaje de error en caso de que la validación falle
	 * @param  {any} value - Valor a verificar
	 * @param  {any} valueToCompare	- Valor con el que será comparado
	 *
	 * @return {boolean | Object} - boolean resultado de verificacion | (this) si las funciones son encadenables 
	 */
	exactlyEquals = (field = "", otherField = "", message = "", value, valueToCompare) => {
		
		let equals = false;
		[field, value, otherField, valueToCompare] = this.validateFieldAndValueToCompare(field, value, otherField, valueToCompare);
		
		if (value === valueToCompare) { equals = true; }
		
		message = (message !== '') ? message : `El campo ${field} debe ser exactamente igual que ${(otherField !== '') ? "el campo " + otherField  : valueToCompare}`;
		return this.processValidation(field, equals, message);
	}
	
	
	/**
	 * Función verifica si el valor recibido es un email
	 *
	 * @param  {string} field - Nombre del campo a verificar
	 * @param  {string} message - Mensaje de error en caso de que la validación falle
	 * @param  {string} value - Valor a verificar
	 *
	 * @return {boolean | Object} - boolean resultado de verificacion | (this) si las funciones son encadenables 
	 */
	isEmail = (field = "", message = "", value) => {
		
		let is_email = false;
		[field, value] = this.validateFieldAndValue(field, value);
		
		if (/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) { is_email = true; }
		
		message = (message !== '') ? message : `El campo ${field} debe ser un email válido`;
		return this.processValidation(field, is_email, message);
	}
	
	
	/**
	 * Función verifica si el valor recibido tiene un longitud minima
	 *
	 * @param  {string} field - Nombre del campo a verificar
	 * @param  {integer} minLength - Longitud mínima
	 * @param  {string} message - Mensaje de error en caso de que la validación falle
	 * @param  {string | array} value - Valor a verificar
	 *
	 * @return {boolean | Object} - boolean resultado de verificacion | (this) si las funciones son encadenables 
	 */
	minLength = (field = "", minLength = 0, message = "", value) => {
	    
		let is_valid = value.length >= minLength;
		[field, value] = this.validateFieldAndValue(field, value);
		
	    message = (message !== '') 
					? message 
					: (Array.isArray(value)) 
						? `El campo ${field} debe tener al menos ${minLength} elementos.`
						: `El campo ${field} debe tener al menos ${minLength} caracteres.`;
						
	    return this.processValidation(field, is_valid, message);
	}
	
	
	/**
	 * Función verifica si el valor recibido tiene un longitud máxima
	 *
	 * @param  {string} field - Nombre del campo a verificar
	 * @param  {integer} maxLength - Longitud máxima
	 * @param  {string} message - Mensaje de error en caso de que la validación falle
	 * @param  {string | array} value - Valor a verificar
	 *
	 * @return {boolean | Object} - boolean resultado de verificacion | (this) si las funciones son encadenables 
	 */
	maxLength = (field = "", maxLength = 0, message = "", value) => {
	    
		let is_valid = value.length <= maxLength;
		[field, value] = this.validateFieldAndValue(field, value);
		
	    message = (message !== '') 
					? message 
					: (Array.isArray(value)) 
						? `El campo ${field} debe tener máximo ${maxLength} elementos.`
						: `El campo ${field} debe tener máximo ${maxLength} caracteres.`;
						
	    return this.processValidation(field, is_valid, message);
	}
		
	
	/**
	 * Función verifica si el valor recibido es numérico
	 *
	 * @param  {string} field - Nombre del campo a verificar
	 * @param  {string} message - Mensaje de error en caso de que la validación falle
	 * @param  {string} value - Valor a verificar
	 *
	 * @return {boolean | Object} - boolean resultado de verificacion | (this) si las funciones son encadenables 
	 */
	isNumeric = (field = "", message = "", value) => {
		
		let is_numeric = false;
		[field, value] = this.validateFieldAndValue(field, value);
		
		if (/^-?\d+(\.\d+)?$/.test(value)) { is_numeric = true; }
		
		message = (message !== '') ? message : `El campo ${field} debe ser un número válido`;
		return this.processValidation(field, is_numeric, message);
	}
	
	
	/**
	 * Función verifica si el valor recibido es un número entero
	 *
	 * @param  {string} field - Nombre del campo a verificar
	 * @param  {string} message - Mensaje de error en caso de que la validación falle
	 * @param  {string} value - Valor a verificar
	 *
	 * @return {boolean | Object} - boolean resultado de verificacion | (this) si las funciones son encadenables 
	 */
	isInteger = (field = "", message = "", value) => {
		
		let is_integer = false;
		[field, value] = this.validateFieldAndValue(field, value);
		
		if (/^-?\d+$/.test(value)) { is_integer = true; }
		
		message = (message !== '') ? message : `El campo ${field} debe ser un número entero`;
		return this.processValidation(field, is_integer, message);
	}
	
	
	/**
	 * Función verifica si el valor recibido es un número decimal
	 *
	 * @param  {string} field - Nombre del campo a verificar
	 * @param  {string} message - Mensaje de error en caso de que la validación falle
	 * @param  {string} value - Valor a verificar
	 *
	 * @return {boolean | Object} - boolean resultado de verificacion | (this) si las funciones son encadenables 
	 */
	isDecimal = (field = "", message = "", value) => {
		
		let is_decimal = false;
		[field, value] = this.validateFieldAndValue(field, value);
		
		if (/^-?\d+\.\d+$/.test(value)) { is_decimal = true; }
		
		message = (message !== '') ? message : `El campo ${field} debe ser un número entero`;
		return this.processValidation(field, is_decimal, message);
	}
	
	
	/**
	 * Función verifica que un número sea mayor que otro
	 *
	 * @param  {string} field - Nombre del campo a verificar
	 * @param  {string} otherField - Nombre del campo con el que será comparado
	 * @param  {string} message - Mensaje de error en caso de que la validación falle
	 * @param  {number}	value - valor a verificar
	 * @param  {number}	valueToCompare - Valor con el que será comparado
	 *
	 * @return {boolean | Object} - boolean resultado de verificacion | (this) si las funciones son encadenables 
	 */
	isNumberGreaterThan = (field = "", otherField = "", message = "", value, valueToCompare) => {
		
		let is_greater = false;
		[field, value, otherField, valueToCompare] = this.validateFieldAndValueToCompare(field, value, otherField, valueToCompare);
		
		if (parseFloat(value) > parseFloat(valueToCompare)) { is_greater = true; }
		
		message = (message !== '') ? message : `El campo ${field} debe ser mayor que ${(otherField !== '') ? "el campo " + otherField  : valueToCompare}`;
		return this.processValidation(field, is_greater, message);
	}
	
	
	/**
	 * Función verifica que un número sea menor que otro
	 *
	 * @param  {string} field - Nombre del campo a verificar
	 * @param  {string} otherField - Nombre del campo con el que será comparado
	 * @param  {string} message - Mensaje de error en caso de que la validación falle
	 * @param  {number}	value - valor a verificar
	 * @param  {number}	valueToCompare - Valor con el que será comparado
	 *
	 * @return {boolean | Object} - boolean resultado de verificacion | (this) si las funciones son encadenables
	 */
	isNumberLessThan = (field = "", otherField = "", message = "", value, valueToCompare) => {
		
		let is_less = false;
		[field, value, otherField, valueToCompare] = this.validateFieldAndValueToCompare(field, value, otherField, valueToCompare);
		
		if (parseFloat(value) < parseFloat(valueToCompare)) { is_less = true; }
		
		message = (message !== '') ? message : `El campo ${field} debe ser menor que ${(otherField !== '') ? "el campo " + otherField  : valueToCompare}`;
		return this.processValidation(field, is_less, message);
	}
	
	
	/**
	 * Función verifica si el valor recibido es una hora valida en el formato especificado
	 *
	 * @param  {string} field - Nombre del campo a verificar
	 * @param  {string} format - Formato de hora
	 * @param  {string} message- Mensaje de error en caso de que la validación falle
	 * @param  {string} value - Valor a verificar
	 *
	 * @return {boolean | Object} - boolean resultado de verificacion | (this) si las funciones son encadenables 
	 */
	isTime = (field = "", format = "HH:MM", message = "", value) => {
		
		let is_time = false;
		[field, value] = this.validateFieldAndValue(field, value);
		
		if (format === "HH:MM" && /^([01]\d|2[0-3]):([0-5]\d)$/.test(value)) { is_time = true; }
		else if (format === "HH:MM:SS" && /^([01]\d|2[0-3]):([0-5]\d):(([0-5]\d))$/.test(value)) { is_time = true; }
		
		message = (message !== '') ? message : `El campo ${field} debe ser hora valida en formato ${format}`;
		return this.processValidation(field, is_time, message);
	}
	
	
	/**
	 * Función verifica que una hora sea más tarde que otra
	 *
	 * @param  {string} field - Nombre del campo a verificar
	 * @param  {string} otherField - Nombre del campo con el que será comparado
	 * @param  {string} message - Mensaje de error en caso de que la validación falle
	 * @param  {string}	value - Valor a verificar
	 * @param  {string}	valueToCompare - Valor con el que será comparado
	 *
	 * @return {boolean | Object} - boolean resultado de verificacion | (this) si las funciones son encadenables
	 */
	isTimeLaterThan = (field = "", otherField = "", message = "", value, valueToCompare) => {
		
		let is_later = false;
		[field, value, otherField, valueToCompare] = this.validateFieldAndValueToCompare(field, value, otherField, valueToCompare);
		
		if (value > valueToCompare) { is_later = true; }
		
		message = (message !== '') ? message : `El campo ${field} debe ser más tarde que ${(otherField !== '') ? "el campo " + otherField  : valueToCompare}`;
		return this.processValidation(field, is_later, message);
	}
	
	
	/**
	 * Función verifica que una hora sea más temprano que otra
	 *
	 * @param  {string} field - Nombre del campo a verificar
	 * @param  {string} otherField - Nombre del campo con el que será comparado
	 * @param  {string} message - Mensaje de error en caso de que la validación falle
	 * @param  {string}	value - Valor a verificar
	 * @param  {string}	valueToCompare - Valor con el que será comparado
	 *
	 * @return {boolean | Object} - boolean resultado de verificacion | (this) si las funciones son encadenables 
	 */
	isTimeEarlierThan = (field = "", otherField = "", message = "", value, valueToCompare) => {
		
		let is_earlier = false;
		[field, value, otherField, valueToCompare] = this.validateFieldAndValueToCompare(field, value, otherField, valueToCompare);
		
		if (value > valueToCompare) { is_earlier = true; }
		
		message = (message !== '') ? message : `El campo ${field} debe ser más tarde que ${(otherField !== '') ? "el campo " + otherField  : valueToCompare}`;
		return this.processValidation(field, is_earlier, message);
	}
	
	
	/**
	 * Función verifica que un valor esté presente solo si existe un segundo valor especificado
	 *
	 * @param  {string} field - Nombre del campo a verificar
	 * @param  {string} otherField - Nombre del campo con el que será comparado
	 * @param  {string} message - Mensaje de error en caso de que la validación falle
	 * @param  {any} value - Valor del campo a verificar
	 * @param  {any} valueToCompare - Valor que debe existir para que se requiera el valor del campo a verificar
	 *
	 * @return {boolean | Object} - boolean resultado de verificacion | (this) si las funciones son encadenables 
	 */
	isValuePresentIf = (field = "", otherField = "", message = "", value, valueToCompare) => {
	    let is_value_present_if = false;
		[field, value, otherField, conditionValue] = this.validateFieldAndValue(field, value, otherField, conditionValue);
		
		let value_isValid = value !== null && value !== undefined && value !== "" && !(Array.isArray(value) && value.length === 0);
		
		let valueToCompare_isValid = valueToCompare !== null && valueToCompare !== undefined && valueToCompare !== "" 
						        && !(Array.isArray(valueToCompare) && valueToCompare.length === 0);

	
	    if (valueToCompare_isValid && value_isValid) { is_value_present_if = true; }
		else if (!valueToCompare_isValid && !value_isValid) {is_value_present_if = true; }
	
	    message = (message !== '') ? message : `El campo ${field} debe tener un valor.`;
	    return this.processValidation(field, is_value_present_if, message);
	}
		
}

export default FValidator;
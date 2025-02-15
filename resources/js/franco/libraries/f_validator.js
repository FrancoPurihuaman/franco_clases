/**
 * Libreria para validar campos de formulario
 * Author: Franco Purihuaman
 * 
 */


class f_validation {
	
	/**
	 * Un Map que almacena los errores de validación para cada campo de formulario
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
		isChainable: false	// Indica si se permitirá las anidaciones en los métodos de validación
	}
	
	
	constructor(_config = {}){
		this.config = {...this.config, ..._config} 
	}
	
	
	/**
	 * Función realiza acciones deacuardo a si se aprobó la regla de validación
	 *
	 * @param  {string} 	- nombre del campo verificado
	 * @param  {boolean} 	- resultado de verificación
	 * @param  {string} 	- mensaje a mostrar en caso de error
	 *
	 * @return {boolean | Object} - boolean resultado de verificacion | (this) si las funciones son encadenables
	 */
	processValidation = (field, passedRule, message) => {
		
		let response = passedRule;
		
		if(this.config.isChainable) {
			
			if(!passedRule){ this.addValidationError(field, message); }
			response = this;
		}
		
		return response;
	}
	
	
	/**
	 * Función para agregar al contenedor de errores un nuevo error de validacion
	 *
	 * @param  {string}	- nombre del campo validado
	 * @param  {string}	- mensaje por no cumplir la regla de validación
	 */
	addValidationError = (_field, _message) => {
		
		// Si el campo ya tiene errores, agregamos el nuevo mensaje
	    if (this.validationErrors.has(_field)) {
			const messages = this.validationErrors.get(_field);
	      	messages.push(_message);
	    } else {
			// Si el campo no existe en el Map, lo creamos
			this.validationErrors.set(_field, [_message]);
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
	 * Función verifica si el valor recibido esta vacio
	 *
	 * @param  {string|array} - valor a verificar
	 * @param  {string} - nombre del campo a verificar
	 * @param  {string} - mensaje a mostrar en caso de error
	 *
	 * @return {boolean | Object} - boolean resultado de verificacion | (this) si las funciones son encadenables
	 */
	isEmpty = (value, field = "", message = "") => {
		
		let is_empty = true;
		
		if (typeof value === 'string' && value !== "") { is_empty = false; } 
		else if (Array.isArray(value) && value.length !== 0) { is_empty = false;}
		
		message = (message !== '') ? message : `El campo ${field} no debe estar vacío`;
		return this.processValidation(field, is_empty, message);
	}
	
	
	/**
	 * Función verifica si los valores recibidos son iguales
	 *
	 * @param  {*}		- valor a verificar
	 * @param  {*}		- valor_2 a comparar con valor
	 * @param  {string} - nombre del campo a verificar
	 * @param  {string} - nombre del campo valor_2
	 * @param  {string} - mensaje a mostrar en caso de error
	 *
	 * @return {boolean | Object} - boolean resultado de verificacion | (this) si las funciones son encadenables 
	 */
	equals = (value, value_2, field = "", field_2 = "", message = "") => {
		
		let equals = false;
		
		if (value == value_2) {equals = true;}
		
		message = (message !== '') ? message : `El campo ${field} debe ser igual que ${(field_2 !== '') ? "el campo " + field_2  : value_2}`;
		return this.processValidation(field, equals, message);
	}
	
	
	/**
	 * Función verifica si los valores recibidos son iguales
	 *
	 * @param  {*}		- valor a verificar
	 * @param  {*}		- valor_2 a comparar con valor
	 * @param  {string} - nombre del campo a verificar
	 * @param  {string} - nombre del campo valor_2
	 * @param  {string} - mensaje a mostrar en caso de error
	 *
	 * @return {boolean | Object} - boolean resultado de verificacion | (this) si las funciones son encadenables 
	 */
	exactlyEquals = (value, value_2, field = "", field_2 = "", message = "") => {
		
		let equals = false;
		
		if (value === value_2) { equals = true; }
		
		message = (message !== '') ? message : `El campo ${field} debe ser exactamente igual que ${(field_2 !== '') ? "el campo " + field_2  : value_2}`;
		return this.processValidation(field, equals, message);
	}
	
	
	/**
	 * Función verifica si el valor recibido es un email
	 *
	 * @param  {string} - valor a verificar
	 * @param  {string} - nombre del campo a verificar
	 * @param  {string} - mensaje a mostrar en caso de error
	 *
	 * @return {boolean | Object} - boolean resultado de verificacion | (this) si las funciones son encadenables 
	 */
	isEmail = (value, field = "", message = "") => {
		
		let is_email = false;
		
		if (/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) { is_email = true; }
		
		message = (message !== '') ? message : `El campo ${field} debe ser un email válido`;
		return this.processValidation(field, is_email, message);
	}
	
	
	/**
	 * Función verifica si el valor recibido tiene un longitud minima
	 *
	 * @param  {string | array} - valor a verificar
	 * @param  {integer} 		- valor minimo
	 * @param  {string} 		- nombre del campo a verificar
	 * @param  {string} 		- mensaje a mostrar en caso de error
	 *
	 * @return {boolean | Object} - boolean resultado de verificacion | (this) si las funciones son encadenables 
	 */
	minLength = (value, minLength = 0, field = "", message = "") => {
	    
		let is_valid = value.length >= length;
		
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
	 * @param  {string | array} - valor a verificar
	 * @param  {integer} 		- valor máximo
	 * @param  {string} 		- nombre del campo a verificar
	 * @param  {string} 		- mensaje a mostrar en caso de error
	 *
	 * @return {boolean | Object} - boolean resultado de verificacion | (this) si las funciones son encadenables 
	 */
	maxLength = (value, maxLength = 0, field = "", message = "") => {
	    
		let is_valid = value.length <= length;
		
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
	 * @param  {string} - valor a verificar
	 * @param  {string} - nombre del campo a verificar
	 * @param  {string} - mensaje a mostrar en caso de error
	 *
	 * @return {boolean | Object} - boolean resultado de verificacion | (this) si las funciones son encadenables 
	 */
	isNumeric = (value, field = "", message = "") => {
		
		let is_numeric = false;
		
		if (/^-?\d+(\.\d+)?$/.test(value)) { is_numeric = true; }
		
		message = (message !== '') ? message : `El campo ${field} debe ser un número válido`;
		return this.processValidation(field, is_numeric, message);
	}
	
	
	/**
	 * Función verifica si el valor recibido es un número entero
	 *
	 * @param  {string} - valor a verificar
	 * @param  {string} - nombre del campo a verificar
	 * @param  {string} - mensaje a mostrar en caso de error
	 *
	 * @return {boolean | Object} - boolean resultado de verificacion | (this) si las funciones son encadenables 
	 */
	isInteger = (value, field = "", message = "") => {
		
		let is_integer = false;
		
		if (/^-?\d+$/.test(value)) { is_integer = true; }
		
		message = (message !== '') ? message : `El campo ${field} debe ser un número entero`;
		return this.processValidation(field, is_integer, message);
	}
	
	
	/**
	 * Función verifica si el valor recibido es un número decimal
	 *
	 * @param  {string} - valor a verificar
	 * @param  {string} - nombre del campo a verificar
	 * @param  {string} - mensaje a mostrar en caso de error
	 *
	 * @return {boolean | Object} - boolean resultado de verificacion | (this) si las funciones son encadenables 
	 */
	isDecimal = (value, field = "", message = "") => {
		
		let is_decimal = false;
		
		if (/^-?\d+\.\d+$/.test(value)) { is_decimal = true; }
		
		message = (message !== '') ? message : `El campo ${field} debe ser un número entero`;
		return this.processValidation(field, is_decimal, message);
	}
	
	
	/**
	 * Función verifica que el primer valor sea mayor que el segundo valor
	 *
	 * @param  {number}	- valor a verificar
	 * @param  {number}	- valor_2 a comparar con valor
	 * @param  {string} - nombre del campo a verificar
	 * @param  {string} - nombre del campo valor_2
	 * @param  {string} - mensaje a mostrar en caso de error
	 *
	 * @return {boolean | Object} - boolean resultado de verificacion | (this) si las funciones son encadenables 
	 */
	isNumberGreaterThan = (value, value_2, field = "", field_2 = "", message = "") => {
		
		let is_greater = false;
		
		if (parseFloat(value) > parseFloat(value_2)) { is_greater = true; }
		
		message = (message !== '') ? message : `El campo ${field} debe ser mayor que ${(field_2 !== '') ? "el campo " + field_2  : value_2}`;
		return this.processValidation(field, is_greater, message);
	}
	
	
	/**
	 * Función verifica que el primer valor sea menor que el segundo valor
	 *
	 * @param  {number}	- valor a verificar
	 * @param  {number}	- valor_2 a comparar con valor
	 * @param  {string} - nombre del campo a verificar
	 * @param  {string} - nombre del campo valor_2
	 * @param  {string} - mensaje a mostrar en caso de error
	 *
	 * @return {boolean | Object} - boolean resultado de verificacion | (this) si las funciones son encadenables
	 */
	isNumberLessThan = (value, value_2, field = "", field_2 = "", message = "") => {
		
		let is_less = false;
		
		if (parseFloat(value) < parseFloat(value_2)) { is_less = true; }
		
		message = (message !== '') ? message : `El campo ${field} debe ser menor que ${(field_2 !== '') ? "el campo " + field_2  : value_2}`;
		return this.processValidation(field, is_less, message);
	}
	
	
	/**
	 * Función verifica si el valor recibido es tiempo
	 *
	 * @param  {string} - valor a verificar
	 * @param  {string} - formato de tiempo del campo a verificar
	 * @param  {string} - nombre del campo a verificar
	 * @param  {string} - mensaje a mostrar en caso de error
	 *
	 * @return {boolean | Object} - boolean resultado de verificacion | (this) si las funciones son encadenables 
	 */
	isTime = (value, format = "HH:MM", field = "", message = "") => {
		
		let is_time = false;
		
		if (format === "HH:MM" && /^([01]\d|2[0-3]):([0-5]\d)$/.test(value)) { is_time = true; }
		else if (format === "HH:MM:SS" && /^([01]\d|2[0-3]):([0-5]\d):(([0-5]\d))$/.test(value)) { is_time = true; }
		
		message = (message !== '') ? message : `El campo ${field} debe ser hora valida en formato ${format}`;
		return this.processValidation(field, is_time, message);
	}
	
	
	/**
	 * Función verifica que la primera hora sea más tarde que la segunda hora
	 *
	 * @param  {string}	- valor a verificar
	 * @param  {string}	- valor_2 a comparar con valor
	 * @param  {string} - nombre del campo a verificar
	 * @param  {string} - nombre del campo valor_2
	 * @param  {string} - mensaje a mostrar en caso de error
	 *
	 * @return {boolean | Object} - boolean resultado de verificacion | (this) si las funciones son encadenables
	 */
	isTimeLaterThan = (value, value_2, field = "", field_2 = "", message = "") => {
		
		let is_later = false;
		
		if (value > value_2) { is_later = true; }
		
		message = (message !== '') ? message : `El campo ${field} debe ser más tarde que ${(field_2 !== '') ? "el campo " + field_2  : value_2}`;
		return this.processValidation(field, is_later, message);
	}
	
	
	/**
	 * Función verifica que la primera hora sea más temprano que la segunda hora
	 *
	 * @param  {string}	- valor a verificar
	 * @param  {string}	- valor_2 a comparar con valor
	 * @param  {string} - nombre del campo a verificar
	 * @param  {string} - nombre del campo valor_2
	 * @param  {string} - mensaje a mostrar en caso de error
	 *
	 * @return {boolean | Object} - boolean resultado de verificacion | (this) si las funciones son encadenables 
	 */
	isTimeEarlierThan = (value, value_2, field = "", field_2 = "", message = "") => {
		
		let is_earlier = false;
		
		if (value > value_2) { is_earlier = true; }
		
		message = (message !== '') ? message : `El campo ${field} debe ser más tarde que ${(field_2 !== '') ? "el campo " + field_2  : value_2}`;
		return this.processValidation(field, is_earlier, message);
	}
	
}

export default f_validation;
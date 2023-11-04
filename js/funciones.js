-// JavaScript Document
// esta pagina es para crear funciones nuevas
$(document).ready(function() {

});

idiomaDT = {
			  	"processing":     "Procesando...",
				"lengthMenu":     "Mostrar  _MENU_ registros",
				"zeroRecords":    "No se encontraron resultados",
				"emptyTable":     "Ningún dato disponible en esta tabla",
				"info":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
				"infoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
				"infoFiltered":   "(filtrado de un total de _MAX_ registros)",
				"infoPostFix":    "",
				"search":         "Buscar:",
				"loadingRecords": "Cargando...",	
				"oPaginate": {
					"sFirst":    "Primero",
					"sLast":     "Último",
					"sNext":     "Siguiente",
					"sPrevious": "Anterior"
				},
				"oAria": {
					"sortAscending":  ": Activar para ordenar la columna de manera ascendente",
					"sortDescending": ": Activar para ordenar la columna de manera descendente"
				}
			} // language

function fecha(dias){
	
	var hoy = new Date();
    if (dias != undefined){
	hoy.setDate(hoy.getDate() + dias);
	}
	var mes = hoy.getMonth()+1;
	var dia = hoy.getDate();
	
	var fecha =  hoy.getFullYear() + '/' +
				(mes<10 ? '0' : '') + mes + '/' +
				(dia<10 ? '0' : '') + dia;				
	return fecha;
	}

	function radioOn(seleccion){
		$(seleccion).parent().removeClass("radio-off"); 
		$(seleccion).parent().addClass("radio-on");
		$(seleccion).parent().siblings().removeClass("radio-on"); 
		$(seleccion).parent().siblings().addClass("radio-off"); 
	}

/* 	esultado = (condicion)?valor1:valor2; */
/* 	inputVal.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi,'') */
	function validar(campo,numeros,texto,enteros,minimo,maximo,numeroMaximo,especial){

		var x = $.trim( $(campo).val());
		var y = ""
/* 		validar exprecion regular  */
/* 		http://www.contadordecaracteres.info/prueba-expresiones-regulares.html */
		var expReg = /^[a-zA-Z\sñÑáéíóúÁÉÍÓÚ]+$/;
		var correo = /^[a-zA-Z0-9_\-\.~]{2,}@[a-zA-Z0-9_\-\.~]{2,}\.[a-zA-Z]{2,10}$/;
		var contraseña = /^[a-zA-Z0-9!@#\$%&_\-\.,]{1,20}$/;
		var fecha =/^(19|20)\d\d[- /.](0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])$/;
		var hora =/^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/;
		
		if(x.indexOf(",") > -1 && numeros==1){/* comprueba si el campo tienes coma en vez de punto*/
		$(campo).val( x.replace(",", ".")); 
		x =  $(campo).val();	
		}
		if (isNaN(x) && numeros==1){		/*comprueba si es un numero*/
			y = "Debe ingresar un dato numerico";
			
		}else if ( x.length < 1 && minimo > 0){
			y = "Este campo es obligatorio";
			
		}else if (!expReg.test(x) && texto==1 && x.length > 0) { /*comprueba si es letras solamente*/
			y = "No debe ingresar numeros o caracteres especiales";
			
		}else if (x.indexOf(".") > -1 && enteros==0 && numeros==1) {
			y = "Este campo no acepta decimales";
				
		}else if (!correo.test(x) && especial==1 && x.length > 0) {
			y = "El correo debe estar en este formato ejemplo@pagina.com";
			
		}else if (!contraseña.test(x) && especial==2 && x.length > 0) {
			y = " Solo se reciben letras en mayuscula y minuscula, numeros y estos caracteres ! @ # $ % & . - _ ";
			
		}else if (!fecha.test(x) && especial==3 && x.length > 0) {
			y = "La fecha debe estar en este formato AAAA/MM/DD";

		}else if (!hora.test(x) && especial==4 && x.length > 0) {
			y = "La hora debe estar en este formato HH:MM";
									
		}else if (x.length > maximo) {
			y = "Maximo "+ maximo +" caracteres";
			
		}else if ( x.length < minimo){
			y = ( x.length < 1)?"Este campo no puede quedar vacio":"Minimo "+ minimo +" digitos";
			
		}else if ( x > numeroMaximo && numeroMaximo !=0){
			y = "El valor no puede ser mayor a "+ numeroMaximo;
			
		}else {
			y = "Correcto";
			}
		
/* 		añade un texto bajo el camopo validado		  */
		$(campo).next().next().html(y);
		  
/* 		ajustas las clases del html  */
		if(y == "Correcto"){			
			$(campo).parent().removeClass("has-error"); /* has-error          has-warning              has-success */
			$(campo).parent().addClass("has-success");
			$(campo).next().removeClass("glyphicon-remove"); /* glyphicon-remove   glyphicon-warning-sign   glyphicon-ok */
			$(campo).next().addClass("glyphicon-ok");
			return true;			 
		} else {
			$(campo).parent().removeClass("has-success"); 
			$(campo).parent().addClass("has-error");
			$(campo).next().removeClass("glyphicon-ok"); 
			$(campo).next().addClass("glyphicon-remove");
			return false;					
		}	
	}

	function validarId(valor1,valor2){
		
		var y = $.ajax({
		type: "GET",
		url: "controlador/validarId.php",
		data: {numero:valor1,tabla:valor2},
		async: false
		}).responseText.replace(/[^\d]/g, '')
		//console.log("existe ="+ y)		
		return y		
	}

	function validarDoc(valor1){
		
		var y = $.ajax({
		type: "GET",
		url: "controlador/validarId.php",
		data: {numero:valor1,tabla:'usuario',col:'usuNumeroDoc'},
		async: false
		}).responseText.replace(/[^\d]/g, '')	
		return y
		
	}
	
jQuery.fn.extend({
/**
* TRAE LAS VARIBLES DE GET
* Returns get parameters.
*
* If the desired param does not exist, null will be returned
*
* To get the document params:
* @example value = $(document).getUrlParam("paramName");
* 
* To get the params of a html-attribut (uses src attribute)
* @example value = $('#imgLink').getUrlParam("paramName");
*/ 
 getUrlParam: function(strParamName){
	  strParamName = escape(unescape(strParamName));
	  
	  var returnVal = new Array();
	  var qString = null;	  
	  if ($(this).attr("nodeName")=="#document") {
	  	//document-handler		
		if (window.location.search.search(strParamName) > -1 ){			
			qString = window.location.search.substr(1,window.location.search.length).split("&");
		}
	  } else if ($(this).attr("src")!="undefined") {	  	
	  	var strHref = $(this).attr("src")
	  	if ( strHref.indexOf("?") > -1 ){
	    	var strQueryString = strHref.substr(strHref.indexOf("?")+1);
	  		qString = strQueryString.split("&");
	  	}
	  } else if ($(this).attr("href")!="undefined") {
	  	
	  	var strHref = $(this).attr("href")
	  	if ( strHref.indexOf("?") > -1 ){
	    	var strQueryString = strHref.substr(strHref.indexOf("?")+1);
	  		qString = strQueryString.split("&");
	  	}
	  } else {
	  	return null;
	  }	  
	  if (qString==null) return null;  
	  for (var i=0;i<qString.length; i++){
			if (escape(unescape(qString[i].split("=")[0])) == strParamName){
				returnVal.push(qString[i].split("=")[1]);
			}			
	  }	  
	  	  if (returnVal.length==0) return null;
	  else if (returnVal.length==1) return returnVal[0];
	  else return returnVal;
	}
});

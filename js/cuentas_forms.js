function MientrasForms(  ){

	this.disableButtons = function( value ){
		
		$('input[type="submit"], input[type="button"], button').attr('disabled', value);
	}
	
    this.validateForm = function( formid ){
    
    	this.disableButtons(true);
    	
    	//if (jQuery(formid + " .form-error-messages-wrapper").length==0){
    	//	jQuery(formid).append("<div class='form-error-messages-wrapper'><div class='form-error-messages'></div></div>");
    	//}
    	
    	/* mensajes generales */
    	//jQuery(formid + " .form-error-messages-wrapper").hide();
    	//jQuery(formid + " .form-error-messages").html("");
    	
    	/* mensajes de cada input */
    	jQuery(formid + " .input-error-message-wrapper").remove();
    	 
    	/*if( jQuery(formid + " .input-error-messages-wrapper").length > 0){
    		jQuery(formid + " .input-error-messages-wrapper").hide("");
    		jQuery(formid + " .input-error-messages").html("");
    	}*/
    	//console.log("validando: " + formid);
    	
    	var form_messages = new Array();
    	
    	jQuery(formid + " :input").each(function( index ) {
    		form_messages[jQuery( this ).attr("id")] = MientrasForms.validateField(formid, "#" + jQuery( this ).attr("id"));
    	});
    	
    	var showError = false;
    	jQuery(formid + " :input").each(function( index ) {
    		
    		var inputid = jQuery( this ).attr("id");
    		$messages = form_messages[inputid] ;
    	
    		if (jQuery( this ).parent().find(".input-error-messages-wrapper").length==0){
    			jQuery( this ).parent().append("<div class='input-error-messages-wrapper'><div class='input-error-messages'></div></div>");
        	}
    		
    		jQuery( this ).parent().find(".input-error-messages").html("");
    		
    		var index;
    		var inputShowError = false;
        	for	(index = 0; index < $messages.length; index++) {
        	    
        		
        		jQuery( this ).parent().find(".input-error-messages").append("<span class=\"input-error-message\"> " + $messages[index]  + "</span>");
        		
        		//jQuery(formid + " .form-error-messages").append("<span class=\"form-error-message detalle\"> " + $messages[index]  + "</span>");
        		showError = true;
        		
        		inputShowError = true;
        		
        	}
        	
        	if( inputShowError ){
        		
        		jQuery( this ).parent().find(".input-error-messages-wrapper").show();
        		
        	}else{
        		jQuery( this ).parent().find(".input-error-messages-wrapper").remove();
        	}
        	
    		
    	});
    	
    	if( showError ){
    		
    		this.disableButtons(false);
    		
    		return false;
    	}
    	else
    		
    		return true;
    }
    
    this.mostrarDetallesError = function (formid ){
    	jQuery(formid + " .form-error-messages .detalle").css("display", "block");
    	jQuery(formid + " .form-error-messages .form-error-message-desc").hide();
    }
    
	this.validateField = function (formid, fieldid ){
		
		var elemid =   formid + " " + fieldid;
		console.log( "validando " + elemid );
		var hasError= false;
		
		var fieldMessages = new Array();
		
		/* ver si es requerido */
		var required = jQuery( elemid ).attr( "data-required" );
		if( required =="yes" ){
			//console.log("es requerido ");
			var requiredMsg = jQuery( elemid ).attr( "data-required-msg" );
			if ( !this.validateRequired(elemid) ){
				fieldMessages[fieldMessages.length] = requiredMsg;
				hasError=true;
			}	
		}//else console.log("no es requerido ");

		/* ver si es checked requerido */
		var required = jQuery( elemid ).attr( "data-checked-required" );
		if( required =="yes" ){
			//console.log("es requerido ");
			var requiredMsg = jQuery( elemid ).attr( "data-required-msg" );
			if ( !this.validateCheckedRequired(elemid) ){
				fieldMessages[fieldMessages.length] = requiredMsg;
				hasError=true;
			}	
		}//else console.log("no es requerido ");

		/* ver si es solo letras */
		var letters = jQuery( elemid ).attr( "data-letters" );
		if( letters =="yes" ){
			var lettersMsg = jQuery( elemid ).attr( "data-letters-msg" );
			if ( !this.validateLetters(elemid) ){
				fieldMessages[fieldMessages.length] = lettersMsg;
				hasError=true;
			}	
		}
		
		/* ver si es un number */
		var number = jQuery( elemid ).attr( "data-number" );
		if( number =="yes" ){
			var numberMsg = jQuery( elemid ).attr( "data-number-msg" )
			if ( !this.validateNumber(elemid) ){
				fieldMessages[fieldMessages.length] = numberMsg;
				hasError=true;
			}
			
			if(jQuery( elemid ).val().length > 0){
			
				//validamos rangos
				var rangeMax = jQuery( elemid ).attr( "data-range-max" );
				if(rangeMax){
					var rangeMaxMsg = jQuery( elemid ).attr( "data-range-max-msg" )
					if ( !this.validateMaximo(elemid, rangeMax) ){
						rangeMaxMsg = rangeMaxMsg.replace("{0}", rangeMax);
						fieldMessages[fieldMessages.length] = rangeMaxMsg;
						hasError=true;
					}	
				}
				var rangeMin = jQuery( elemid ).attr( "data-range-min" );
				if(rangeMin){
					var rangeMinMsg = jQuery( elemid ).attr( "data-range-min-msg" )
					if ( !this.validateMinimo(elemid, rangeMin) ){
						rangeMinMsg = rangeMinMsg.replace("{0}", rangeMin);
						fieldMessages[fieldMessages.length] = rangeMinMsg;
						hasError=true;
					}	
				}
				
			}
			
			
		}
		
		/* ver si es un e-mail */
		var email = jQuery( elemid ).attr( "data-email" );
		if( email =="yes" ){
			var emailMsg = jQuery( elemid ).attr( "data-email-msg" )
			if ( !this.validateEmail(elemid) ){
				fieldMessages[fieldMessages.length] = emailMsg;
				hasError=true;
			}
		}

		/* ver si es un zipcode */
		var zipcode = jQuery( elemid ).attr( "data-zipcode" );
		if( zipcode =="yes" ){
			var zipCodeMsg = jQuery( elemid ).attr( "data-zipcode-msg" )
			if ( !this.validateZipcode(elemid) ){
				fieldMessages[fieldMessages.length] = zipCodeMsg;
				hasError=true;
			}
		}
		
		/* vemos si tiene alguna función custom */
		var customJs = jQuery( elemid ).attr( "data-custom" );
		if( customJs != undefined ){
			if ( !this.validateCustom(elemid, customJs) ){
				var customMsg = jQuery( elemid ).attr( "data-custom-msg" )
				fieldMessages[fieldMessages.length] = customMsg;
				hasError=true;
			}
		}
		
		
		if(hasError)
			this.setFieldWithError(elemid);
		else
			this.setFieldWithoutError(elemid);

		return fieldMessages;
	}
	
	this.validateCustom = function (elemid, strCallback){
		
		return eval( strCallback + "('" + elemid + "')" );
		//return callback( elemid );
		
	}
	
	this.validateCheckedRequired = function (elemid){
		console.log("validateCheckedRequired");
		var checked = ( jQuery(elemid).is(':checked') ) ;
		
		return checked;
	}
	
	this.validateRequired = function (elemid){
		
		var value = jQuery(elemid).val();
		
		var combo = jQuery( elemid ).attr( "data-combo" );
		
		if( combo == "yes"){
			if( value < 0)
				value = "";
		}
		if (value.length < 1) return false; else return true;
	}
	
	this.validateEmail = function(elemid){
		
		var value = jQuery(elemid).val();
		
		return this.isEmail(value) ;
	}


	this.validateNumber = function(elemid){
		
		var value = jQuery(elemid).val();
		
		return this.isNumber(value) ;
	}

	this.validateMaximo = function(elemid, maximo){
		
		var value = jQuery(elemid).val();
		
		return parseFloat(value) <= parseFloat(maximo) ;
	}
	
	this.validateMinimo = function(elemid, minimo){
		
		var value = jQuery(elemid).val();
		
		return parseFloat(value) >= parseFloat(minimo) ;
	}


	this.isLetters = function (elemid){
		
		var value = jQuery(elemid).val();
		
		return this.isLetters(value) ;
	}

	this.validateZipcode = function (elemid){
	
		var provinciaid = jQuery( elemid ).attr( "data-provincia" );
		
		var codigoPostalProvincia = $(provinciaid).find(":selected").attr("data-codigoPostal");
		var codigoPostal = $(elemid).val();

		if( codigoPostal.indexOf(codigoPostalProvincia) == 0 ){
			valido = true;
		}else{
			valido = false;
			
		}

		return  valido;
		
	}

	this.isEmail = function (val){
	    //var er_fh = /^([\w-\.\+])+@([\w-]+\.)+([a-z]){2,4}$/;
	    //var er_fh = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/;
	    var er_fh = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/;
	    if ( val !="" && !(er_fh.test( val ))){
	        return false;
	    } else {
	        return true;
	    }
	}

	this.isNumber = function (val){
	    var er_fh = /^\d+\.?\d*$/;
	    val = val.replace(",", ".");
	    if ( val !="" && !(er_fh.test( val )))
	    {
	        return false;
	    } else {
	        return true;
	    }  
	}

	this.isAlphabet = function (val){
		var er_fh = /^[A-Za-z]+$/;
	    if ( val !="" && !(er_fh.test( val )))
	    {
	        return false;
	    } else {
	        return true;
	    }
	}

	this.minChars = function (val, min){
	    if (val.length < min) return false; else return true;
		
	}

	this.maxChars = function (val, max){
	    if (val.length > max) return false; else return true;
		
	}
	
	this.setFieldWithoutError = function (elemid){
		
		jQuery( elemid ).parent().removeClass("input-error");
		
	}
	this.setFieldWithError = function (elemid){
		jQuery( elemid ).parent().addClass("input-error");
		
	}
	
	this.codigoPostalMask = function ( provinciaid, codigopostalid){
		
		var codigoPostalProvincia = $(provinciaid).find(":selected").attr("data-codigoPostal");

		if(codigoPostalProvincia != undefined ){
			$(codigopostalid).inputmask('remove');
			$(codigopostalid).inputmask({
		        mask: [codigoPostalProvincia+"999"], placeholder: ""
		    });

			$(codigopostalid).val(codigoPostalProvincia);
			//$(codigopostalid).focus();
			$(codigopostalid).setCursorToTextEnd();
		}else{
			$(codigopostalid).inputmask('remove');
			$(codigopostalid).inputmask({
		        mask: ["99999"], placeholder: ""
		    });
			
		}
		
	}
	
	this.documentoMask = function ( tipoDocumentoid, nroDocumentoid, incluirguion, tipoDocumentoDNI, tipoDocumentoNIE){
		
		var guion = "";
		if( incluirguion )
			guion="-";
		
		var tipoDoc = $(tipoDocumentoid).val();

		if( tipoDoc == tipoDocumentoDNI ){//dni

			$(nroDocumentoid).inputmask({
		        mask: ["99999999" + guion + "P"], placeholder: ""
		    });
		}else if( tipoDoc == tipoDocumentoNIE ){//nie
			$(nroDocumentoid).inputmask({
		        mask: "X-99999999" + guion + "P", placeholder: ""
		    });
		}else{
			$(nroDocumentoid).inputmask({
		        mask: ["99999999P"], placeholder: ""
		    });
		}    
		
	}
}

var MientrasForms = new MientrasForms();


$(document).ready(function() {
	
	$(".input-text").not(".input-email, .input-percentage, .input-date, .input-number, .input-currency").each(function( index ) {
		
		var max = $( this ).attr( "data-max-length" );
		if( max == undefined )
			max="50";
		/*$( this ).inputmask("[*{1," + max +"}]", { placeholder: "", showMaskOnHover: false, showTooltip: false });*/
	});
	
	$(".input-email").each(function( index ) {
		
		$( this ).inputmask("email", { showMaskOnHover: false,placeholder: ""  });
	});

	
	$(".input-date").each(function( index ) {
		
		$( this ).inputmask("date", { showMaskOnHover: false,placeholder: "" });
	});
	
	
	$(".input-number").not(".input-percentage, .input-currency").each(function( index ) {
		
		var max = $( this ).attr( "data-max-length" );
		if( max == undefined )
			max="10";
		
		var decimals = $( this ).attr( "data-decimals" );
		if( decimals == undefined )
			decimals="0";
		
		
		//$( this ).inputmask("[9{1," + max +"}]");
		$( this ).inputmask("numeric",{
			digits: decimals,
			integerDigits: max,
            prefix: "",
            suffix: "",
            rightAlign: 1,
            decimalProtect: 0,
            radixPoint: ",",
            autoGroup: false, 
            groupSeparator: ".", 
            groupSize: 3
		}, { showMaskOnHover: false });
		//console.log( index + ": " + $( this ).text() );
	});
	
	$(".input-currency").each(function( index ) {
		/*
		var decimals = $( this ).attr( "data-decimals" );
		var max = $( this ).attr( "data-max-length" );
		if( max == undefined )
			max="10";
		$( this ).inputmask("currency", {prefix: "€ ",  digits: decimals, radixPoint: ",", autoGroup: false, groupSeparator: ".", groupSize: 3 });
		 */
		
				
		var decimals = $( this ).attr( "data-decimals" );
		if( decimals == undefined )
			decimals="2";
		var max = $( this ).attr( "data-max-length" );
		if( max == undefined )
			max="10";
		
		
		$( this ).inputmask("decimal", { digits: decimals, integerDigits: max, radixPoint: ",", autoGroup: false, groupSeparator: ".", groupSize: 3 }, { showMaskOnHover: false });
		/*
		$( this ).inputmask("numeric", {
		        groupSeparator: ".",
		        radixPoint: ",",
		        placeholder: "0",
		        autoGroup: true,
		        digits: decimals,
		        integerDigits: max,
		        digitsOptional: true,
		        prefix: "$ "
		    });
		*/
		
	});
	
	$(".input-percentage").each(function( index ) {
		/*
		var decimals = $( this ).attr( "data-decimals" );
		var max = $( this ).attr( "data-max-length" );
		if( max == undefined )
			max="10";
		$( this ).inputmask("currency", {prefix: "% ",  digits: decimals, radixPoint: ",", autoGroup: false, groupSeparator: ".", groupSize: 3 });
		*/
		var decimals = $( this ).attr( "data-decimals" );
		if( decimals == undefined )
			decimals="2";
		max="2";
		$( this ).inputmask("decimal", { digits: decimals, radixPoint: ",", integerDigits: max, autoGroup: false, groupSeparator: ".", groupSize: 3 }, { showMaskOnHover: false });
	});

});


function checkFormatoClave(elemid){

	var pwd = $(elemid).val();
	if(pwd.length==0)
		return false;
	
	var arrPwd = pwd.replace (/\s+/g,"").split(/\s*/);
	var arrPwdLen = arrPwd.length;

	var nAlphaUC=0;
	var nNumeric=0;

	if(arrPwdLen<8)
		return false;
	
	for (var a=0; a < arrPwdLen; a++) {

		if (arrPwd[a].match(new RegExp(/[A-Z]/g))) 
			nAlphaUC++;

		if (arrPwd[a].match(new RegExp(/[0-9]/g))) 
			nNumeric++;
		
			
	}
	if( nAlphaUC < 1)	
		return false;

	if( nNumeric < 1)
		return false;
	
	return true;
}
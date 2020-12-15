function MientrasUtils(  ){
	
	this.WLB_DATE_FORMAT = 'd/m/Y';
	this.WLB_DATETIME_FORMAT = 'd/m/y H:i:s';
	this.WLB_TIME_FORMAT = 'H:i';
	
	//números
	this.WLB_DECIMALES = '2';
	this.WLB_SEPARADOR_DECIMAL = ',';
	this.WLB_SEPARADOR_MILES = '.';

	//moneda.
	this.WLB_MONEDA_SIMBOLO = '$';
	this.WLB_MONEDA_ISO = 'ARS';
	this.WLB_MONEDA_NOMBRE = 'Pesos';
	this.WLB_MONEDA_POSICION_IZQ = 1;

    
	this.parseNumero = function ( sNumero ){
		
		var r = parseFloat(sNumero);
		
		return r;
		
	}
	
	this.getEntero = function ( numero ){
		
		var r = Math.floor(numero);
		return r;
		
	}
	
	this.getDecimales = function ( numero ){
		
		var r = numero % 1;
		r = r.toFixed(2);
		r = (r + "").split(".");
		return r[1];
		
	} 

	this.getDecimalesLength = function ( numero ){
		
		if( (numero+"").indexOf(".") > 0){
			var r = (numero + "").split(".");
			var decimales = r[1];
			return decimales.length;	
		}else{
			return 0;
		}
		
		
	} 

	this.formatLargeDateToView = function ( fecha, formato){
		
		return this.getDiaLabel(fecha) + " " + this.getDia(fecha) + " " + this.getMesLabel(fecha) + ", " + this.getAnio(fecha);
	}
	
	this.formatDateToView = function ( fecha, formato){
		
		return fecha.toDateString();
		 
		
	}

	this.getDiaLabel = function( fecha ){
		
		var dia=new Array(7);
		dia[0]="Domingo";
		dia[1]="Lunes";
		dia[2]="Martes";
		dia[3]="Miércoles";
		dia[4]="Jueves";
		dia[5]="Viernes";
		dia[6]="Sábado";
		return dia[fecha.getDay()];
		
	}
	
	this.getMesLabel = function( fecha ){
		
		var m2 = fecha.getMonth();
		//var mesok = (m2 < 10) ? '0' + m2 : m2;
		var mesok=new Array(12);
		mesok[0]="Enero";
		mesok[1]="Febrero";
		mesok[2]="Marzo";
		mesok[3]="Abril";
		mesok[4]="Mayo";
		mesok[5]="Junio";
		mesok[6]="Julio";
		mesok[7]="Agosto";
		mesok[8]="Septiembre";
		mesok[9]="Octubre";
		mesok[10]="Noviembre";
		mesok[11]="Diciembre";
		
		return mesok[fecha.getMonth()];
		
	}
	
	this.getAnio = function( fecha ){
		
		return fecha.getFullYear();
	}

	this.getDia = function( fecha ){
		
		return fecha.getDate();
	}
	
	this.sumarDias = function ( fecha, dias ){
		
		fecha.setDate(fecha.getDate() + dias);
		return fecha; 
		
	}
	
    /**
     * da formato a un monto para visualizarlo.
     */
    this.formatMontoToView = function ( numero, moneda, decimales ){
    	
    	if( decimales == undefined )
    		decimales = 2;
    	if(moneda == undefined ){
    		moneda = '';
    	}
    	return this.jsDecimal( numero, decimales, ',', '.', moneda);
    }
    
    /**
     * da formato a un porcentaje para visualizarlo.
     */
    this.formatPorcentajeToView = function ( numero ){
    	
    	return this.jsDecimal( numero, 2, ',', '.', "%", true);
    }
    
    /*
    * Da formato a un número para su visualización
    *
    * numero (Number o String) - Número que se mostrará
    * decimales (Number, opcional) - Nº de decimales (por defecto, auto)
    * separador_decimal (String, opcional) - Separador decimal (por defecto, coma)
    * separador_miles (String, opcional) - Separador de miles (por defecto, ninguno)
    */
    this.jsDecimal = function (numero, decimales, separador_decimal, separador_miles,Simbolo,SimboloRight) {
    	numero = parseFloat(numero);
    	
    	if (isNaN(numero)) {
    		return "";
    	}
    	
    	if (SimboloRight == undefined) {
    		SimboloRight = false;
    	}else{
    		SimboloRight = true;
    	}
    	
    	if (decimales !== undefined) {
    		// Redondeamos
    		numero = numero.toFixed(decimales);
    	}
    	
    	// Convertimos el punto en separador_decimal
    	numero = numero.toString().replace(".", separador_decimal !== undefined ? separador_decimal : ",");
    	
    	if (separador_miles) {
    		// Añadimos los separadores de miles
    		var miles = new RegExp("(-?[0-9]+)([0-9]{3})");
    		while (miles.test(numero)) {
    			numero = numero.replace(miles, "$1" + separador_miles + "$2");
    		}
    	}
    	
    	if(SimboloRight)
    		return numero + " " + Simbolo;
    	else
    		return Simbolo + " " + numero;
    }

}

var MientrasUtils = new MientrasUtils();



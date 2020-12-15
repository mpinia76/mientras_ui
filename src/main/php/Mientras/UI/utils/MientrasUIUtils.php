<?php
namespace Mientras\UI\utils;



use Mientras\Core\utils\MientrasUtils;
use Mientras\Core\model\Producto;
use Mientras\Core\model\EstadoVenta;

use Mientras\Core\model\DetalleVenta;

use Mientras\Core\model\DetallePedido;

use Mientras\Core\model\DevolucionVenta;

use Mientras\Core\model\ProductoCombo;

use Mientras\Core\model\EstadoPedido;

use Mientras\Core\model\EstadoPago;

use Mientras\Core\model\DetallePresupuesto;

use Mientras\Core\model\EstadoPresupuesto;

use Rasty\utils\RastyUtils;
use Rasty\utils\Logger;

use Rasty\i18n\Locale;
use Rasty\conf\RastyConfig;

use Cose\Security\model\Usergroup;
use Cose\Security\model\User;

use Mientras\Core\model\EstadoGasto;

use Mientras\UI\service\UIServiceFactory;



/**
 * Utilidades para el sistema cuentas ui.
 *
 * @author Bernardo
 * @since 24-05-2014
 */
class MientrasUIUtils {

	const CTS_DATE_FORMAT = 'd/m/Y';
	const CTS_DATETIME_FORMAT = 'd/m/y H:i:s';
	const CTS_TIME_FORMAT = 'H:i';
	
	const CTS_PRACTICA_DEFAULT = "42.01.02";
	
	//números
	const CTS_DECIMALES = '2';
	const CTS_SEPARADOR_DECIMAL = ',';
	const CTS_SEPARADOR_MILES = '.';

	//moneda.
	const CTS_MONEDA_SIMBOLO = '$';
	const CTS_MONEDA_ISO = 'ARS';
	const CTS_MONEDA_NOMBRE = 'Pesos Argentinos';
	const CTS_MONEDA_POSICION_IZQ = 1;

	
	public static function getWebPath(){
	
		return RastyConfig::getInstance()->getWebPath();
		
	}
	
	public static function getAppPath(){
	
		return RastyConfig::getInstance()->getAppPath();
		
	}
	
	public static function getChartsWebPath(){
	
		return RastyConfig::getInstance()->getWebPath() . "/tmp/";
		
	}
	
	public static function getChartsAppPath(){
	
		return RastyConfig::getInstance()->getAppPath() . "/tmp/";
		
	}
	
	public static function getChartsFontPath(){
	
		return "vendor/realityking/pchart/Fonts/";
	}
	
	/**
	 * registramos la sesión del empleado
	 * @param Empleado $empleado
	 */
	public static function login(Empleado $empleado) {
		
		$appName = RastyConfig::getInstance()->getAppName();
		
        
        
    }

    /**
     * finalizamos la sesión del empleado
     */
    public static function logout() {
    	
    	$appName = RastyConfig::getInstance()->getAppName();
		
      
        
        $_SESSION [$appName]["admin_oid"] = null;
		$_SESSION [$appName]["admin_name"] = null;
		$_SESSION [$appName]["admin_username"] = null;
		unset($_SESSION [$appName]["admin_oid"]);
		unset($_SESSION [$appName]["admin_name"]);
		unset($_SESSION [$appName]["admin_username"]);
    }
	
  

    
    
	/**
	 * se formateo un monto a visualizar
	 * @param $monto
	 * @return string
	 */
	public static function formatMontoToView( $monto, $simbolo=null ){
	
		if( empty($monto) )
		$monto = 0;

		$res = $monto;
		//si es negativo, le quito el signo para agregarlo antes de la moneda.
		if( $monto < 0 ){
			$res = $res * (-1);
		}
			
		$res = number_format ( $res ,  self::CTS_DECIMALES , self::CTS_SEPARADOR_DECIMAL, self::CTS_SEPARADOR_MILES );

		$simbolo = ($simbolo)?$simbolo:self::CTS_MONEDA_SIMBOLO ;

		if( self::CTS_MONEDA_POSICION_IZQ ){
			$res = $simbolo . $res;
				
		}else
		$res = $res. $simbolo ;

		//si es negativo lo mostramos rojo y le agrego el signo.
		if( $monto < 0 ){
			$res = "<span style='color:red;'>- $res</span>";
		}

		return $res;
	}


	//Formato fecha yyyy-mm-dd
	public static function differenceBetweenDates($fecha_fin, $fecha_Ini, $formato_salida = "d") {
		$valueFI = str_replace('/', '-', $fecha_Ini);
		$valueFF = str_replace('/', '-', $fecha_fin);
		$f0 = strtotime($valueFF);
		$f1 = strtotime($valueFI);
		if ($f0 < $f1) {
			$tmp = $f1;
			$f1 = $f0;
			$f0 = $tmp;
		}
		return date($formato_salida, $f0 - $f1);
	}

	
	public static function formatMesToView( $mes ){
	
		$meses = array (
			"1" => "Enero",
			"2" => "Febrero",
			"3" => "Marzo",
			"4" => "Abril",
			"5" => "Mayo",
			"6" => "Junio",
			"7" => "Julio",
			"8" => "Agosto",
			"9" => "Septiembre",
			"10" => "Octubre",
			"11" => "Noviembre",
			"12" => "Diciembre"
		);
		
		return $meses[$mes];
	}
	
	public static function formatDateToView($value, $format=self::CTS_DATE_FORMAT) {
		
		$res = "";
		if( !empty( $value) )
			$res = $value->format($format);
		else $res = "";
		
		$meses = array (
			"January" => "Enero",
			"Febraury" => "Febrero",
			"March" => "Marzo",
			"April" => "Abril",
			"May" => "Mayo",
			"June" => "Junio",
			"July" => "Julio",
			"August" => "Agosto",
			"September" => "Septiembre",
			"October" => "Octubre",
			"November" => "Noviembre",
			"December" => "Diciembre",
			"Jan" => "Ene",
			"Feb" => "Feb",
			"Mar" => "Mar",
			"Apr" => "Abr",
			"May" => "May",
			"Jun" => "Jun",
			"Jul" => "Jul",
			"Aug" => "Ago",
			"Sep" => "Sep",
			"Oct" => "Oct",
			"Nov" => "Nov",
			"Dec" => "Dic"
		);
		
		$dias = array(
			'Monday' => 'Lunes',
			'Tuesday' => 'Martes',
			'Wednesday' => 'Miércoles',
			'Thursday' => 'Jueves',
			'Friday' => 'Viernes',
			'Saturday' => 'Sábado',
			'Sunday' => 'Domingo',
			'Mon' => 'Lun',
			'Tue' => 'Mar',
			'Wed' => 'Mie',
			'Thu' => 'Jue',
			'Fri' => 'Vie',
			'Sat' => 'Sab',
			'Sun' => 'Dom',
		);
		foreach ($meses as $key => $value) {
			$res = str_replace($key, $value, $res);
		}
		foreach ($dias as $key => $value) {
			$res = str_replace($key, $value, $res);
		}
		
		return $res ;
		/*
		$value = str_replace('/', '-', $value);
		
		if (!empty($value)) {
			$dt = date($format, strtotime($value));
		}else
		$dt = "";

		return $dt;
		*/
	}

	public static function formatDateToPersist($value) {

		return $value->format("Y-m-d");
		
		/*		
		$value = str_replace('/', '-', $value);
		
		if (!empty($value))
		$dt = date("Y-m-d", strtotime($value));
		else
		$dt = "";
		return $dt;*/
	}

	public static function formatDateTimeToView($value) {
		
		if(!empty($value))
			return $value->format(self::CTS_DATETIME_FORMAT);
		else
			return "";
		/*
		$value = str_replace('/', '-', $value);
		
		if (!empty($value)) {
			$dt = date(self:CTS_DATE_FORMAT, strtotime($value));
		}else
		$dt = "";

		return $dt;*/
	}

	public static function formatDateTimeToPersist($value) {
		
		return $value->format("Y-m-d H:i:s");
		
		/*
		$value = str_replace('/', '-', $value);
		
		if (!empty($value))
		$dt = date("Y-m-d H:i:s", strtotime($value));
		else
		$dt = "";

		return $dt;*/
	}

	public static function addDays($date, $dateFormat="", $days){

		$date->modify("+$days day");
		return $date;
		/*
		$newDate = strtotime ( "+$days day" , strtotime ( $date ) ) ;
		$newDate = date ( $dateFormat , $newDate );
		
		return $newDate;
		*/
	}

	public static function substractDays($date, $dateFormat, $days){

		$date->modify("-$days day");
		return $date;
		/*
		$newDate = strtotime ( "-$days day" , strtotime ( $date ) ) ;
		$newDate = date ( $dateFormat , $newDate );

		return $newDate;
		*/
	}

	public static function addMinutes($date, $dateFormat, $minutes){
		
		//$date->modify("+$minutes minutes");
		//return $date;
		
		$newDate = strtotime ( "+$minutes minutes" , strtotime ( $date ) ) ;
		$newDate = date ( $dateFormat , $newDate );
		
		return $newDate;
	}
	
	public static function isSameDay( $dt_date, $dt_another){

		return $dt_date->format("Ymd") == $dt_another->format("Ymd");
		 
		/*
		$dt_dateAux = strtotime ( $dt_date ) ;
		$dt_dateAux = date ( "Ymd" , $dt_dateAux );

		$dt_anotherAux = strtotime ( $dt_another ) ;
		$dt_anotherAux = date ( "Ymd" , $dt_anotherAux );

		return $dt_dateAux == $dt_anotherAux ;*/
	}


	public static function formatTimeToView($value, $format=self::CTS_TIME_FORMAT) {
		
		if(!empty($value))
		
			return $value->format($format);

		else return "";	
		/*
		$value = str_replace('/', '-', $value);
		
		if (!empty($value)) {
			$dt = date(self:CTS_TIME_FORMAT, strtotime($value));
		}else
		$dt = "";

		return $dt;*/
	}

	public static function getHorasItems() {
		
		$desde = new \DateTime();
		$desde->setTime(0,0,0);
		$duracion = 15;
		$i=0;
		while( $i<97 ){
			
			$items[$desde->format("H:i")] = $desde->format("H:i");
			
			$desde->modify("+$duracion minutes");
			
			$i++;	
			
		}
		
		return $items;
		
	}

	public static function formatEdad( $edad ){
	
		if( !empty($edad) ){
		
			if( $edad > 1)
				return "$edad años";
			else
				return "$edad año";
		}return "";
	}
	
	public static function getEdad( $fecha ){

		$fechaNac = $fecha;
		
		if ($fechaNac != null ){
			
			$hoy = new \DateTime();
			
			$dia = $hoy->format("d");
			$mes = $hoy->format("m");
			$anio = $hoy->format("Y");
			 
			//fecha de nacimiento
			$dia_nac = $fechaNac->format("d");
			$mes_nac = $fechaNac->format("m");
			$anio_nac = $fechaNac->format("Y");
			
			//si el mes es el mismo pero el día inferior aun no ha cumplido años, le quitaremos un año al actual
			 
			if (($mes_nac == $mes) && ($dia_nac > $dia)) {
				$anio=($anio-1); 
			}
			 
			//si el mes es superior al actual tampoco habrá cumplido años, por eso le quitamos un año al actual
			 
			if ($mes_nac > $mes) {
				$anio=($anio-1);
			}
			 
			//ya no habría mas condiciones, ahora simplemente restamos los años y mostramos el resultado como su edad
			 
			$edad=($anio-$anio_nac);    	    
				
		}
		else
			$edad = "";
		
    	return $edad;
	}
	
	

	
	public static function dayOfDate(\DateTime $value) {
		
		return $value->format("d");
		
		/*
		$value = str_replace('/', '-', $value);
		
		if (!empty($value)) {
			$dt = date("d", strtotime($value));
		}else
		$dt = "";

		return $dt;*/
	}

	public static function monthOfDate($value) {
		
		return $value->format("m");
		
		/*
		$value = str_replace('/', '-', $value);
		
		if (!empty($value)) {
			$dt = date("m", strtotime($value));
		}else
		$dt = "";

		return $dt;*/
	}
	
	public static function yearOfDate($value) {
		
		return $value->format("Y");
		
		/*
		$value = str_replace('/', '-', $value);
		
		if (!empty($value)) {
			$dt = date("Y", strtotime($value));
		}else
		$dt = "";

		return $dt;*/
	}
	
	public static function strtotime($value) {
		
		$value = str_replace('/', '-', $value);
		
		return strtotime($value);
	}


	public static function newDateTime($value) {
		
		$value = str_replace('/', '-', $value);
		$time = strtotime($value);
		
		$dateTime = new \DateTime();
		$dateTime->setDate(date("Y", $time), date("m", $time), date("d", $time));
		$dateTime->setTime(date("H", $time), date("i", $time), date("s", $time));
		
		return $dateTime;
	}
	
	
	
	public static function localize($keyMessage){
	
		return Locale::localize( $keyMessage );
	}
	
	
	public static function localizeEntities($enumeratedEntities){
		
		$items = array();
		
		foreach ($enumeratedEntities as $key => $keyMessage) {
			$items[$key] = self::localize($keyMessage);
		}
		
		return $items;
	}
	
	public static function formatMessage($msg, $params){
		
		if(!empty($params)){
			
			$count = count ( $params );
			$i=1;
			while ( $i <= $count ) {
				$param = $params [$i-1];
				
				$msg = str_replace('$'.$i, $param, $msg);
				
				$i ++;
			}
			
		}
		return $msg;
		
	
	}
	
	
	
	
	public static function getNewDate($dia,$mes,$anio){
	
		$date = new \DateTime();
		$date->setDate($anio, $mes, $dia);
		return $date;
	}
	
	
	public static function getFirstDayOfWeek(\Datetime $fecha){
	
		$f = new \Datetime();
		$f->setTimestamp( $fecha->getTimestamp() );
    	
		//si es lunes, no hacemos nada, sino, buscamos el lunes anterior.
		if( $f->format("N") > 1 )
			$f->modify("last monday");
    	
    	return $f;
	}
	
	
	public static function getLastDayOfWeek(\Datetime $fecha){
	
		$f = new \Datetime();
		$f->setTimestamp( $fecha->getTimestamp() );
    	$f->modify("next monday");
    	
    	//si no es lunes, restamos un día.
    	if( $fecha->format("N") > 1 )
			$f->sub(new \DateInterval('P1D'));
    	
    	return $f;
	}
	
	public static function fechasIguales(\Datetime $fecha1, \Datetime $fecha2){
		return $fecha1->format("Ymd") == $fecha2->format("Ymd");
	}
	
	public static function horaSuperpuesta( $hora, $desde, $hasta  ){
	
		$superpuesta = false;
		
		if( empty($hora)  || empty($desde)  || empty($hasta) )
			$superpuesta = false;
			
		$timeHora = strtotime($hora);
		$timeDesde = strtotime($desde);
		$timeHasta = strtotime($hasta);
		
		
			
		if( ($timeDesde <= $timeHora)  && ($timeHasta > $timeHora) )
			$superpuesta = true;

		//Logger::log( " horaSuperpuesta( $hora, $desde, $hasta ) = $superpuesta");		
		
		return $superpuesta;
	}
	
	
   	
   	/**
	 * registramos la sesión del admin
	 * @param User $user
	 */
	public static function loginAdmin(User $user) {
		
		$appName = RastyConfig::getInstance()->getAppName();
		
        $_SESSION [$appName]["admin_oid"] = $user->getOid();
		$_SESSION [$appName]["admin_name"] = $user->getName();
		$_SESSION [$appName]["admin_username"] = $user->getUsername();
        
    }
   	
	
	/**
     * @return true si hay un admin logueado.
     */
    public static function isAdminLogged() {
    	
    	$appName = RastyConfig::getInstance()->getAppName();
    	
    	$data = RastyUtils::getParamSESSION($appName);
		
		$logueado =  ($data != "");
		
		if( $logueado ){
			$logueado = isset($data["admin_oid"]) && !empty($data["admin_oid"]); 
		}
		return $logueado;
    }
    
    /**
     * @return admin logueado
     */
    public static function getAdminLogged() {
        
    	$appName = RastyConfig::getInstance()->getAppName();
    	
    	$data = RastyUtils::getParamSESSION( $appName );
    	
    	
    	if( !self::isAdminLogged() )
    		return null;
    	
    	$user = new User();
        $user->setOid($data["admin_oid"]);
        $user->setName($data["admin_name"]);
        $user->setUsername($data["admin_username"]);
       
        return $user;
    }
	

    /**
	 * se formateo un número a visualizar como porcentaje
	 * @param $numero
	 * @return string
	 */
	public static function formatPorcentajeToView( $numero ){
	
		if( empty($numero) )
		$numero = 0;

		$res = $numero;
		//si es negativo, le quito el signo para agregarlo antes de la moneda.
		if( $numero < 0 ){
			$res = $res * (-1);
		}
			
		$res = number_format ( $res ,  2 , self::CTS_SEPARADOR_DECIMAL, self::CTS_SEPARADOR_MILES );

		$res = $res. "%" ;

		return $res;
	}

public static function agregarDetallePedidoSession(DetallePedido $detalle) {
		
		$detalles = self::getDetallesPedidoSession();

		//si ya estaba incremento la cantidad
		$existe = false;
		$indexExistente = 0;
		$index = 0;
		foreach ($detalles as $detallejson) {
			//mismo producto y mismo precio
			if(( $detalle->getProducto()->getOid() == $detallejson["producto_oid"] ) &&
				( $detalle->getPrecioUnitario() == $detallejson["precioUnitario"] ) ){
				$existe = true;
				$detalle->setCantidad($detalle->getCantidad() + $detallejson["cantidad"]);
				$indexExistente = $index;
			}
			$index++;
		}
		
		$detallejson = array();
		$detallejson["producto_oid"] = $detalle->getProducto()->getOid();
		$detallejson["producto_nombre"] = $detalle->getProducto()->getNombre();
	    $detallejson["precioUnitario"] = $detalle->getPrecioUnitario();
	    $detallejson["cantidad"] = $detalle->getCantidad();
	    $detallejson["subtotal"] = $detalle->getCantidad() * $detalle->getPrecioUnitario();
	        
		if($existe){
	        
			//unset($detalles[$indexExistente]);
        	//$detalles = array_values($detalles);
        	$detalles[$indexExistente]["cantidad"] = $detallejson["cantidad"];
        	$detalles[$indexExistente]["subtotal"] = $detallejson["subtotal"]; 
		}else{
			$detalles[] = $detallejson;
		}
		
		
		
		self::setDetallesPedidoSession($detalles);
    }
    
	public static function borrarDetallePedidoSession( $index=0 ) {
		
		$detalles = self::getDetallesPedidoSession();

		unset($detalles[$index]);
        $detalles = array_values($detalles);
        
		self::setDetallesPedidoSession($detalles);
    }
    public static function getDetallesPedidoSession() {
    
    	$appName = RastyConfig::getInstance()->getAppName();
		
    	$data = RastyUtils::getParamSESSION($appName);
		
		if( isset( $data['detallesPedido_session']) )
			$detalles = unserialize( $data['detallesPedido_session']);
		else 
			$detalles = array();
			
		return $detalles;
   	}
 
   	public static function setDetallesPedidoSession( $detalles ) {
    
    	$appName = RastyConfig::getInstance()->getAppName();
		
		$_SESSION[$appName]['detallesPedido_session'] = serialize($detalles);
			
   	}
   	
	public static function getOpcionesBooleanasEmpty(){
		
		$items = array();
		
		$items[-1] = self::localize("criteria.sin_especificar");
		$items[1] = self::localize("criteria.si");
		$items[2] = self::localize("criteria.no");
		
		return $items;
		
	}

	public static function getOpcionesBooleanas(){
		
		$items = array();
		
		$items[2] = self::localize("criteria.no");
		$items[1] = self::localize("criteria.si");
		
		return $items;
		
	}

	
   	
   	public static function getMeses(){
   	
   		return array ( 1 => self::localize("mes.enero")
   						,2 => self::localize("mes.febrero")
   						,3 => self::localize("mes.marzo")
   						,4 => self::localize("mes.abril")
   						,5 => self::localize("mes.mayo")
   						,6 => self::localize("mes.junio")
   						,7 => self::localize("mes.julio")
   						,8 => self::localize("mes.agosto")
   						,9 => self::localize("mes.septiembre")
   						,10 => self::localize("mes.octubre")
   						,11 => self::localize("mes.noviembre")
   						,12 => self::localize("mes.diciembre")
   						);
   	
   	}
   	
	public static function getEstadoGastoCss($estadoGasto){
		$estilos = array(
						EstadoGasto::Pagado=> "bg-lightGreen fg-black",
						EstadoGasto::Impago=> "bg-yellow fg-black",
						EstadoGasto::Anulado=> "bg-crimson fg-white"
						);
						
		return $estilos[$estadoGasto];
	}
	
	public static function getEstadoVentaCss($estadoVenta){
		$estilos = array(
						EstadoVenta::Pagada=> "bg-lightGreen fg-black",
						EstadoVenta::Impaga=> "bg-yellow fg-black",
						EstadoVenta::PagadaParcialmente=> "bg-orange fg-black",
						EstadoVenta::Anulada=> "bg-crimson fg-white"
						);
						
		return $estilos[$estadoVenta];
	}
	
	public static function getEstadoPagoCss($estadoPago){
		$estilos = array(
						EstadoPago::Pendiente=> "bg-yellow fg-black",
						EstadoPago::Realizado=> "bg-lightGreen fg-black",
						EstadoPago::Anulado=> "bg-crimson fg-white"
						);
						
		return $estilos[$estadoPago];
	}
	
	public static function getEstadoPresupuestoCss($estadoPresupuesto){
		$estilos = array(
						EstadoPresupuesto::Pendiente=> "bg-yellow fg-black",
						EstadoPresupuesto::Aprobado=> "bg-lightGreen fg-black",
						EstadoPresupuesto::Anulado=> "bg-crimson fg-white"
						);
						
		return $estilos[$estadoPresupuesto];
	}
	
	public static function agregarDetalleVentaSession(DetalleVenta $detalle) {
		
		$detalles = self::getDetallesVentaSession();

		//si ya estaba incremento la cantidad
		$existe = false;
		$indexExistente = 0;
		$index = 0;
		$cantidad=0;
		foreach ($detalles as $detallejson) {
			//mismo producto y mismo precio
			if(( $detalle->getProducto()->getOid() == $detallejson["producto_oid"] ) &&
				( $detalle->getPrecioUnitario() == $detallejson["precioUnitario"] ) ){
				$existe = true;
				$detalle->setCantidad($detalle->getCantidad() + $detallejson["cantidad"]);
				$indexExistente = $index;
			}
			$index++;
		}
		
		$detallejson = array();
		$detallejson["producto_oid"] = $detalle->getProducto()->getOid();
		if ($detalle->getCombo()) {
			$detallejson["combo_oid"] = $detalle->getCombo()->getOid();
			$detallejson["combo_nombre"] = $detalle->getCombo()->getNombre();
			$detallejson["combo_precio"] = $detalle->getCombo()->getPrecio();$oCombo = UIServiceFactory::getUIComboService()->get( $detalle->getCombo()->getOid() );
						
			foreach ($oCombo->getProductos() as $producto) {
				
				if ($detalle->getProducto()->getOid()==$producto->getProducto()->getOid()) {
					$cantidad = $detalle->getCantidad()/$producto->getCantidad();
					break;
				}
			}
			$detallejson["combo_cantidad"] = $cantidad;
		}
		$detallejson["producto_nombre"] = $detalle->getProducto()->getTipoProducto()->getNombre().' '.$detalle->getProducto()->getMarcaProducto()->getNombre().' '.$detalle->getProducto()->getNombre();
	    $detallejson["precioUnitario"] = $detalle->getPrecioUnitario();
	    $detallejson["costo"] = $detalle->getCosto();
	    $detallejson["stockActualizado"] = $detalle->getStockActualizado();
	    $detallejson["cantidad"] = $detalle->getCantidad();
	    $detallejson["subtotal"] = $detalle->getCantidad() * $detalle->getPrecioUnitario();
	    $detallejson["ganancia"] = ($detalle->getCantidad() * $detalle->getPrecioUnitario())-$detalle->getCantidad() * $detalle->getCosto();     
		if($existe){
	        
			//unset($detalles[$indexExistente]);
        	//$detalles = array_values($detalles);
        	$detalles[$indexExistente]["combo_cantidad"] = $cantidad;
        	$detalles[$indexExistente]["cantidad"] = $detallejson["cantidad"];
        	$detalles[$indexExistente]["subtotal"] = $detallejson["subtotal"]; 
        	$detalles[$indexExistente]["ganancia"] = $detallejson["ganancia"]; 
		}else{
			$detalles[] = $detallejson;
		}
		
		
		
		self::setDetallesVentaSession($detalles);
    }
    
	public static function borrarDetalleVentaSession( $index=0 ) {
		
		$detalles = self::getDetallesVentaSession();

		unset($detalles[$index]);
        $detalles = array_values($detalles);
        
		self::setDetallesVentaSession($detalles);
    }
    
    public static function getDetallesVentaSession() {
    
    	$appName = RastyConfig::getInstance()->getAppName();
		
    	$data = RastyUtils::getParamSESSION($appName);
		
		if( isset( $data['detallesVenta_session']) )
			$detalles = unserialize( $data['detallesVenta_session']);
		else 
			$detalles = array();
			
		
			
		return $detalles;
   	}
 
   	public static function setDetallesVentaSession( $detalles ) {
    
    	$appName = RastyConfig::getInstance()->getAppName();
		
		$_SESSION[$appName]['detallesVenta_session'] = serialize($detalles);
			
   	}
   	
	public static function agregarDevolucionVentaSession(DevolucionVenta $devolucion) {
		
		$devoluciones = self::getDevolucionesVentaSession();

		//si ya estaba incremento la cantidad
		$existe = false;
		$indexExistente = 0;
		$index = 0;
		foreach ($devoluciones as $devolucionjson) {
			//mismo producto y mismo precio
			if(( $devolucion->getProducto()->getOid() == $devolucionjson["producto_oid"] ) &&
				( $devolucion->getPrecioUnitario() == $devolucionjson["precioUnitario"] ) ){
				$existe = true;
				$devolucion->setCantidad($devolucion->getCantidad() + $devolucionjson["cantidad"]);
				$indexExistente = $index;
			}
			$index++;
		}
		
		$devolucionjson = array();
		$devolucionjson["producto_oid"] = $devolucion->getProducto()->getOid();
		$devolucionjson["producto_nombre"] = $devolucion->getProducto()->getTipoProducto()->getNombre().' '.$devolucion->getProducto()->getMarcaProducto()->getNombre().' '.$devolucion->getProducto()->getNombre();
	    $devolucionjson["precioUnitario"] = $devolucion->getPrecioUnitario();
	    $devolucionjson["costo"] = $devolucion->getCosto();
	    $devolucionjson["stockActualizado"] = $devolucion->getStockActualizado();
	    $devolucionjson["cantidad"] = $devolucion->getCantidad();
	    $devolucionjson["subtotal"] = $devolucion->getCantidad() * $devolucion->getPrecioUnitario();
	    
		if($existe){
	        
			//unset($devoluciones[$indexExistente]);
        	//$devoluciones = array_values($devoluciones);
        	$devoluciones[$indexExistente]["cantidad"] = $devolucionjson["cantidad"];
        	$devoluciones[$indexExistente]["subtotal"] = $devolucionjson["subtotal"]; 
        	
		}else{
			$devoluciones[] = $devolucionjson;
		}
		
		//Logger::logObject($devoluciones);
		
		self::setDevolucionesVentaSession($devoluciones);
    }
    
	public static function borrarDevolucionVentaSession( $index=0 ) {
		
		$devoluciones = self::getDevolucionesVentaSession();

		unset($devoluciones[$index]);
        $devoluciones = array_values($devoluciones);
        
		self::setDevolucionesVentaSession($devoluciones);
    }
    
    public static function getDevolucionesVentaSession() {
    
    	$appName = RastyConfig::getInstance()->getAppName();
		
    	$data = RastyUtils::getParamSESSION($appName);
		
		if( isset( $data['devolucionesVenta_session']) )
			$devoluciones = unserialize( $data['devolucionesVenta_session']);
		else 
			$devoluciones = array();
			
		
			
		return $devoluciones;
   	}
 
   	public static function setDevolucionesVentaSession( $devoluciones ) {
    
    	$appName = RastyConfig::getInstance()->getAppName();
		
		$_SESSION[$appName]['devolucionesVenta_session'] = serialize($devoluciones);
			
   	}
   	
	public static function agregarDetallePresupuestoSession(DetallePresupuesto $detalle) {
		
		$detalles = self::getDetallesPresupuestoSession();

		//si ya estaba incremento la cantidad
		$existe = false;
		$indexExistente = 0;
		$index = 0;
		foreach ($detalles as $detallejson) {
			//mismo producto y mismo precio
			if(( $detalle->getProducto()->getOid() == $detallejson["producto_oid"] ) &&
				( $detalle->getPrecioUnitario() == $detallejson["precioUnitario"] ) ){
				$existe = true;
				$detalle->setCantidad($detalle->getCantidad() + $detallejson["cantidad"]);
				$indexExistente = $index;
			}
			$index++;
		}
		
		$detallejson = array();
		$detallejson["producto_oid"] = $detalle->getProducto()->getOid();
		$detallejson["producto_nombre"] = $detalle->getProducto()->getTipoProducto()->getNombre().' '.$detalle->getProducto()->getMarcaProducto()->getNombre().' '.$detalle->getProducto()->getNombre();
	    $detallejson["precioUnitario"] = $detalle->getPrecioUnitario();
	    $detallejson["cantidad"] = $detalle->getCantidad();
	    $detallejson["subtotal"] = $detalle->getCantidad() * $detalle->getPrecioUnitario();
	        
		if($existe){
	        
			//unset($detalles[$indexExistente]);
        	//$detalles = array_values($detalles);
        	$detalles[$indexExistente]["cantidad"] = $detallejson["cantidad"];
        	$detalles[$indexExistente]["subtotal"] = $detallejson["subtotal"]; 
		}else{
			$detalles[] = $detallejson;
		}
		
		
		
		self::setDetallesPresupuestoSession($detalles);
    }
    
	public static function borrarDetallePresupuestoSession( $index=0 ) {
		
		$detalles = self::getDetallesPresupuestoSession();

		unset($detalles[$index]);
        $detalles = array_values($detalles);
        
		self::setDetallesPresupuestoSession($detalles);
    }
    
    public static function getDetallesPresupuestoSession() {
    
    	$appName = RastyConfig::getInstance()->getAppName();
		
    	$data = RastyUtils::getParamSESSION($appName);
		
		if( isset( $data['detallesPresupuesto_session']) )
			$detalles = unserialize( $data['detallesPresupuesto_session']);
		else 
			$detalles = array();
			
		
			
		return $detalles;
   	}
 
   	public static function setDetallesPresupuestoSession( $detalles ) {
    
    	$appName = RastyConfig::getInstance()->getAppName();
		
		$_SESSION[$appName]['detallesPresupuesto_session'] = serialize($detalles);
			
   	}
   	
	public static function agregarProductoComboSession(ProductoCombo $producto) {
		
		$productos = self::getProductosComboSession();

		//si ya estaba incremento la cantidad
		$existe = false;
		$indexExistente = 0;
		$index = 0;
		foreach ($productos as $productojson) {
			//mismo producto y mismo precio
			if(( $producto->getProducto()->getOid() == $productojson["producto_oid"] ) &&
				( $producto->getPrecioUnitario() == $productojson["precioUnitario"] ) ){
				$existe = true;
				$producto->setCantidad($producto->getCantidad() + $productojson["cantidad"]);
				$indexExistente = $index;
			}
			$index++;
		}
		
		$productojson = array();
		$productojson["producto_oid"] = $producto->getProducto()->getOid();
		$productojson["producto_nombre"] = $producto->getProducto()->getTipoProducto()->getNombre().' '.$producto->getProducto()->getMarcaProducto()->getNombre().' '.$producto->getProducto()->getNombre();
	    $productojson["precioUnitario"] = $producto->getPrecioUnitario();
	    $productojson["cantidad"] = $producto->getCantidad();
	    $productojson["subtotal"] = $producto->getCantidad() * $producto->getPrecioUnitario();
	       
		if($existe){
	        
			//unset($productos[$indexExistente]);
        	//$productos = array_values($productos);
        	$productos[$indexExistente]["cantidad"] = $productojson["cantidad"];
        	$productos[$indexExistente]["subtotal"] = $productojson["subtotal"]; 
        	 
		}else{
			$productos[] = $productojson;
		}
		
		
		
		self::setProductosComboSession($productos);
    }
    
	public static function borrarProductoComboSession( $index=0 ) {
		
		$productos = self::getProductosComboSession();

		unset($productos[$index]);
        $productos = array_values($productos);
        
		self::setProductosComboSession($productos);
    }
    
    public static function getProductosComboSession() {
    
    	$appName = RastyConfig::getInstance()->getAppName();
		
    	$data = RastyUtils::getParamSESSION($appName);
		
		if( isset( $data['productosCombo_session']) )
			$productos = unserialize( $data['productosCombo_session']);
		else 
			$productos = array();
			
		
			
		return $productos;
   	}
 
   	public static function setProductosComboSession( $productos ) {
    
    	$appName = RastyConfig::getInstance()->getAppName();
		
		$_SESSION[$appName]['productosCombo_session'] = serialize($productos);
			
   	}
   	
	public static function array_sort_by(&$arrIni, $col, $order = SORT_ASC) 
	{
	    $arrAux = array();
	    foreach ($arrIni as $key=> $row) 
	    {
	        $arrAux[$key] = is_object($row) ? $arrAux[$key] = $row->$col : $row[$col];
	        $arrAux[$key] = strtolower($arrAux[$key]);
	    }
	    array_multisort($arrAux, $order, $arrIni);
	}
	
	public static function getEstadoPedidoCss($estadoPedido){
		$estilos = array(
						EstadoPedido::Pagado=> "bg-lightGreen fg-black",
						EstadoPedido::Impago=> "bg-yellow fg-black",
						EstadoPedido::Anulado=> "bg-crimson fg-white"
						);
						
		return $estilos[$estadoPedido];
	}
	
	
}
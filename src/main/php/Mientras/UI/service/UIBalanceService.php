<?php
namespace Mientras\UI\service;

use Mientras\UI\utils\MientrasUIUtils;

use Rasty\components\RastyPage;
use Rasty\utils\XTemplate;
use Rasty\i18n\Locale;
use Rasty\exception\RastyException;
use Cose\criteria\impl\Criteria;

use Mientras\Core\service\ServiceFactory;

use Mientras\Core\utils\MientrasUtils;

use Cose\Security\model\User;
use Rasty\security\RastySecurityContext;


/**
 * 
 * UI service para balances.
 * 
 * @author Marcos
 * @since 07-10-2019
 */
class UIBalanceService {
	
	private static $instance;
	
	private function __construct() {}
	
	public static function getInstance() {
		
		if( self::$instance == null ) {
			
			self::$instance = new UIBalanceService();
			
		}
		return self::$instance; 
	}

	public function getBalanceMes( \DateTime $fecha ){

		$totalesVentaMes = UIServiceFactory::getUIVentaService()->getTotalesCuentaMes(null, $fecha);
		$importeVentas = 0;
		foreach ($totalesVentaMes as $total) {
			$importeVentas += $total["total"];
		}
		
		/*$totalesGastoMes = UIServiceFactory::getUIGastoService()->getTotalesCuentaMes(null, $fecha);
		$importeGastos = 0;
		foreach ($totalesGastoMes as $total) {
			$importeGastos += $total["total"];
		}
		
		$totalesPagoPremioMes = UIServiceFactory::getUIPagoPremioService()->getTotalesCuentaMes(null, $fecha);
		$importePagoPremios = 0;
		foreach ($totalesPagoPremioMes as $total) {
			$importePagoPremios += $total["total"];
		}
		
		$totalesComisionMes = UIServiceFactory::getUIInformeDiarioComisionService()->getInformeMes($fecha);
		$importeComisiones = 0;
		foreach ($totalesComisionMes as $total) {
			$importeComisiones += $total["comision"];
		}*/
		
		$meses = MientrasUIUtils::getMeses();
		$mes = $fecha->format("n");
		
		$result = array();
		
		$result["mes"] =  $mes;
		$result["mes_nombre"] =  $meses[$mes] . " " . $fecha->format("Y");
		$result["ventas"] =  $importeVentas;
		/*$result["gastos"] =  $importeGastos;
		$result["pagos"] =  $importePagoPremios;
		$result["comisiones"] =  $importeComisiones;*/
		//$result["ganancia"] =  $importeComisiones + $importeGastos;
		
		return $result;
	}
		
	public function getBalanceAnio( \DateTime $fecha ){

		$balances = array();
		
		$anio = $fecha->format("Y");
		
		$meses = MientrasUIUtils::getMeses();
		
		for ($mes = 1; $mes <=12; $mes++) {
			$balances[$mes] = array( "ventas" => 0,
										"gastos" => 0,
										"pagos" => 0,
										"comisiones" => 0,
										"ganancia" => 0,
										"mes_nombre" => $meses[$mes]);
		}
		
		$totalesVentaAnio = UIServiceFactory::getUIVentaService()->getTotalesCuentaAnioPorMes(null, $anio);
		$importeVentas = 0;
		foreach ($totalesVentaAnio as $total) {
			$importeVentas += $total["total"];
			$balances[$total["mes"]]["ventas"] = $total["total"]; 
		}
		
		/*$totalesGastoAnio = UIServiceFactory::getUIGastoService()->getTotalesCuentaAnioPorMes(null, $anio);
		$importeGastos = 0;
		foreach ($totalesGastoAnio as $total) {
			$importeGastos += $total["total"];
			$balances[$total["mes"]]["gastos"] = $total["total"];
		}
		
		$totalesPagoPremioAnio = UIServiceFactory::getUIPagoPremioService()->getTotalesCuentaAnioPorMes(null, $anio);
		$importePagoPremios = 0;
		foreach ($totalesPagoPremioAnio as $total) {
			$importePagoPremios += $total["total"];
			$balances[$total["mes"]]["pagos"] = $total["total"];
		}
		
		$totalesComisionAnio = UIServiceFactory::getUIInformeDiarioComisionService()->getInformeAnualPorMes($anio);
		$importeComisiones = 0;
		foreach ($totalesComisionAnio as $mes => $total) {
			$importeComisiones += $total["comisiones"];
			$balances[$mes]["comisiones"] = $total["comisiones"];
		}*/
		
		for ($mes = 1; $mes <=12; $mes++) {
			$balances[$mes]["ganancia"] = $balances[$mes]["comisiones"] + $balances[$mes]["gastos"];
		}
		
		
		$result["anio"] =  $fecha->format("Y");
		$result["ventas"] =  $importeVentas;
		/*$result["gastos"] =  $importeGastos;
		$result["pagos"] =  $importePagoPremios;
		$result["comisiones"] =  $importeComisiones;
		$result["ganancia"] =  $importeComisiones + $importeGastos;*/
		$result["detalles"] =  $balances;
		
		return $result;
	}
	
}
?>
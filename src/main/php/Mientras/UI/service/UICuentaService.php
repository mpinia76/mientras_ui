<?php
namespace Mientras\UI\service;

use Mientras\UI\components\filter\model\UICuentaCriteria;

use Mientras\UI\components\filter\model\UIEmpleadoCriteria;

use Rasty\components\RastyPage;
use Rasty\utils\XTemplate;
use Rasty\i18n\Locale;
use Rasty\exception\RastyException;
use Cose\criteria\impl\Criteria;

use Mientras\Core\model\Empleado;
use Mientras\Core\model\Cuenta;
use Mientras\Core\model\Transferencia;
use Mientras\Core\service\ServiceFactory;

use Mientras\Core\utils\MientrasUtils;

use Cose\Security\model\User;
use Rasty\security\RastySecurityContext;


/**
 * 
 * UI service para cuenta.
 * 
 * @author Marcos
 * @since 12/03/2018
 */
class UICuentaService {
	
	private static $instance;
	
	private function __construct() {}
	
	public static function getInstance() {
		
		if( self::$instance == null ) {
			
			self::$instance = new UICuentaService();
			
		}
		return self::$instance; 
	}

	
	
	public function getList( UICuentaCriteria $uiCriteria){

		try{

			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getCuentaService();
			
			$cuentas = $service->getList( $criteria );
	
			return $cuentas;

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			
	}
	
	
	public function get( $oid ){

		try {
			
			$service = ServiceFactory::getCuentaService();
			
			return $service->get( $oid );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
		
	public function getMovimientos( Cuenta $cuenta ){

		try {
			
			$service = ServiceFactory::getMovimientoCuentaService();
			
			$movimientos = $service->getMovimientos( $cuenta );

			return $movimientos;
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}

	public function getCajaChica(){
		
		try {
			
			return MientrasUtils::getCuentaUnica();

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}	
		
	}

	public function getCuentaBAPRO(){
		
		try {
			
			return MientrasUtils::getCuentaBAPRO();

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}	
		
	}
	
	public function transferir(Cuenta $origen, Cuenta $destino, $monto, $observaciones ){

		try{
			
			$user = RastySecurityContext::getUser();
			$user = MientrasUtils::getUserByUsername($user->getUsername());
			
			$transferencia = new Transferencia();
			$transferencia->setOrigen( $origen );
			$transferencia->setDestino( $destino );
			$transferencia->setMonto( $monto );
			$transferencia->setFechaHora( new \Datetime() );
			$transferencia->setObservaciones( $observaciones );
			$transferencia->setUser( $user );
			
			UIServiceFactory::getUITransferenciaService()->add( $transferencia );			
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
		
	}
}
?>
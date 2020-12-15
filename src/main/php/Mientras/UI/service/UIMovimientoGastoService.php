<?php
namespace Mientras\UI\service;

use Mientras\UI\components\filter\model\UIMovimientoGastoCriteria;

use Rasty\components\RastyPage;
use Rasty\utils\XTemplate;
use Rasty\i18n\Locale;
use Rasty\exception\RastyException;
use Cose\criteria\impl\Criteria;

use Mientras\Core\model\Gasto;

use Mientras\Core\service\ServiceFactory;
use Mientras\Core\utils\MientrasUtils;
use Cose\Security\model\User;
use Rasty\Grid\entitygrid\model\IEntityGridService;
use Rasty\Grid\filter\model\UICriteria;

/**
 * 
 * UI service para movimientos de Gasto.
 * 
 * @author Marcos
 * @since 07/04/2018
 */
class UIMovimientoGastoService  implements IEntityGridService{
	
	private static $instance;
	
	private function __construct() {}
	
	public static function getInstance() {
		
		if( self::$instance == null ) {
			
			self::$instance = new UIMovimientoGastoService();
			
		}
		return self::$instance; 
	}

	
	
	public function getList( UIMovimientoGastoCriteria $uiCriteria){

		try{
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getMovimientoGastoService();
			
			$movimientos = $service->getList( $criteria );
	
			return $movimientos;
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	public function get( $oid ){

		try{	

			$service = ServiceFactory::getMovimientoGastoService();
		
			return $service->get( $oid );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			

	}
	

	
	function getEntitiesCount($uiCriteria){

		try{
			
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getMovimientoGastoService();
			$movimientos = $service->getCount( $criteria );
			
			return $movimientos;
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	function getEntities($uiCriteria){
		
		return $this->getList($uiCriteria);
	}
	
	public function getTotalesDia( \Datetime $fecha ){
		
		try {
			
			$service = ServiceFactory::getMovimientoGastoService();
			
			return $service->getTotales(null,$fecha );

		} catch (\Exception $e) {
			
			throw new RastyException( $e->getMessage() );
			
		}
				
	}
	
	function getTotalesUsuarios($uiCriteria){

		try{
			
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getMovimientoGastoService();
			return $service->getTotalesUsuarios($criteria );

		} catch (\Exception $e) {
			
			throw new RastyException( $e->getMessage() );
			
		}
	}
	
}
?>
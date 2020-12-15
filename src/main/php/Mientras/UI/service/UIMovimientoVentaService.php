<?php
namespace Mientras\UI\service;

use Mientras\UI\components\filter\model\UIMovimientoVentaCriteria;

use Rasty\components\RastyPage;
use Rasty\utils\XTemplate;
use Rasty\i18n\Locale;
use Rasty\exception\RastyException;
use Cose\criteria\impl\Criteria;

use Mientras\Core\model\Venta;

use Mientras\Core\service\ServiceFactory;
use Mientras\Core\utils\MientrasUtils;
use Cose\Security\model\User;
use Rasty\Grid\entitygrid\model\IEntityGridService;
use Rasty\Grid\filter\model\UICriteria;

/**
 * 
 * UI service para movimientos de Venta.
 * 
 * @author Marcos
 * @since 07/04/2018
 */
class UIMovimientoVentaService  implements IEntityGridService{
	
	private static $instance;
	
	private function __construct() {}
	
	public static function getInstance() {
		
		if( self::$instance == null ) {
			
			self::$instance = new UIMovimientoVentaService();
			
		}
		return self::$instance; 
	}

	
	
	public function getList( UIMovimientoVentaCriteria $uiCriteria){

		try{
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getMovimientoVentaService();
			
			$movimientos = $service->getList( $criteria );
	
			return $movimientos;
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	public function get( $oid ){

		try{	

			$service = ServiceFactory::getMovimientoVentaService();
		
			return $service->get( $oid );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			

	}
	

	
	function getEntitiesCount($uiCriteria){

		try{
			
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getMovimientoVentaService();
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
			
			$service = ServiceFactory::getMovimientoVentaService();
			
			return $service->getTotales(null,$fecha );

		} catch (\Exception $e) {
			
			throw new RastyException( $e->getMessage() );
			
		}
				
	}
}
?>
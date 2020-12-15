<?php
namespace Mientras\UI\service;

use Mientras\UI\components\filter\model\UIMovimientoPedidoCriteria;

use Rasty\components\RastyPage;
use Rasty\utils\XTemplate;
use Rasty\i18n\Locale;
use Rasty\exception\RastyException;
use Cose\criteria\impl\Criteria;

use Mientras\Core\model\Pedido;

use Mientras\Core\service\ServiceFactory;
use Mientras\Core\utils\MientrasUtils;
use Cose\Security\model\User;
use Rasty\Grid\entitygrid\model\IEntityGridService;
use Rasty\Grid\filter\model\UICriteria;

/**
 * 
 * UI service para movimientos de Pedido.
 * 
 * @author Marcos
 * @since 10/07/2020
 */
class UIMovimientoPedidoService  implements IEntityGridService{
	
	private static $instance;
	
	private function __construct() {}
	
	public static function getInstance() {
		
		if( self::$instance == null ) {
			
			self::$instance = new UIMovimientoPedidoService();
			
		}
		return self::$instance; 
	}

	
	
	public function getList( UIMovimientoPedidoCriteria $uiCriteria){

		try{
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getMovimientoPedidoService();
			
			$movimientos = $service->getList( $criteria );
	
			return $movimientos;
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	public function get( $oid ){

		try{	

			$service = ServiceFactory::getMovimientoPedidoService();
		
			return $service->get( $oid );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			

	}
	

	
	function getEntitiesCount($uiCriteria){

		try{
			
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getMovimientoPedidoService();
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
			
			$service = ServiceFactory::getMovimientoPedidoService();
			
			return $service->getTotales(null,$fecha );

		} catch (\Exception $e) {
			
			throw new RastyException( $e->getMessage() );
			
		}
				
	}
}
?>
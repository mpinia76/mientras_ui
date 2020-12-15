<?php
namespace Mientras\UI\service;

use Mientras\UI\components\filter\model\UITipoProductoCriteria;

use Rasty\components\RastyPage;
use Rasty\utils\XTemplate;
use Rasty\i18n\Locale;
use Rasty\exception\RastyException;
use Cose\criteria\impl\Criteria;

use Mientras\Core\model\TipoProducto;

use Mientras\Core\service\ServiceFactory;
use Cose\Security\model\User;
use Rasty\Grid\entitygrid\model\IEntityGridService;
use Rasty\Grid\filter\model\UICriteria;

/**
 * 
 * UI service para tiposProducto.
 * 
 * @author Marcos
 * @since 05/03/2018
 */
class UITipoProductoService  implements IEntityGridService{
	
	private static $instance;
	
	private function __construct() {}
	
	public static function getInstance() {
		
		if( self::$instance == null ) {
			
			self::$instance = new UITipoProductoService();
			
		}
		return self::$instance; 
	}

	
	
	public function getList( UITipoProductoCriteria $uiCriteria){

		try{
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getTipoProductoService();
			
			$tiposProducto = $service->getList( $criteria );
	
			return $tiposProducto;
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	public function get( $oid ){

		try{	

			$service = ServiceFactory::getTipoProductoService();
		
			return $service->get( $oid );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			

	}
	

	public function add( TipoProducto $tipoProducto ){

		try{

			$service = ServiceFactory::getTipoProductoService();
		
			return $service->add( $tipoProducto );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			

	}
	
	public function update( TipoProducto $tipoProducto ){

		try{

			$service = ServiceFactory::getTipoProductoService();
		
			return $service->update( $tipoProducto );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			

	}
	
	function getEntitiesCount($uiCriteria){

		try{
			
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getTipoProductoService();
			$tiposProducto = $service->getCount( $criteria );
			
			return $tiposProducto;
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	function getEntities($uiCriteria){
		
		return $this->getList($uiCriteria);
	}
	
	
	public function delete(TipoProducto $tipoProducto){

		try {
			
			$service = ServiceFactory::getTipoProductoService();
			
			return $service->delete($tipoProducto->getOid());

		} catch (\Exception $e) {
			
			throw new RastyException( $e->getMessage() );
			
		}
		
	}
}
?>
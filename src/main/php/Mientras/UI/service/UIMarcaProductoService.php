<?php
namespace Mientras\UI\service;

use Mientras\UI\components\filter\model\UIMarcaProductoCriteria;

use Rasty\components\RastyPage;
use Rasty\utils\XTemplate;
use Rasty\i18n\Locale;
use Rasty\exception\RastyException;
use Cose\criteria\impl\Criteria;

use Mientras\Core\model\MarcaProducto;

use Mientras\Core\service\ServiceFactory;
use Cose\Security\model\User;
use Rasty\Grid\entitygrid\model\IEntityGridService;
use Rasty\Grid\filter\model\UICriteria;

/**
 * 
 * UI service para marcasProducto.
 * 
 * @author Marcos
 * @since 05/03/2018
 */
class UIMarcaProductoService  implements IEntityGridService{
	
	private static $instance;
	
	private function __construct() {}
	
	public static function getInstance() {
		
		if( self::$instance == null ) {
			
			self::$instance = new UIMarcaProductoService();
			
		}
		return self::$instance; 
	}

	
	
	public function getList( UIMarcaProductoCriteria $uiCriteria){

		try{
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getMarcaProductoService();
			
			$marcasProducto = $service->getList( $criteria );
	
			return $marcasProducto;
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	public function get( $oid ){

		try{	

			$service = ServiceFactory::getMarcaProductoService();
		
			return $service->get( $oid );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			

	}
	

	public function add( MarcaProducto $marcaProducto ){

		try{

			$service = ServiceFactory::getMarcaProductoService();
		
			return $service->add( $marcaProducto );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			

	}
	
	public function update( MarcaProducto $marcaProducto ){

		try{

			$service = ServiceFactory::getMarcaProductoService();
		
			return $service->update( $marcaProducto );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			

	}
	
	function getEntitiesCount($uiCriteria){

		try{
			
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getMarcaProductoService();
			$marcasProducto = $service->getCount( $criteria );
			
			return $marcasProducto;
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	function getEntities($uiCriteria){
		
		return $this->getList($uiCriteria);
	}
	
	
	public function delete(MarcaProducto $marcaProducto){

		try {
			
			$service = ServiceFactory::getMarcaProductoService();
			
			return $service->delete($marcaProducto->getOid());

		} catch (\Exception $e) {
			
			throw new RastyException( $e->getMessage() );
			
		}
		
	}
}
?>
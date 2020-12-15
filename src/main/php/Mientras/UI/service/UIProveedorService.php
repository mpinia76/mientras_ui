<?php
namespace Mientras\UI\service;

use Mientras\UI\components\filter\model\UIProveedorCriteria;

use Rasty\components\RastyPage;
use Rasty\utils\XTemplate;
use Rasty\i18n\Locale;
use Rasty\exception\RastyException;
use Cose\criteria\impl\Criteria;

use Mientras\Core\model\Proveedor;

use Mientras\Core\service\ServiceFactory;
use Cose\Security\model\User;
use Rasty\Grid\entitygrid\model\IEntityGridService;
use Rasty\Grid\filter\model\UICriteria;

/**
 * 
 * UI service para proveedors.
 * 
 * @author Marcos
 * @since 10/07/2020
 */
class UIProveedorService  implements IEntityGridService{
	
	private static $instance;
	
	private function __construct() {}
	
	public static function getInstance() {
		
		if( self::$instance == null ) {
			
			self::$instance = new UIProveedorService();
			
		}
		return self::$instance; 
	}

	
	
	public function getList( UIProveedorCriteria $uiCriteria){

		try{
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getProveedorService();
			
			$proveedors = $service->getList( $criteria );
	
			return $proveedors;
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	public function get( $oid ){

		try{	

			$service = ServiceFactory::getProveedorService();
		
			return $service->get( $oid );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			

	}
	

	public function add( Proveedor $proveedor ){

		try{

			$service = ServiceFactory::getProveedorService();
		
			return $service->add( $proveedor );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			

	}
	
	public function update( Proveedor $proveedor ){

		try{

			$service = ServiceFactory::getProveedorService();
		
			return $service->update( $proveedor );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			

	}
	
	function getEntitiesCount($uiCriteria){

		try{
			
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getProveedorService();
			$proveedors = $service->getCount( $criteria );
			
			return $proveedors;
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	function getEntities($uiCriteria){
		
		return $this->getList($uiCriteria);
	}
	
	public function delete(Proveedor $proveedor){

		try {
			
			$service = ServiceFactory::getProveedorService();
			
			return $service->delete($proveedor->getOid());

		} catch (\Exception $e) {
			
			throw new RastyException( $e->getMessage() );
			
		}
		
	}
	
	
	
}
?>
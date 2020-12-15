<?php
namespace Mientras\UI\service;

use Mientras\UI\components\filter\model\UIIvaCriteria;

use Rasty\components\RastyPage;
use Rasty\utils\XTemplate;
use Rasty\i18n\Locale;
use Rasty\exception\RastyException;
use Cose\criteria\impl\Criteria;

use Mientras\Core\model\Iva;

use Mientras\Core\service\ServiceFactory;
use Cose\Security\model\User;
use Rasty\Grid\entitygrid\model\IEntityGridService;
use Rasty\Grid\filter\model\UICriteria;

/**
 * 
 * UI service para ivas.
 * 
 * @author Marcos
 * @since 05/03/2018
 */
class UIIvaService  implements IEntityGridService{
	
	private static $instance;
	
	private function __construct() {}
	
	public static function getInstance() {
		
		if( self::$instance == null ) {
			
			self::$instance = new UIIvaService();
			
		}
		return self::$instance; 
	}

	
	
	public function getList( UIIvaCriteria $uiCriteria){

		try{
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getIvaService();
			
			$ivas = $service->getList( $criteria );
	
			return $ivas;
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	public function get( $oid ){

		try{	

			$service = ServiceFactory::getIvaService();
		
			return $service->get( $oid );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			

	}
	

	public function add( Iva $iva ){

		try{

			$service = ServiceFactory::getIvaService();
		
			return $service->add( $iva );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			

	}
	
	public function update( Iva $iva ){

		try{

			$service = ServiceFactory::getIvaService();
		
			return $service->update( $iva );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			

	}
	
	function getEntitiesCount($uiCriteria){

		try{
			
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getIvaService();
			$ivas = $service->getCount( $criteria );
			
			return $ivas;
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	function getEntities($uiCriteria){
		
		return $this->getList($uiCriteria);
	}
	
	
	public function delete(Iva $iva){

		try {
			
			$service = ServiceFactory::getIvaService();
			
			return $service->delete($iva->getOid());

		} catch (\Exception $e) {
			
			throw new RastyException( $e->getMessage() );
			
		}
		
	}
}
?>
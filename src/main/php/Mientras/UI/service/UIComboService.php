<?php
namespace Mientras\UI\service;

use Mientras\UI\components\filter\model\UIComboCriteria;

use Rasty\components\RastyPage;
use Rasty\utils\XTemplate;
use Rasty\i18n\Locale;
use Rasty\exception\RastyException;
use Cose\criteria\impl\Criteria;

use Mientras\Core\model\Combo;


use Mientras\Core\service\ServiceFactory;


use Rasty\Grid\entitygrid\model\IEntityGridService;
use Rasty\Grid\filter\model\UICriteria;

/**
 * 
 * UI service para Combo.
 * 
 * @author Marcos
 * @since 28/08/2019
 */
class UIComboService  implements IEntityGridService{
	
	private static $instance;
	
	private function __construct() {}
	
	public static function getInstance() {
		
		if( self::$instance == null ) {
			
			self::$instance = new UIComboService();
			
		}
		return self::$instance; 
	}

	
	
	public function getList( UIComboCriteria $uiCriteria){

		try{
			
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getComboService();
			
			$combos = $service->getList( $criteria );
	
			return $combos;
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	
	
	public function get( $oid ){

		try{
			
			$service = ServiceFactory::getComboService();
		
			return $service->get( $oid );
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	public function add( Combo $combo ){

		try {
			
			$service = ServiceFactory::getComboService();
			
			return $service->add( $combo );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}

	public function update( Combo $combo ){

		try{

			$service = ServiceFactory::getComboService();
		
			return $service->update( $combo );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			

	}
	
	
	function getEntitiesCount($uiCriteria){

		try{
			
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getComboService();
			$combos = $service->getCount( $criteria );
			
			return $combos;
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	function getEntities($uiCriteria){
		
		return $this->getList($uiCriteria);
	}
	
	public function delete(Combo $combo){

		try {
			
			$service = ServiceFactory::getComboService();
			
			return $service->delete($combo->getOid());

		} catch (\Exception $e) {
			
			throw new RastyException( $e->getMessage() );
			
		}
		
	}
	
}
?>
<?php
namespace Mientras\UI\service;

use Mientras\UI\components\filter\model\UIConceptoGastoCriteria;

use Rasty\components\RastyPage;
use Rasty\utils\XTemplate;
use Rasty\i18n\Locale;
use Rasty\exception\RastyException;
use Cose\criteria\impl\Criteria;

use Mientras\Core\model\ConceptoGasto;

use Mientras\Core\service\ServiceFactory;
use Cose\Security\model\User;
use Rasty\Grid\entitygrid\model\IEntityGridService;
use Rasty\Grid\filter\model\UICriteria;

/**
 * 
 * UI service para conceptoGastos.
 * 
 * @author Marcos
 * @since 12/03/2018
 */
class UIConceptoGastoService  implements IEntityGridService{
	
	private static $instance;
	
	private function __construct() {}
	
	public static function getInstance() {
		
		if( self::$instance == null ) {
			
			self::$instance = new UIConceptoGastoService();
			
		}
		return self::$instance; 
	}

	
	
	public function getList( UIConceptoGastoCriteria $uiCriteria){

		try{
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getConceptoGastoService();
			
			$conceptoGastos = $service->getList( $criteria );
	
			return $conceptoGastos;
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	public function get( $oid ){

		try{	

			$service = ServiceFactory::getConceptoGastoService();
		
			return $service->get( $oid );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			

	}
	

	public function add( ConceptoGasto $conceptoGasto ){

		try{

			$service = ServiceFactory::getConceptoGastoService();
		
			return $service->add( $conceptoGasto );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			

	}
	
	public function update( ConceptoGasto $conceptoGasto ){

		try{

			$service = ServiceFactory::getConceptoGastoService();
		
			return $service->update( $conceptoGasto );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			

	}
	
	function getEntitiesCount($uiCriteria){

		try{
			
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getConceptoGastoService();
			$conceptoGastos = $service->getCount( $criteria );
			
			return $conceptoGastos;
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	function getEntities($uiCriteria){
		
		return $this->getList($uiCriteria);
	}
	
	
	public function delete(ConceptoGasto $conceptoGasto){

		try {
			
			$service = ServiceFactory::getConceptoGastoService();
			
			return $service->delete($conceptoGasto->getOid());

		} catch (\Exception $e) {
			
			throw new RastyException( $e->getMessage() );
			
		}
		
	}
}
?>
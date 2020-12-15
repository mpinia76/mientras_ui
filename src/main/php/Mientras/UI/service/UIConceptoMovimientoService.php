<?php
namespace Mientras\UI\service;

use Mientras\UI\components\filter\model\UIConceptoMovimientoCriteria;

use Rasty\components\RastyPage;
use Rasty\utils\XTemplate;
use Rasty\i18n\Locale;
use Rasty\exception\RastyException;
use Cose\criteria\impl\Criteria;

use Mientras\Core\model\ConceptoMovimiento;

use Mientras\Core\service\ServiceFactory;
use Cose\Security\model\User;
use Rasty\Grid\entitygrid\model\IEntityGridService;
use Rasty\Grid\filter\model\UICriteria;

/**
 * 
 * UI service para conceptoMovimientos.
 * 
 * @author Marcos
 * @since 12/03/2018
 */
class UIConceptoMovimientoService  implements IEntityGridService{
	
	private static $instance;
	
	private function __construct() {}
	
	public static function getInstance() {
		
		if( self::$instance == null ) {
			
			self::$instance = new UIConceptoMovimientoService();
			
		}
		return self::$instance; 
	}

	
	
	public function getList( UIConceptoMovimientoCriteria $uiCriteria){

		try{
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getConceptoMovimientoService();
			
			$conceptoMovimientos = $service->getList( $criteria );
	
			return $conceptoMovimientos;
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	public function get( $oid ){

		try{	

			$service = ServiceFactory::getConceptoMovimientoService();
		
			return $service->get( $oid );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			

	}
	

	public function add( ConceptoMovimiento $conceptoMovimiento ){

		try{

			$service = ServiceFactory::getConceptoMovimientoService();
		
			return $service->add( $conceptoMovimiento );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			

	}
	
	public function update( ConceptoMovimiento $conceptoMovimiento ){

		try{

			$service = ServiceFactory::getConceptoMovimientoService();
		
			return $service->update( $conceptoMovimiento );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			

	}
	
	function getEntitiesCount($uiCriteria){

		try{
			
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getConceptoMovimientoService();
			$conceptoMovimientos = $service->getCount( $criteria );
			
			return $conceptoMovimientos;
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	function getEntities($uiCriteria){
		
		return $this->getList($uiCriteria);
	}
	
	
	public function delete(ConceptoMovimiento $conceptoMovimiento){

		try {
			
			$service = ServiceFactory::getConceptoMovimientoService();
			
			return $service->delete($conceptoMovimiento->getOid());

		} catch (\Exception $e) {
			
			throw new RastyException( $e->getMessage() );
			
		}
		
	}
}
?>
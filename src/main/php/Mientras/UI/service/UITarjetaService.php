<?php
namespace Mientras\UI\service;

use Mientras\UI\components\filter\model\UITarjetaCriteria;

use Rasty\components\RastyPage;
use Rasty\utils\XTemplate;
use Rasty\i18n\Locale;
use Rasty\exception\RastyException;
use Cose\criteria\impl\Criteria;

use Mientras\Core\model\Tarjeta;

use Mientras\Core\service\ServiceFactory;
use Cose\Security\model\User;
use Rasty\Grid\entitygrid\model\IEntityGridService;
use Rasty\Grid\filter\model\UICriteria;

/**
 * 
 * UI service para tarjetas.
 * 
 * @author Marcos
 * @since 28/03/2018
 */
class UITarjetaService  implements IEntityGridService{
	
	private static $instance;
	
	private function __construct() {}
	
	public static function getInstance() {
		
		if( self::$instance == null ) {
			
			self::$instance = new UITarjetaService();
			
		}
		return self::$instance; 
	}

	
	public function getByCriteria( UITarjetaCriteria $uiCriteria){

		try{
			
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getTarjetaService();
			
			$tarjeta = $service->getSingleResult( $criteria );
	
			return $tarjeta;
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	
	public function getList( UITarjetaCriteria $uiCriteria){

		try{
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getTarjetaService();
			
			$tarjetas = $service->getList( $criteria );
	
			return $tarjetas;
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	public function get( $oid ){

		try{	

			$service = ServiceFactory::getTarjetaService();
		
			return $service->get( $oid );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			

	}
	

	public function add( Tarjeta $tarjeta ){

		try{

			$service = ServiceFactory::getTarjetaService();
		
			return $service->add( $tarjeta );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			

	}
	
	public function update( Tarjeta $tarjeta ){

		try{

			$service = ServiceFactory::getTarjetaService();
		
			return $service->update( $tarjeta );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			

	}
	
	function getEntitiesCount($uiCriteria){

		try{
			
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getTarjetaService();
			$tarjetas = $service->getCount( $criteria );
			
			return $tarjetas;
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	function getEntities($uiCriteria){
		
		return $this->getList($uiCriteria);
	}
	
	
	public function delete(Tarjeta $tarjeta){

		try {
			
			$service = ServiceFactory::getTarjetaService();
			
			return $service->delete($tarjeta->getOid());

		} catch (\Exception $e) {
			
			throw new RastyException( $e->getMessage() );
			
		}
		
	}
}
?>
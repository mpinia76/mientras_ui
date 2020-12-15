<?php
namespace Mientras\UI\service;

use Mientras\UI\components\filter\model\UIParametroCriteria;

use Rasty\components\RastyPage;
use Rasty\utils\XTemplate;
use Rasty\i18n\Locale;
use Rasty\exception\RastyException;
use Cose\criteria\impl\Criteria;

use Mientras\Core\model\Parametro;

use Mientras\Core\service\ServiceFactory;
use Cose\Security\model\User;
use Rasty\Grid\entitygrid\model\IEntityGridService;
use Rasty\Grid\filter\model\UICriteria;

/**
 * 
 * UI service para parametros.
 * 
 * @author Marcos
 * @since 16/07/2018
 */
class UIParametroService  implements IEntityGridService{
	
	private static $instance;
	
	private function __construct() {}
	
	public static function getInstance() {
		
		if( self::$instance == null ) {
			
			self::$instance = new UIParametroService();
			
		}
		return self::$instance; 
	}

	
	
	public function getList( UIParametroCriteria $uiCriteria){

		try{
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getParametroService();
			
			$parametros = $service->getList( $criteria );
	
			return $parametros;
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	public function get( $oid ){

		try{	

			$service = ServiceFactory::getParametroService();
		
			return $service->get( $oid );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			

	}
	

	public function add( Parametro $parametro ){

		try{

			$service = ServiceFactory::getParametroService();
		
			return $service->add( $parametro );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			

	}
	
	public function update( Parametro $parametro ){

		try{

			$service = ServiceFactory::getParametroService();
		
			return $service->update( $parametro );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			

	}
	
	function getEntitiesCount($uiCriteria){

		try{
			
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getParametroService();
			$parametros = $service->getCount( $criteria );
			
			return $parametros;
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	function getEntities($uiCriteria){
		
		return $this->getList($uiCriteria);
	}
	
	
	public function delete(Parametro $parametro){

		try {
			
			$service = ServiceFactory::getParametroService();
			
			return $service->delete($parametro->getOid());

		} catch (\Exception $e) {
			
			throw new RastyException( $e->getMessage() );
			
		}
		
	}
}
?>
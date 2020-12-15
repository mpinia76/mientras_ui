<?php
namespace Mientras\UI\service;

use Mientras\UI\components\filter\model\UIClienteCriteria;

use Rasty\components\RastyPage;
use Rasty\utils\XTemplate;
use Rasty\i18n\Locale;
use Rasty\exception\RastyException;
use Cose\criteria\impl\Criteria;

use Mientras\Core\model\Cliente;

use Mientras\Core\service\ServiceFactory;
use Cose\Security\model\User;
use Rasty\Grid\entitygrid\model\IEntityGridService;
use Rasty\Grid\filter\model\UICriteria;

/**
 * 
 * UI service para clientes.
 * 
 * @author Marcos
 * @since 02/03/2018
 */
class UIClienteService  implements IEntityGridService{
	
	private static $instance;
	
	private function __construct() {}
	
	public static function getInstance() {
		
		if( self::$instance == null ) {
			
			self::$instance = new UIClienteService();
			
		}
		return self::$instance; 
	}

	
	
	public function getList( UIClienteCriteria $uiCriteria){

		try{
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getClienteService();
			
			$clientes = $service->getList( $criteria );
	
			return $clientes;
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	public function get( $oid ){

		try{	

			$service = ServiceFactory::getClienteService();
		
			return $service->get( $oid );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			

	}
	

	public function add( Cliente $cliente ){

		try{

			$service = ServiceFactory::getClienteService();
		
			return $service->add( $cliente );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			

	}
	
	public function update( Cliente $cliente ){

		try{

			$service = ServiceFactory::getClienteService();
		
			return $service->update( $cliente );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}			

	}
	
	function getEntitiesCount($uiCriteria){

		try{
			
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getClienteService();
			$clientes = $service->getCount( $criteria );
			
			return $clientes;
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	function getEntities($uiCriteria){
		
		return $this->getList($uiCriteria);
	}
	
	public function delete(Cliente $cliente){

		try {
			
			$service = ServiceFactory::getClienteService();
			
			return $service->delete($cliente->getOid());

		} catch (\Exception $e) {
			
			throw new RastyException( $e->getMessage() );
			
		}
		
	}
	
	public function getTotalCtaCte( UIClienteCriteria $uiCriteria){

		try{
			
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getClienteService();
			
			$clientes = $service->getList( $criteria );
	
			$saldo = 0;
            foreach ($clientes as $cliente) {
            	
            		$saldo += $cliente->getSaldo();
            	
            }
            return $saldo;
            
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
}
?>
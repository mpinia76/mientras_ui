<?php
namespace Mientras\UI\service;

use Mientras\UI\components\filter\model\UIPedidoCriteria;

use Rasty\components\RastyPage;
use Rasty\utils\XTemplate;
use Rasty\i18n\Locale;
use Rasty\exception\RastyException;
use Cose\criteria\impl\Criteria;

use Mientras\Core\model\Pedido;
use Mientras\Core\model\EstadoPedido;
use Mientras\Core\model\Cuenta;

use Mientras\Core\service\ServiceFactory;
use Cose\Security\model\User;

use Rasty\Grid\entitygrid\model\IEntityGridService;
use Rasty\Grid\filter\model\UICriteria;

/**
 * 
 * UI service para Pedido.
 * 
 * @author Marcos
 * @since 10-07-2020
 */
class UIPedidoService  implements IEntityGridService{
	
	private static $instance;
	
	private function __construct() {}
	
	public static function getInstance() {
		
		if( self::$instance == null ) {
			
			self::$instance = new UIPedidoService();
			
		}
		return self::$instance; 
	}

	
	
	public function getList( UIPedidoCriteria $uiCriteria){

		try{
			
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getPedidoService();
			
			$pedidos = $service->getList( $criteria );
	
			return $pedidos;
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	
	public function get( $oid ){

		try{
			
			$service = ServiceFactory::getPedidoService();
		
			return $service->get( $oid );
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	public function add( Pedido $pedido ){

		try {
			
			$service = ServiceFactory::getPedidoService();
			
			return $service->add( $pedido );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}


	function getEntitiesCount($uiCriteria){

		try{
			
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getPedidoService();
			$pedidos = $service->getCount( $criteria );
			
			return $pedidos;
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	function getEntities($uiCriteria){
		
		return $this->getList($uiCriteria);
	}
	
	
	public function pagar(Pedido $pedido, Cuenta $cuenta, User $user){

		try {
			
			$service = ServiceFactory::getPedidoService();
			
			return $service->pagar($pedido, $cuenta, $user);

		} catch (\Exception $e) {
			
			throw new RastyException( $e->getMessage() );
			
		}
		
	}

	
	public function anular(Pedido $pedido, User $user){

		try {
			
			$service = ServiceFactory::getPedidoService();
			
			return $service->anular($pedido, $user);

		} catch (\Exception $e) {
			
			throw new RastyException( $e->getMessage() );
			
		}
		
	}

	public function recibir(Pedido $pedido, User $user){

		try {
			
			$service = ServiceFactory::getPedidoService();
			
			return $service->recibir($pedido, $user);

		} catch (\Exception $e) {
			
			throw new RastyException( $e->getMessage() );
			
		}
		
	}
	
	public function anularRecibir(Pedido $pedido, User $user){

		try {
			
			$service = ServiceFactory::getPedidoService();
			
			return $service->anularRecibir($pedido, $user);

		} catch (\Exception $e) {
			
			throw new RastyException( $e->getMessage() );
			
		}
		
	}
	
	public function getPendientes(){
		
		$uiCriteria = new UIPedidoCriteria();
		$uiCriteria->setRecibido(2);
		$uiCriteria->setEstadoPedidoNotEqual( EstadoPedido::Anulado );
		return $this->getList($uiCriteria);
	}
	
	public function getTotalPendientes(){
		
		$uiCriteria = new UIPedidoCriteria();
		$uiCriteria->setRecibido(2);
		$uiCriteria->setEstadoPedidoNotEqual( EstadoPedido::Anulado );
		return $this->getEntitiesCount($uiCriteria);
	}


	public function getTotalesCuenta( Cuenta $cuenta=null, \DateTime $fecha=null ){

		try {
			
			$service = ServiceFactory::getMovimientoPedidoService();
			
			$totales = $service->getTotales( $cuenta, $fecha );

			return $totales;
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
}
?>
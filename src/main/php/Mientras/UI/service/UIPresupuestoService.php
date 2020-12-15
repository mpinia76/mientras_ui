<?php
namespace Mientras\UI\service;

use Mientras\UI\components\filter\model\UIPresupuestoCriteria;

use Rasty\components\RastyPage;
use Rasty\utils\XTemplate;
use Rasty\i18n\Locale;
use Rasty\exception\RastyException;
use Cose\criteria\impl\Criteria;

use Mientras\Core\model\Presupuesto;
use Mientras\Core\model\Cuenta;
use Mientras\Core\model\Caja;

use Mientras\Core\service\ServiceFactory;
use Cose\Security\model\User;

use Rasty\Grid\entitygrid\model\IEntityGridService;
use Rasty\Grid\filter\model\UICriteria;

/**
 * 
 * UI service para Presupuesto.
 * 
 * @author Marcos
 * @since 29/03/2019
 */
class UIPresupuestoService  implements IEntityGridService{
	
	private static $instance;
	
	private function __construct() {}
	
	public static function getInstance() {
		
		if( self::$instance == null ) {
			
			self::$instance = new UIPresupuestoService();
			
		}
		return self::$instance; 
	}

	
	
	public function getList( UIPresupuestoCriteria $uiCriteria){

		try{
			
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getPresupuestoService();
			
			$presupuestos = $service->getList( $criteria );
	
			return $presupuestos;
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	public function getTotales( UIPresupuestoCriteria $uiCriteria){

		try{
			
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			//$criteria->addOrder("fechaHora", "ASC");
			
			$service = ServiceFactory::getPresupuestoService();
			
			$presupuestos = $service->getList( $criteria );
	
			$saldo = 0;
            foreach ($presupuestos as $presupuesto) {
            	if($presupuesto->podesAnularte()){
            		$saldo += $presupuesto->getMonto();
            	}
            }
            return $saldo;
            
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	public function get( $oid ){

		try{
			
			$service = ServiceFactory::getPresupuestoService();
		
			return $service->get( $oid );
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	public function add( Presupuesto $presupuesto ){

		try {
			
			$service = ServiceFactory::getPresupuestoService();
			
			return $service->add( $presupuesto );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}


	function getEntitiesCount($uiCriteria){

		try{
			
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getPresupuestoService();
			$presupuestos = $service->getCount( $criteria );
			
			return $presupuestos;
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	function getEntities($uiCriteria){
		
		return $this->getList($uiCriteria);
	}
	
	
	public function aprobar(Presupuesto $presupuesto, User $user){

		try {
			
			$service = ServiceFactory::getPresupuestoService();
			
			return $service->aprobar($presupuesto, $user);

		} catch (\Exception $e) {
			
			throw new RastyException( $e->getMessage() );
			
		}
		
	}

	
	public function anular(Presupuesto $presupuesto, User $user){

		try {
			
			$service = ServiceFactory::getPresupuestoService();
			
			return $service->anular($presupuesto, $user);

		} catch (\Exception $e) {
			
			throw new RastyException( $e->getMessage() );
			
		}
		
	}

	

	public function getTotalesDia( \Datetime $fecha ){
		
		try {
			
			$service = ServiceFactory::getPresupuestoService();
			
			return $service->getTotalesDia( $fecha );

		} catch (\Exception $e) {
			
			throw new RastyException( $e->getMessage() );
			
		}
				
	}
	
	public function getTotalesMes( \Datetime $fecha ){
		
		
		try {
			
			$service = ServiceFactory::getPresupuestoService();
			
			return $service->getTotalesMes( $fecha );

		} catch (\Exception $e) {
			
			throw new RastyException( $e->getMessage() );
			
		}
				
	}


	
}
?>
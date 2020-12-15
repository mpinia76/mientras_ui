<?php
namespace Mientras\UI\service;

use Mientras\UI\components\filter\model\UIVentaCriteria;
use Mientras\UI\components\filter\model\UIProductoCriteria;

use Rasty\components\RastyPage;
use Rasty\utils\XTemplate;
use Rasty\i18n\Locale;
use Rasty\exception\RastyException;
use Cose\criteria\impl\Criteria;

use Mientras\Core\model\Venta;
use Mientras\Core\model\Cuenta;
use Mientras\Core\model\Caja;

use Mientras\Core\service\ServiceFactory;
use Cose\Security\model\User;

use Rasty\Grid\entitygrid\model\IEntityGridService;
use Rasty\Grid\filter\model\UICriteria;

use Rasty\utils\Logger;

/**
 * 
 * UI service para Venta.
 * 
 * @author Marcos
 * @since 13/03/2018
 */
class UIVentaService  implements IEntityGridService{
	
	private static $instance;
	
	private function __construct() {}
	
	public static function getInstance() {
		
		if( self::$instance == null ) {
			
			self::$instance = new UIVentaService();
			
		}
		return self::$instance; 
	}

	
	
	public function getList( UIVentaCriteria $uiCriteria){

		try{
			
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getVentaService();
			
			$ventas = $service->getList( $criteria );
	
			return $ventas;
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	public function getTotales( UIVentaCriteria $uiCriteria){

		try{
			
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			//$criteria->addOrder("fechaHora", "ASC");
			
			$service = ServiceFactory::getVentaService();
			
			$ventas = $service->getList( $criteria );
	
			$saldo = 0;
            foreach ($ventas as $venta) {
            	if($venta->podesAnularte()){
            		$saldo += $venta->getMontoPagado();
            	}
            }
            return $saldo;
            
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	public function getGanancias( UIVentaCriteria $uiCriteria){

		try{
			
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			//$criteria->addOrder("fechaHora", "ASC");
			
			$service = ServiceFactory::getVentaService();
			
			$ventas = $service->getList( $criteria );
			
			$saldo = 0;
            foreach ($ventas as $venta) {
            	
            	if($venta->podesAnularte()){
            		$saldo += $venta->getGanancia();
            	}
            }
            return $saldo;
            
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	public function getGananciasProducto( UIVentaCriteria $uiCriteria, UIProductoCriteria $uiProductoCriteria){

		$saldo=array();
		try{
			
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			//$criteria->addOrder("fechaHora", "ASC");
			
			$service = ServiceFactory::getVentaService();
			
			$ventas = $service->getList( $criteria );
			
			$saldo['ganancias'] = 0;
			$saldo['ventas'] = 0;
			$saldo['productos']['ventas'] = array();
			$saldo['productos']['costo'] = array();
			$saldo['productos']['cant'] = array();
			$saldo['productos']['nombre'] = array();
			$saldo['clientes']['cant'] = array();
			$saldo['clientes']['cliente'] = array();
			
			$productosProcesados=array();
			$clienteProductosProcesados=array();
            foreach ($ventas as $venta) {
            	
            	if($venta->podesAnularte()){
            		
            		if (($uiProductoCriteria->getNombre())||($uiProductoCriteria->getTipoProducto())||($uiProductoCriteria->getMarcaProducto())) {
            			$oProductos = UIServiceFactory::getUIProductoService()->getList( $uiProductoCriteria );
            			foreach ($oProductos as $oProducto) {
	            			foreach ($venta->getDetalles() as $detalle) {
	            				//logger::log('Detalle: '.$detalle->getProducto()->getOid().' - '.$oProducto->getOid());
	            				if($detalle->getProducto()->getOid()==$oProducto->getOid()){
	            					$totalVenta=$detalle->getPrecioUnitario()*$detalle->getCantidad();
	            					$costo=$detalle->getCosto()*$detalle->getCantidad();
	            					$saldo['ventas'] += $totalVenta;
	            					$saldo['ganancias'] += $totalVenta-$costo;
	            					
	            					
	            					if (in_array($detalle->getProducto()->getOid(), $productosProcesados)) {
	            						$saldo['productos']['ventas'][$detalle->getProducto()->getOid()] += $totalVenta;
		            					$saldo['productos']['costo'][$detalle->getProducto()->getOid()] += $costo;
		            					$saldo['productos']['cant'][$detalle->getProducto()->getOid()] += $detalle->getCantidad();
	            					}
	            					else{
	            						$saldo['productos']['ventas'][$detalle->getProducto()->getOid()] = $totalVenta;
	            						$saldo['productos']['costo'][$detalle->getProducto()->getOid()] = $costo;
	            						$saldo['productos']['cant'][$detalle->getProducto()->getOid()] = $detalle->getCantidad();
	            					}
	            					$productosProcesados[]=$detalle->getProducto()->getOid();
	            					
	            					
	            					$saldo['productos']['nombre'][$detalle->getProducto()->getOid()] = $detalle->getProducto()->getMarcaProducto()->getNombre().' '.$detalle->getProducto()->getNombre();
	            					
	            					if (in_array($venta->getCliente()->getOid().'-'.$detalle->getProducto()->getOid(), $clienteProductosProcesados)) {
	            						
		            					$saldo['clientes']['cant'][$venta->getCliente()->getOid().'-'.$detalle->getProducto()->getOid()] += $detalle->getCantidad();
	            					}
	            					else{
	            						
	            						$saldo['clientes']['cant'][$venta->getCliente()->getOid().'-'.$detalle->getProducto()->getOid()] = $detalle->getCantidad();
	            					}
	            					$clienteProductosProcesados[]=$venta->getCliente()->getOid().'-'.$detalle->getProducto()->getOid();
	            					
	            					$saldo['clientes']['cliente'][$venta->getCliente()->getOid()] = $venta->getCliente()->getNombre();
	            				}
	            				
	            			}
            				foreach ($venta->getDevoluciones() as $devolucion) {
            					//logger::log('Devolucion: '.$devolucion->getProducto()->getOid().' - '.$oProducto->getOid());
	            				if($devolucion->getProducto()->getOid()==$oProducto->getOid()){
	            					//logger::log($devolucion->getProducto()->getOid().' - '.$oProducto->getOid());
	            					$totalVenta=$devolucion->getPrecioUnitario()*$devolucion->getCantidad();
	            					$costo=$devolucion->getCosto()*$devolucion->getCantidad();
	            					$saldo['ventas'] -= $totalVenta;
	            					$saldo['ganancias'] -= $totalVenta-$costo;
	            					
	            					if (in_array($devolucion->getProducto()->getOid(), $productosProcesados)) {
	            						$saldo['productos']['ventas'][$devolucion->getProducto()->getOid()] -= $totalVenta;
		            					$saldo['productos']['costo'][$devolucion->getProducto()->getOid()] -= $costo;
		            					$saldo['productos']['cant'][$devolucion->getProducto()->getOid()] -= $devolucion->getCantidad();
	            					}
	            					else{
	            						$saldo['productos']['ventas'][$devolucion->getProducto()->getOid()] = -$totalVenta;
	            						$saldo['productos']['costo'][$devolucion->getProducto()->getOid()] = -$costo;
	            						$saldo['productos']['cant'][$devolucion->getProducto()->getOid()] = -$devolucion->getCantidad();
	            					}
	            					$productosProcesados[]=$devolucion->getProducto()->getOid();
	            					
	            					
	            					$saldo['productos']['nombre'][$devolucion->getProducto()->getOid()] = $devolucion->getProducto()->getMarcaProducto()->getNombre().' '.$devolucion->getProducto()->getNombre();
	            					//Logger::logObject($clienteProductosProcesados);
	            					if (in_array($venta->getCliente()->getOid().'-'.$devolucion->getProducto()->getOid(), $clienteProductosProcesados)) {
	            						
		            					$saldo['clientes']['cant'][$venta->getCliente()->getOid().'-'.$devolucion->getProducto()->getOid()] -= $devolucion->getCantidad();
	            					}
	            					else{
	            						
	            						$saldo['clientes']['cant'][$venta->getCliente()->getOid().'-'.$devolucion->getProducto()->getOid()] = -$devolucion->getCantidad();
	            					}
	            					$clienteProductosProcesados[]=$venta->getCliente()->getOid().'-'.$devolucion->getProducto()->getOid();
	            					
	            					$saldo['clientes']['cliente'][$venta->getCliente()->getOid()] = $venta->getCliente()->getNombre();
	            					
	            				}
	            				
	            			}
            			}
            			
            		}
            		else{
            			$saldo['ganancias'] += $venta->getGanancia();
            			$saldo['ventas'] += $venta->getMontoPagado();
            		}
            		
            	}
            }
            
            ksort($saldo['clientes']['cant']);
            return $saldo;
            
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	public function get( $oid ){

		try{
			
			$service = ServiceFactory::getVentaService();
		
			return $service->get( $oid );
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	public function add( Venta $venta ){

		try {
			
			$service = ServiceFactory::getVentaService();
			
			return $service->add( $venta );

		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}


	function getEntitiesCount($uiCriteria){

		try{
			
			$criteria = $uiCriteria->buildCoreCriteria() ;
			
			$service = ServiceFactory::getVentaService();
			$ventas = $service->getCount( $criteria );
			
			return $ventas;
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	function getEntities($uiCriteria){
		
		return $this->getList($uiCriteria);
	}
	
	
	public function cobrar(Venta $venta, Cuenta $cuenta, User $user, $monto, $montoActualizado){

		try {
			
			$service = ServiceFactory::getVentaService();
			
			return $service->cobrar($venta, $cuenta, $user, $monto, $montoActualizado);

		} catch (\Exception $e) {
			
			throw new RastyException( $e->getMessage() );
			
		}
		
	}
	
	public function agregarProducto(Venta $venta, Cuenta $cuenta,User $user){

		try {
			
			$service = ServiceFactory::getVentaService();
			
			return $service->agregarProducto($venta, $cuenta, $user);

		} catch (\Exception $e) {
			
			throw new RastyException( $e->getMessage() );
			
		}
		
	}

	public function devolver(Venta $venta, Cuenta $cuenta,User $user){

		try {
			
			$service = ServiceFactory::getVentaService();
			
			return $service->devolver($venta, $cuenta, $user);

		} catch (\Exception $e) {
			
			throw new RastyException( $e->getMessage() );
			
		}
		
	}
	
	public function anular(Venta $venta, User $user){

		try {
			
			$service = ServiceFactory::getVentaService();
			
			return $service->anular($venta, $user);

		} catch (\Exception $e) {
			
			throw new RastyException( $e->getMessage() );
			
		}
		
	}

	public function cobrarCtaCte(Venta $venta, User $user, $monto, $montoActualizado){

		try {
			
			$service = ServiceFactory::getVentaService();
			
			return $service->cobrarCtaCte($venta, $user, $monto, $montoActualizado);

		} catch (\Exception $e) {
			
			throw new RastyException( $e->getMessage() );
			
		}
		
	}

	public function getTotalesDia( \Datetime $fecha ){
		
		try {
			
			$service = ServiceFactory::getVentaService();
			
			return $service->getTotalesDia( $fecha );

		} catch (\Exception $e) {
			
			throw new RastyException( $e->getMessage() );
			
		}
				
	}
	
	public function getTotalesMes( \Datetime $fecha ){
		
		
		try {
			
			$service = ServiceFactory::getVentaService();
			
			return $service->getTotalesMes( $fecha );

		} catch (\Exception $e) {
			
			throw new RastyException( $e->getMessage() );
			
		}
				
	}


	public function getTotalesCajaVentasOnlineCtaCte( Caja $caja ){

		try {
			
			$service = ServiceFactory::getMovimientoVentaService();
			
			$totales = $service->getTotalesCajaVentasOnlineCtaCte( $caja );

			return $totales;
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	
	public function getTotalesCuenta( Cuenta $cuenta=null, \DateTime $fecha=null ){

		try {
			
			$service = ServiceFactory::getMovimientoVentaService();
			
			$totales = $service->getTotales( $cuenta, $fecha );
			
			

			return $totales;
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	public function getTotalesPagosCtaCte( Cuenta $cuenta=null, \DateTime $fecha=null ){

		try {
			
			$service = ServiceFactory::getMovimientoPagoService();
			
			$totales = $service->getTotales( $cuenta, $fecha );
			
			

			return $totales;
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	public function getTotalesCuentaMes( Cuenta $cuenta=null, \DateTime $fecha=null ){

		try {
			
			$service = ServiceFactory::getMovimientoVentaService();
			
			$totales = $service->getTotalesMes( $cuenta, $fecha );

			return $totales;
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	public function getTotalesCuentaAnioPorMes( Cuenta $cuenta=null, $anio ){

		try {
			
			$service = ServiceFactory::getMovimientoVentaService();
			
			$totales = $service->getTotalesAnioPorMes( $cuenta, $anio );

			return $totales;
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	public function getTotalesCuentaPorCategoria( Cuenta $cuenta=null, \DateTime $fecha=null ){

		try {
			
			$service = ServiceFactory::getMovimientoVentaService();
			
			$totales = $service->getTotalesPorCategoria( $cuenta, $fecha );

			return $totales;
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
}
?>
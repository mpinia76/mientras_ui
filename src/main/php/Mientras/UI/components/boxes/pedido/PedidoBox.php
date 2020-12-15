<?php

namespace Mientras\UI\components\boxes\pedido;

use Mientras\UI\utils\MientrasUIUtils;

use Mientras\UI\service\UIServiceFactory;

use Rasty\components\RastyComponent;
use Rasty\utils\RastyUtils;

use Rasty\utils\XTemplate;

use Mientras\Core\model\Pedido;
use Mientras\Core\model\EstadoPedido;

use Rasty\utils\LinkBuilder;

/**
 * pedido.
 * 
 * @author Marcos
 * @since 10-07-2020
 */
class PedidoBox extends RastyComponent{
		
	private $pedido;
	
	public function getType(){
		
		return "PedidoBox";
		
	}

	public function __construct(){
		
		
	}

	protected function parseLabels(XTemplate $xtpl){
		
		$xtpl->assign("lbl_fechaHora",  $this->localize( "pedido.fechaHora" ) );
		
		$xtpl->assign("lbl_proveedor",  $this->localize( "pedido.proveedor" ) );
		$xtpl->assign("lbl_observaciones",  $this->localize( "pedido.observaciones" ) );
		$xtpl->assign("lbl_monto",  $this->localize( "pedido.monto" ) );
		$xtpl->assign("lbl_estado",  $this->localize( "pedido.estado" ) );
		$xtpl->assign("lbl_recibido",  $this->localize( "pedido.recibido" ) );
		
		$xtpl->assign("lbl_detalle_nombre", $this->localize( "pedido.detalle.producto" ) );
		$xtpl->assign("lbl_detalle_precio", $this->localize( "pedido.detalle.precio" ) );
		$xtpl->assign("lbl_detalle_cantidad", $this->localize( "pedido.detalle.cantidad" ) );
		$xtpl->assign("lbl_detalle_subtotal", $this->localize( "pedido.detalle.subtotal" ) );
		
		$xtpl->assign("lbl_totales",  $this->localize( "pedido.detalles.totales" ) );
	}
	
	protected function parseXTemplate(XTemplate $xtpl){
		
		/*labels*/
		$this->parseLabels($xtpl);
		
		$pedido = $this->getPedido();
		
			
		$xtpl->assign( "proveedor", $this->getPedido()->getProveedor() );
		
		$xtpl->assign( "monto", MientrasUIUtils::formatMontoToView( $pedido->getMonto() ) );
		$xtpl->assign( "observaciones", $this->getPedido()->getObservaciones() );
		$xtpl->assign( "fechaHora", MientrasUIUtils::formatDateTimeToView($this->getPedido()->getFechaHora()) );

		$xtpl->assign( "estado", $this->localize( EstadoPedido::getLabel( $pedido->getEstado()) ) );
		
		if( $pedido->isRecibido() ){
			$recibido = MientrasUIUtils::formatDateTimeToView($this->getPedido()->getFechaHoraRecibido());
			$recibido .= " - " . $pedido->getUserRecibio();  
			$xtpl->assign( "recibido", $recibido );
			
		}
		
		$cantidadTotal = 0;
		foreach ($pedido->getDetalles() as $detalle) {
			$xtpl->assign( "producto", $detalle->getProducto() );
			$xtpl->assign( "cantidad", $detalle->getCantidad() );
			$xtpl->assign( "precio", MientrasUIUtils::formatMontoToView( $detalle->getPrecioUnitario() ) );
			$xtpl->assign( "subtotal", MientrasUIUtils::formatMontoToView( $detalle->getSubtotal() ) );
			$xtpl->parse( "main.detalle" );
			
			$cantidadTotal += $detalle->getCantidad();
		}
		
		$xtpl->assign( "total", MientrasUIUtils::formatMontoToView( $pedido->getMonto() ) );
		$xtpl->assign( "cantidad_total", $cantidadTotal );	
		
	}
	
	
	protected function initObserverEventType(){
		$this->addEventType( "Pedido" );
	}
	
	public function setPedidoOid($oid){
		if( !empty($oid) ){
			$pedido = UIServiceFactory::getUIPedidoService()->get($oid);
			$this->setPedido($pedido);
		}
	}   
    

	public function getPedido()
	{
	    return $this->pedido;
	}

	public function setPedido($pedido)
	{
	    $this->pedido = $pedido;
	}
}
?>
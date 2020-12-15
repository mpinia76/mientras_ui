<?php

namespace Mientras\UI\components\boxes\venta;

use Mientras\UI\utils\MientrasUIUtils;

use Mientras\UI\service\UIServiceFactory;

use Rasty\components\RastyComponent;
use Rasty\utils\RastyUtils;

use Rasty\utils\XTemplate;

use Mientras\Core\model\Venta;
use Mientras\Core\model\EstadoVenta;

use Rasty\utils\LinkBuilder;

use Rasty\utils\Logger;

/**
 * venta.
 * 
 * @author Marcos
 * @since 28-04-2019
 */
class VentaSinDevolucionesBox extends RastyComponent{
		
	private $venta;
	
	public function getType(){
		
		return "VentaSinDevolucionesBox";
		
	}

	public function __construct(){
		
		
	}

	protected function parseLabels(XTemplate $xtpl){
		
		$xtpl->assign("lbl_fecha",  $this->localize( "venta.fecha" ) );
		
		$xtpl->assign("lbl_cliente",  $this->localize( "venta.cliente" ) );
		$xtpl->assign("lbl_observaciones",  $this->localize( "venta.observaciones" ) );
		$xtpl->assign("lbl_monto",  $this->localize( "venta.monto" ) );
		$xtpl->assign("lbl_montoPagado",  $this->localize( "venta.montoPagado" ) );
		$xtpl->assign("lbl_montoDebe",  $this->localize( "venta.montoDebe" ) );
		$xtpl->assign("lbl_estado",  $this->localize( "venta.estado" ) );
		
		$xtpl->assign("lbl_detalle_nombre", $this->localize( "venta.detalle.producto" ) );
		$xtpl->assign("lbl_detalle_precio", $this->localize( "venta.detalle.precio" ) );
		$xtpl->assign("lbl_detalle_cantidad", $this->localize( "venta.detalle.cantidad" ) );
		$xtpl->assign("lbl_detalle_subtotal", $this->localize( "venta.detalle.subtotal" ) );
		
		$xtpl->assign("lbl_totales",  $this->localize( "venta.detalles.totales" ) );
	}
	
	protected function parseXTemplate(XTemplate $xtpl){
		
		/*labels*/
		$this->parseLabels($xtpl);
		
		$venta = $this->getVenta();
		
			
		
		$xtpl->assign( "cliente", $this->getVenta()->getCliente() );
		
		$xtpl->assign( "monto", MientrasUIUtils::formatMontoToView( $this->getVenta()->getMonto() ) );
		$xtpl->assign( "montoPagado", MientrasUIUtils::formatMontoToView( $this->getVenta()->getMontoPagado() ) );
		$xtpl->assign( "montoDebe", MientrasUIUtils::formatMontoToView( $this->getVenta()->getMontoDebe() ) );
		$xtpl->assign( "montoTotal", $this->getVenta()->getMontoDebe() );
		
		$xtpl->assign( "observaciones", $this->getVenta()->getObservaciones() );
		$xtpl->assign( "fecha", MientrasUIUtils::formatDateTimeToView($this->getVenta()->getFecha()) );
		$xtpl->assign( "estado", $this->localize( EstadoVenta::getLabel( $venta->getEstado()) ) );
		
		$cantidadTotal = 0;
		$combos=array();
		foreach ($venta->getDetalles() as $detalle) {
			//Logger::log('Combo1: '.$detalle->getCombo());
			if (!empty($detalle->getCombo())) {
				
				if(!in_array($detalle->getCombo()->getOid(), $combos)){
					
					$combos[]=$detalle->getCombo()->getOid();
					$oCombo = UIServiceFactory::getUIComboService()->get( $detalle->getCombo()->getOid() );
						
					foreach ($oCombo->getProductos() as $producto) {
						
						if ($detalle->getProducto()->getOid()==$producto->getProducto()->getOid()) {
							$cantidad = $detalle->getCantidad()/$producto->getCantidad();
							break;
						}
					}
					$xtpl->assign( "producto", $detalle->getCombo() );
					$xtpl->assign( "cantidad", $cantidad );
					$xtpl->assign( "precio", MientrasUIUtils::formatMontoToView( $detalle->getCombo()->getPrecio()*$cantidad ) );
					$xtpl->assign( "subtotal", MientrasUIUtils::formatMontoToView( $detalle->getCombo()->getPrecio()*$cantidad  ) );
					$xtpl->parse( "main.detalle" );
					
					$cantidadTotal += $cantidad;
				}
				
			}
			else{
				$xtpl->assign( "producto", $detalle->getProducto() );
				$xtpl->assign( "cantidad", $detalle->getCantidad() );
				$xtpl->assign( "precio", MientrasUIUtils::formatMontoToView( $detalle->getPrecioUnitario() ) );
				$xtpl->assign( "subtotal", MientrasUIUtils::formatMontoToView( $detalle->getSubtotal() ) );
				$xtpl->parse( "main.detalle" );
				
				$cantidadTotal += $detalle->getCantidad();
			}
		}
		
		$xtpl->assign( "total", MientrasUIUtils::formatMontoToView( $venta->getMonto() ) );
		$xtpl->assign( "cantidad_total", $cantidadTotal );
			
	}
	
	
	protected function initObserverEventType(){
		$this->addEventType( "Venta" );
	}
	
	public function setVentaOid($oid){
		if( !empty($oid) ){
			$venta = UIServiceFactory::getUIVentaService()->get($oid);
			$this->setVenta($venta);
		}
	}   
    

	public function getVenta()
	{
	    return $this->venta;
	}

	public function setVenta($venta)
	{
	    $this->venta = $venta;
	}
}
?>
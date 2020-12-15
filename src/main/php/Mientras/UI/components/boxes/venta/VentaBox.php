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
 * @since 12-03-2018
 */
class VentaBox extends RastyComponent{
		
	private $venta;
	
	public function getType(){
		
		return "VentaBox";
		
	}

	public function __construct(){
		
		
	}

	protected function parseLabels(XTemplate $xtpl){
		
		$xtpl->assign("lbl_fecha",  $this->localize( "venta.fecha" ) );
		
		$xtpl->assign("lbl_cliente",  $this->localize( "venta.cliente" ) );
		$xtpl->assign("lbl_observaciones",  $this->localize( "venta.observaciones" ) );
		$xtpl->assign("lbl_monto",  $this->localize( "venta.monto" ) );
		$xtpl->assign("lbl_montoPagado",  $this->localize( "venta.montoPagado" ) );
		$xtpl->assign("lbl_montoActualizado",  $this->localize( "venta.montoActualizado" ) );
		$xtpl->assign("lbl_montoDebe",  $this->localize( "venta.montoDebe" ) );
		$xtpl->assign("lbl_estado",  $this->localize( "venta.estado" ) );
		
		$xtpl->assign("lbl_detalle_nombre", $this->localize( "venta.detalle.producto" ) );
		$xtpl->assign("lbl_detalle_precio", $this->localize( "venta.detalle.precio" ) );
		$xtpl->assign("lbl_detalle_cantidad", $this->localize( "venta.detalle.cantidad" ) );
		$xtpl->assign("lbl_detalle_subtotal", $this->localize( "venta.detalle.subtotal" ) );
		
		$xtpl->assign("lbl_subtotales",  $this->localize( "venta.devolucion.subtotal" ) );
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
		$total = 0;
		$combos = array();
		foreach ($venta->getDetalles() as $detalle) {
			
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
					$total += $detalle->getCombo()->getPrecio()*$cantidad;
					$cantidadTotal += $cantidad;
				}
				
			}
			else{
				$xtpl->assign( "producto", $detalle->getProducto() );
				$xtpl->assign( "cantidad", $detalle->getCantidad() );
				$xtpl->assign( "precio", MientrasUIUtils::formatMontoToView( $detalle->getPrecioUnitario() ) );
				$xtpl->assign( "subtotal", MientrasUIUtils::formatMontoToView( $detalle->getSubtotal() ) );
				$xtpl->parse( "main.detalle" );
				$total += $detalle->getSubtotal();
				$cantidadTotal += $detalle->getCantidad();
			}	
			
			
			
		}
		
		$xtpl->assign( "total", MientrasUIUtils::formatMontoToView( $total ) );
		$xtpl->assign( "cantidad_total", $cantidadTotal );
		
		$cantidadTotal = 0;
		$htmlItem='';
		foreach ($venta->getDevoluciones() as $devolucion) {
			/*$xtpl->assign( "producto", $devolucion->getProducto() );
			$xtpl->assign( "cantidad", $devolucion->getCantidad() );
			$xtpl->assign( "precio", MientrasUIUtils::formatMontoToView( $devolucion->getPrecioUnitario() ) );
			$xtpl->assign( "subtotal", MientrasUIUtils::formatMontoToView( $devolucion->getSubtotal() ) );
			$xtpl->parse( "main.devolucion" );*/
			
			$htmlItem .='<tr><td>'.$devolucion->getProducto().'</td><td class="align-r">'.$devolucion->getCantidad().'</td><td class="align-r">'.MientrasUIUtils::formatMontoToView( $devolucion->getPrecioUnitario() ).'</td><td class="align-r">'.MientrasUIUtils::formatMontoToView( $devolucion->getSubtotal() ).'</td></tr>';
			$cantidadTotal += $devolucion->getCantidad();
		}

		
		$html='';
		if ($cantidadTotal) {
			$html.='<div class="box_details">
					<table>
						<thead><tr><th colspan="4">Devoluci&oacute;n</th></tr></thead>
						<thead><tr><th>'.$this->localize( "venta.detalle.producto" ).'</th><th>'.$this->localize( "venta.detalle.cantidad" ).'</th><th>'.$this->localize( "venta.detalle.precio" ).'</th><th>'.$this->localize( "venta.detalle.subtotal" ).'</th></tr></thead>
						<tbody>
							'.$htmlItem.'
						</tbody>
						<tfoot>
							<tr><td>'.$this->localize( "venta.detalle.subtotal" ).'</td><td class="align-r">'.$cantidadTotal.'</td><td></td><td class="align-r">'.MientrasUIUtils::formatMontoToView( $venta->getMontoDevolucion() ).'</td></tr>
						</tfoot>
					</table>
				</div>';
		}
		
		$xtpl->assign( "htmlDevoluciones", $html );
		
		$xtpl->assign( "totales", MientrasUIUtils::formatMontoToView( $venta->getMonto() ) );
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
<?php

namespace Mientras\UI\components\pdf\venta;

use Mientras\UI\utils\MientrasUIUtils;

use Mientras\UI\service\UIServiceFactory;

use Rasty\components\RastyComponent;
use Rasty\utils\RastyUtils;

use Rasty\utils\XTemplate;

use Mientras\Core\model\Venta;

use Rasty\utils\LinkBuilder;
use Rasty\render\DOMPDFRenderer;
use Rasty\conf\RastyConfig;

/**
 * para renderizar en pdf la plantilla de contrato
 * de un venta.
 * 
 * @author Marcos
 * @since 21-03-2019
 * 
 */
class VentaPDF extends RastyComponent{
		
	private $venta;
	
	public function getType(){
		
		return "VentaPDF";
		
	}

	public function __construct(){
		
		
	}

	
	protected function parseXTemplate(XTemplate $xtpl){
		
		$venta = $this->getVenta();
		$xtpl->assign( "APP_PATH", RastyConfig::getInstance()->getAppPath() );
		if( !empty($venta )){
			
			/*$contrato = html_entity_decode( $venta->getDetalleFalla() );
			
			$xtpl->assign("contrato",  $contrato );*/
			$xtpl->assign( "oid", $venta->getOid() );
			$xtpl->assign( "fecha", MientrasUIUtils::formatDateTimeToView($venta->getFecha()) );
			$observaciones = ($venta->getObservaciones())?' - '.$venta->getObservaciones():'';
			$xtpl->assign( "cliente", $venta->getCliente().$observaciones);
			$xtpl->assign( "celular", $venta->getCliente()->getCelular() );
			$xtpl->assign( "telefono", $venta->getCliente()->getTelefono() );
			$xtpl->assign( "email", $venta->getCliente()->getMail() );
			
			$xtpl->assign("lbl_detalle_nombre", $this->localize( "venta.detalle.producto" ) );
			$xtpl->assign("lbl_detalle_precio", $this->localize( "venta.detalle.precio" ) );
			$xtpl->assign("lbl_detalle_cantidad", $this->localize( "venta.detalle.cantidad" ) );
			$xtpl->assign("lbl_detalle_subtotal", $this->localize( "venta.detalle.subtotal" ) );
			
			$xtpl->assign("lbl_totales",  $this->localize( "venta.detalles.total" ) );
			$xtpl->assign("lbl_subtotales",  $this->localize( "venta.devolucion.subtotal" ) );
			
			$xtpl->assign("lbl_pagado",  $this->localize( "venta.montoPagado" ) );
			$xtpl->assign("lbl_adeudado",  $this->localize( "venta.montoDebe" ) );
			
			$cantidadTotal = 0;
			$total=0;
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
			$total=0;
			$htmlItem='';
			foreach ($venta->getDevoluciones() as $devolucion) {
				
				
				$htmlItem .='<tr><td>'.$devolucion->getProducto().'</td><td style="text-align: right;">'.$devolucion->getCantidad().'</td><td style="text-align: right;">'.MientrasUIUtils::formatMontoToView( $devolucion->getPrecioUnitario() ).'</td><td style="text-align: right;">'.MientrasUIUtils::formatMontoToView( $devolucion->getSubtotal() ).'</td></tr>';
				$cantidadTotal += $devolucion->getCantidad();
			}
	
			
			$html='';
			if ($cantidadTotal) {
				
				$html.='<div class="box_details" id="divDevoluciones">
	<table cellspacing="0" cellpadding="0" border="1">
		<thead><tr><th colspan="4" align="center">Devoluci&oacute;n</th></tr></thead>
		<thead><tr><th width="450px">'.$this->localize( "venta.detalle.producto" ).'</th><th>'.$this->localize( "venta.detalle.cantidad" ).'</th><th width="100px">'.$this->localize( "venta.detalle.precio" ).'</th><th width="100px">'.$this->localize( "venta.detalle.subtotal" ).'</th></tr></thead>
		
			'.$htmlItem.'
		
		<tr><td colspan="4"></td></tr>
		<tr><td colspan="4"></td></tr>
		<tr><td colspan="4"></td></tr>
		<tr><td colspan="4"></td></tr>
			<tr><td style="text-align: right; font-weight: bold;" colspan="3">'.$this->localize( "venta.detalle.subtotal" ).'</td><td style="text-align: right;font-weight: bold;">'.MientrasUIUtils::formatMontoToView( $venta->getMontoDevolucion() ).'</td></tr>
		
	</table>
</div>';
			}
			
			$xtpl->assign( "htmlDevoluciones", $html );
			if ($venta->getMontoActualizado()) {
				$xtpl->assign( 'htmlMontoActualizado','<tr><td style="text-align: right; font-weight: bold;" colspan="3" width="616px">'.$this->localize('venta.montoActualizado').'</td><td style="text-align: right;font-weight: bold;" width="100px">'.MientrasUIUtils::formatMontoToView($venta->getMontoActualizado()),'</td></tr>');
			}
			$xtpl->assign( "totales", MientrasUIUtils::formatMontoToView( $venta->getMonto() ) );
			$xtpl->assign( "pagado", MientrasUIUtils::formatMontoToView( $venta->getMontoPagado() ) );
			$xtpl->assign( "adeudado", MientrasUIUtils::formatMontoToView( $venta->getMontoDebe() ) );
			
				
		}else{
			$xtpl->assign("contrato",  "no existe la plantilla" );
		}
						
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
	
	public function getPDFRenderer(){
		
		$renderer = new DOMPDFRenderer();
		return $renderer;
	}
}
?>
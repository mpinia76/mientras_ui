<?php

namespace Mientras\UI\components\boxes\presupuesto;

use Mientras\UI\utils\MientrasUIUtils;

use Mientras\UI\service\UIServiceFactory;

use Rasty\components\RastyComponent;
use Rasty\utils\RastyUtils;

use Rasty\utils\XTemplate;

use Mientras\Core\model\Presupuesto;
use Mientras\Core\model\EstadoPresupuesto;

use Rasty\utils\LinkBuilder;

/**
 * presupuesto.
 * 
 * @author Marcos
 * @since 29-03-2019
 */
class PresupuestoBox extends RastyComponent{
		
	private $presupuesto;
	
	public function getType(){
		
		return "PresupuestoBox";
		
	}

	public function __construct(){
		
		
	}

	protected function parseLabels(XTemplate $xtpl){
		
		$xtpl->assign("lbl_fecha",  $this->localize( "presupuesto.fecha" ) );
		
		$xtpl->assign("lbl_cliente",  $this->localize( "presupuesto.cliente" ) );
		$xtpl->assign("lbl_observaciones",  $this->localize( "presupuesto.observaciones" ) );
		$xtpl->assign("lbl_monto",  $this->localize( "presupuesto.monto" ) );
		
		$xtpl->assign("lbl_estado",  $this->localize( "presupuesto.estado" ) );
		
		$xtpl->assign("lbl_detalle_nombre", $this->localize( "presupuesto.detalle.producto" ) );
		$xtpl->assign("lbl_detalle_precio", $this->localize( "presupuesto.detalle.precio" ) );
		$xtpl->assign("lbl_detalle_cantidad", $this->localize( "presupuesto.detalle.cantidad" ) );
		$xtpl->assign("lbl_detalle_subtotal", $this->localize( "presupuesto.detalle.subtotal" ) );
		
		$xtpl->assign("lbl_totales",  $this->localize( "presupuesto.detalles.totales" ) );
	}
	
	protected function parseXTemplate(XTemplate $xtpl){
		
		/*labels*/
		$this->parseLabels($xtpl);
		
		$presupuesto = $this->getPresupuesto();
		
			
		
		$xtpl->assign( "cliente", $this->getPresupuesto()->getCliente() );
		
		$xtpl->assign( "monto", MientrasUIUtils::formatMontoToView( $this->getPresupuesto()->getMonto() ) );
		
		
		
		$xtpl->assign( "observaciones", $this->getPresupuesto()->getObservaciones() );
		$xtpl->assign( "fecha", MientrasUIUtils::formatDateTimeToView($this->getPresupuesto()->getFecha()) );
		$xtpl->assign( "estado", $this->localize( EstadoPresupuesto::getLabel( $presupuesto->getEstado()) ) );
		
		$cantidadTotal = 0;
		foreach ($presupuesto->getDetalles() as $detalle) {
			$xtpl->assign( "producto", $detalle->getProducto() );
			$xtpl->assign( "cantidad", $detalle->getCantidad() );
			$xtpl->assign( "precio", MientrasUIUtils::formatMontoToView( $detalle->getPrecioUnitario() ) );
			$xtpl->assign( "subtotal", MientrasUIUtils::formatMontoToView( $detalle->getSubtotal() ) );
			$xtpl->parse( "main.detalle" );
			
			$cantidadTotal += $detalle->getCantidad();
		}
		
		$xtpl->assign( "total", MientrasUIUtils::formatMontoToView( $presupuesto->getMonto() ) );
		$xtpl->assign( "cantidad_total", $cantidadTotal );
			
	}
	
	
	protected function initObserverEventType(){
		$this->addEventType( "Presupuesto" );
	}
	
	public function setPresupuestoOid($oid){
		if( !empty($oid) ){
			$presupuesto = UIServiceFactory::getUIPresupuestoService()->get($oid);
			$this->setPresupuesto($presupuesto);
		}
	}   
    

	public function getPresupuesto()
	{
	    return $this->presupuesto;
	}

	public function setPresupuesto($presupuesto)
	{
	    $this->presupuesto = $presupuesto;
	}
}
?>
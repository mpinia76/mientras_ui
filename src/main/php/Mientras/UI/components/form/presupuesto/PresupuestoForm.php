<?php

namespace Mientras\UI\components\form\presupuesto;

use Mientras\UI\service\finder\ClienteFinder;



use Mientras\UI\service\finder\ProductoFinder;


use Mientras\UI\utils\MientrasUIUtils;

use Mientras\UI\service\UIServiceFactory;

use Rasty\Forms\form\Form;

use Rasty\components\RastyComponent;
use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;


use Mientras\Core\model\Presupuesto;
use Mientras\Core\model\DetallePresupuesto;


use Rasty\utils\LinkBuilder;
use Rasty\security\RastySecurityContext;

/**
 * Formulario para presupuesto

 * @author Marcos
 * @since 29/03/2019
 */
class PresupuestoForm extends Form{
		
	

	/**
	 * label para el cancel
	 * @var string
	 */
	private $labelCancel;
	

	/**
	 * 
	 * @var Presupuesto
	 */
	private $presupuesto;
	
	private $detalle;
	
	public function __construct(){

		parent::__construct();
		$this->setLabelCancel("presupuesto.cancelar");
		$this->setLabelSubmit("presupuesto.confirmar");
		
		$this->addProperty("fecha");
		
		$this->addProperty("cliente");
		$this->addProperty("observaciones");
		
		$this->setBackToOnSuccess("Presupuestos");
		$this->setBackToOnCancel("Presupuestos");
		
	}
	
	public function getOid(){
		
		return $this->getComponentById("oid")->getPopulatedValue( $this->getMethod() );
	}
	
	
	public function getType(){
		
		return "PresupuestoForm";
		
	}
	
	public function fillEntity($entity){
		
		//le agregamos los detalles de sesión.
		$detalles = MientrasUIUtils::getDetallesPresupuestoSession();
		
		
		parent::fillEntity($entity);
		
		
		foreach ($detalles as $detallejson) {
			$detalle = new DetallePresupuesto();
			
			$detalle->setCantidad( $detallejson["cantidad"] );
			$detalle->setPrecioUnitario( $detallejson["precioUnitario"] );
			$detalle->setProducto( UIServiceFactory::getUIProductoService()->get($detallejson["producto_oid"]) );
			
			$entity->addDetalle( $detalle );
			
		}
		
		$user = RastySecurityContext::getUser();
		$user = \Cose\Security\service\ServiceFactory::getUserService()->getUserByUsername($user->getUsername());
		$entity->setUser( $user );
		
		
	}

	protected function parseXTemplate(XTemplate $xtpl){

		parent::parseXTemplate($xtpl);
		
		$xtpl->assign("cancel", $this->getLinkCancel() );
		$xtpl->assign("lbl_cancel", $this->localize( $this->getLabelCancel() ) );
		
		$xtpl->assign("lbl_fecha", $this->localize("presupuesto.fecha") );
		
		$xtpl->assign("lbl_cliente", $this->localize("presupuesto.cliente") );
		$xtpl->assign("lbl_observaciones", $this->localize("presupuesto.observaciones") );
		
		$xtpl->assign("detalles_legend", $this->localize("presupuesto.agregar.detalles_legend") );
		$xtpl->assign("lbl_detalle_nombre", $this->localize( "presupuesto.detalle.producto" ) );
		$xtpl->assign("lbl_detalle_precio", $this->localize( "presupuesto.detalle.precio" ) );
		$xtpl->assign("lbl_detalle_cantidad", $this->localize( "presupuesto.detalle.cantidad" ) );
		$xtpl->assign("lbl_detalle_subtotal", $this->localize( "presupuesto.detalle.subtotal" ) );
		
		
		$xtpl->assign("linkConsultarStockDetalle", $this->getLinkActionConsultarStockDetalle() );
		$xtpl->assign("linkAgregarDetalle", $this->getLinkActionAgregarDetalle() );
		$xtpl->assign("linkBorrarDetalle", $this->getLinkActionBorrarDetalle() );
		
		
	
		
		
	}


	public function getLabelCancel()
	{
	    return $this->labelCancel;
	}

	public function setLabelCancel($labelCancel)
	{
	    $this->labelCancel = $labelCancel;
	}

	public function getLinkCancel(){
		$params = array();
		
		return LinkBuilder::getPageUrl( $this->getBackToOnCancel() , $params) ;
	}
	
	
	
	public function getProductoFinderClazz(){
		
		return get_class( new ProductoFinder() );
		
	}	
	
	public function getPresupuesto()
	{
	    return $this->presupuesto;
	}

	public function setPresupuesto($presupuesto)
	{
	    $this->presupuesto = $presupuesto;
	}

	public function getDetalle()
	{
	    return $this->detalle;
	}

	public function setDetalle($detalle)
	{
	    $this->detalle = $detalle;
	}
	

	public function getLinkActionAgregarDetalle(){
		
		return LinkBuilder::getActionAjaxUrl( "AgregarDetallePresupuestoJson") ;
		
	}
	
	public function getLinkActionConsultarStockDetalle(){
		
		return LinkBuilder::getActionAjaxUrl( "ConsultarStockDetalleVentaJson") ;
		
	}
	
	public function getLinkActionBorrarDetalle(){
		
		return LinkBuilder::getActionAjaxUrl( "BorrarDetallePresupuestoJson") ;
		
	}
	
	
	
	public function getClienteFinderClazz(){
		
		return get_class( new ClienteFinder() );
		
	}	
	
}
?>
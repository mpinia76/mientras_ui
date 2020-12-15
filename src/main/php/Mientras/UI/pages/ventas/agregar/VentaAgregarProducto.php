<?php
namespace Mientras\UI\pages\ventas\agregar;

use Mientras\UI\service\UIServiceFactory;

use Mientras\UI\service\finder\ProductoFinder;

use Mientras\Core\utils\MientrasUtils;
use Mientras\UI\utils\MientrasUIUtils;

use Mientras\UI\pages\MientrasPage;

use Rasty\utils\XTemplate;
use Mientras\Core\model\Venta;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;

use Mientras\Core\model\DetalleVenta;


use Rasty\utils\LinkBuilder;

class VentaAgregarProducto extends MientrasPage{

	/**
	 * venta a devolver.
	 * @var Venta
	 */
	private $venta;

	private $error;
	
	private $detalle;
	
	public function __construct(){
		
		//inicializamos el venta.
		$venta = new Venta();
		
		
		$this->setVenta($venta);

		
	}
	
	public function getMenuGroups(){

		//TODO construirlo a partir del usuario 
		//y utilizando permisos
		
		$menuGroup = new MenuGroup();
		
//		$menuOption = new MenuOption();
//		$menuOption->setLabel( $this->localize( "form.volver") );
//		$menuOption->setPageName("Ventas");
//		$menuGroup->addMenuOption( $menuOption );
//		
		
		return array($menuGroup);
	}
	
	public function getTitle(){
		return $this->localize( "venta.agregar.producto.title" );
	}

	public function getType(){
		
		return "VentaAgregarProducto";
		
	}	

	protected function parseXTemplate(XTemplate $xtpl){
		
		MientrasUIUtils::setDetallesVentaSession( array() );
		
		$xtpl->assign( "venta_legend", $this->localize( "agregarProducto.venta.legend") );
		$xtpl->assign( "forma_pago_legend", $this->localize( "agregarProducto.forma_pago.legend") );
		
		$xtpl->assign("detalles_legend", $this->localize("venta.agregar.detalles_legend") );
		$xtpl->assign("lbl_detalle_nombre", $this->localize( "venta.detalle.producto" ) );
		$xtpl->assign("lbl_detalle_precio", $this->localize( "venta.detalle.precio" ) );
		$xtpl->assign("lbl_detalle_cantidad", $this->localize( "venta.detalle.cantidad" ) );
		$xtpl->assign("lbl_detalle_subtotal", $this->localize( "venta.detalle.subtotal" ) );
		
		
		
		$xtpl->assign( "linkAgregarProductoVenta", $this->getLinkActionAgregarProductoVenta($this->getVenta()) );
		
		$xtpl->assign("linkConsultarStockDetalle", $this->getLinkActionConsultarStockDetalle() );
		$xtpl->assign("linkAgregarDetalle", $this->getLinkActionAgregarDetalle() );
		$xtpl->assign("linkBorrarDetalle", $this->getLinkActionBorrarDetalle() );
		
		$msg = $this->getError();
		
		if( !empty($msg) ){
			
			$xtpl->assign("msg", $msg);
			//$xtpl->assign("msg",  );
			$xtpl->parse("main.msg_error" );
		}
		$xtpl->assign( "lbl_submit", $this->localize("agregarProducto.confirm") );
		$xtpl->assign( "lbl_cancel", $this->localize("agregarProducto.cancel") );
	}


	public function getVenta()
	{
	    return $this->venta;
	}

	public function setVenta($venta)
	{
	    $this->venta = $venta;
	}
	
	public function setVentaOid($ventaOid)
	{
		if(!empty($ventaOid)){
			$venta = UIServiceFactory::getUIVentaService()->get($ventaOid);
			$this->setVenta($venta);
		}
		
	    
	}
	
	public function getProductoFinderClazz(){
		
		return get_class( new ProductoFinder() );
		
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
		
		return LinkBuilder::getActionAjaxUrl( "AgregarDetalleVentaJson") ;
		
	}
	
	public function getLinkActionConsultarStockDetalle(){
		
		return LinkBuilder::getActionAjaxUrl( "ConsultarStockDetalleVentaJson") ;
		
	}
	
	public function getLinkActionBorrarDetalle(){
		
		return LinkBuilder::getActionAjaxUrl( "BorrarDetalleVentaJson") ;
		
	}
					
	public function getMsgError(){
		return "";
	}

	public function getError()
	{
	    return $this->error;
	}

	public function setError($error)
	{
	    $this->error = $error;
	}
}
?>
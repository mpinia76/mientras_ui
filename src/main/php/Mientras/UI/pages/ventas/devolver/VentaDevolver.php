<?php
namespace Mientras\UI\pages\ventas\devolver;

use Mientras\UI\service\UIServiceFactory;

use Mientras\UI\service\finder\ProductoFinder;

use Mientras\Core\utils\MientrasUtils;
use Mientras\UI\utils\MientrasUIUtils;

use Mientras\UI\pages\MientrasPage;

use Rasty\utils\XTemplate;
use Mientras\Core\model\Venta;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;

use Mientras\Core\model\DevolucionVenta;


use Rasty\utils\LinkBuilder;

class VentaDevolver extends MientrasPage{

	/**
	 * venta a devolver.
	 * @var Venta
	 */
	private $venta;

	private $error;
	
	private $devolucion;
	
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
		return $this->localize( "venta.devolver.title" );
	}

	public function getType(){
		
		return "VentaDevolver";
		
	}	

	protected function parseXTemplate(XTemplate $xtpl){
		
		MientrasUIUtils::setDevolucionesVentaSession( array() );
		
		$xtpl->assign( "venta_legend", $this->localize( "devolverVenta.venta.legend") );
		$xtpl->assign( "forma_pago_legend", $this->localize( "devolverVenta.forma_pago.legend") );
		
		$xtpl->assign("devoluciones_legend", $this->localize("venta.agregar.devoluciones_legend") );
		$xtpl->assign("lbl_devolucion_nombre", $this->localize( "venta.devolucion.producto" ) );
		$xtpl->assign("lbl_devolucion_precio", $this->localize( "venta.devolucion.precio" ) );
		$xtpl->assign("lbl_devolucion_cantidad", $this->localize( "venta.devolucion.cantidad" ) );
		$xtpl->assign("lbl_devolucion_subtotal", $this->localize( "venta.devolucion.subtotal" ) );
		
		
		
		$xtpl->assign("linkAgregarDevolucion", $this->getLinkActionAgregarDevolucion() );
		$xtpl->assign("linkBorrarDevolucion", $this->getLinkActionBorrarDevolucion() );
		
		$xtpl->assign( "linkDevolverVenta", $this->getLinkActionDevolverVenta($this->getVenta()) );
		
		$msg = $this->getError();
		
		if( !empty($msg) ){
			
			$xtpl->assign("msg", $msg);
			//$xtpl->assign("msg",  );
			$xtpl->parse("main.msg_error" );
		}
		$xtpl->assign( "lbl_submit", $this->localize("devolverVenta.confirm") );
		$xtpl->assign( "lbl_cancel", $this->localize("devolverVenta.cancel") );
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
	
	public function getDevolucion()
	{
	    return $this->devolucion;
	}

	public function setDevolucion($devolucion)
	{
	    $this->devolucion = $devolucion;
	}
	

	public function getLinkActionAgregarDevolucion(){
		
		return LinkBuilder::getActionAjaxUrl( "AgregarDevolucionVentaJson") ;
		
	}
	
	
	
	public function getLinkActionBorrarDevolucion(){
		
		return LinkBuilder::getActionAjaxUrl( "BorrarDevolucionVentaJson") ;
		
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
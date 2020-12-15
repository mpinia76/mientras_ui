<?php
namespace Mientras\UI\pages\ventas\cobrar;

use Mientras\UI\service\UIServiceFactory;

use Mientras\Core\utils\MientrasUtils;
use Mientras\UI\utils\MientrasUIUtils;

use Mientras\UI\pages\MientrasPage;

use Rasty\utils\XTemplate;
use Mientras\Core\model\Venta;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;

use Rasty\utils\LinkBuilder;

class VentaCobrar extends MientrasPage{

	/**
	 * venta a cobrar.
	 * @var Venta
	 */
	private $venta;

	private $error;
	
	private $backTo;
	
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
		return $this->localize( "venta.cobrar.title" );
	}

	public function getType(){
		
		return "VentaCobrar";
		
	}	

	protected function parseXTemplate(XTemplate $xtpl){
		
		$xtpl->assign( "venta_legend", $this->localize( "cobrarVenta.venta.legend") );
		$xtpl->assign( "forma_pago_legend", $this->localize( "cobrarVenta.forma_pago.legend") );
		
		$xtpl->assign( "lbl_efectivo", $this->localize( "forma.pago.efectivo") );
		$xtpl->assign( "lbl_tarjeta", $this->localize( "forma.pago.tarjeta") );
		$xtpl->assign( "lbl_ctacte", $this->localize( "forma.pago.ctacte") );
		$xtpl->assign( "lbl_anular", $this->localize( "venta.anular") );
		$xtpl->assign( "lbl_pendiente", $this->localize( "forma.pago.pendiente") );
		
		
		$xtpl->assign( "linkCobrarEfectivo", $this->getLinkActionCobrarVentaEfectivo($this->getVenta()) );
		$xtpl->parse( "main.forma_pago_caja");
		
		$xtpl->assign( "linkCobrarTarjeta", $this->getLinkCobrarVentaTarjeta($this->getVenta()) );
		$xtpl->parse( "main.forma_pago_tarjeta");
		
		$xtpl->assign( "linkAnular", $this->getLinkVentaAnular( $this->getVenta()) );
		
		if( $this->getVenta()->getCliente()->hasCuentaCorriente() ){
			$xtpl->assign( "linkCobrarCtaCte", $this->getLinkActionCobrarVentaCtaCte($this->getVenta()) );
			$xtpl->parse( "main.forma_pago_ctacte");
		}
		
		$backTo = $this->getBackTo();
		if( empty($backTo) ){
			$backTo = "Ventas";
		}
		
		$xtpl->assign( "linkPendiente", LinkBuilder::getPageUrl( $backTo ) );
		$xtpl->parse("main.forma_pago_pendiente");
		
		$msg = $this->getError();
		
		if( !empty($msg) ){
			
			$xtpl->assign("msg", $msg);
			//$xtpl->assign("msg",  );
			$xtpl->parse("main.msg_error" );
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
	
	public function setVentaOid($ventaOid)
	{
		if(!empty($ventaOid)){
			$venta = UIServiceFactory::getUIVentaService()->get($ventaOid);
			$this->setVenta($venta);
		}
		
	    
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
	
	public function getBackTo()
	{
	    return $this->backTo;
	}

	public function setBackTo($backTo)
	{
	    $this->backTo = $backTo;
	}
}
?>
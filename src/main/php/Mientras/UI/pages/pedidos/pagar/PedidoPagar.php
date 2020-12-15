<?php
namespace Mientras\UI\pages\pedidos\pagar;

use Mientras\UI\service\UIServiceFactory;

use Mientras\Core\utils\MientrasUtils;
use Mientras\UI\utils\MientrasUIUtils;

use Mientras\UI\pages\MientrasPage;

use Rasty\utils\XTemplate;
use Mientras\Core\model\Pedido;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;

use Rasty\utils\LinkBuilder;

class PedidoPagar extends MientrasPage{

	/**
	 * pedido a pagar.
	 * @var Pedido
	 */
	private $pedido;

	private $error;

	private $backTo;
		
	public function __construct(){
		
		//inicializamos el pedido.
		$pedido = new Pedido();
		
		
		$this->setPedido($pedido);

		
	}
	
	public function getMenuGroups(){

		//TODO construirlo a partir del usuario 
		//y utilizando permisos
		
		$menuGroup = new MenuGroup();
		
//		$menuOption = new MenuOption();
//		$menuOption->setLabel( $this->localize( "form.volver") );
//		$menuOption->setPageName("Pedidos");
//		$menuGroup->addMenuOption( $menuOption );
//		
		
		return array($menuGroup);
	}
	
	public function getTitle(){
		return $this->localize( "pedido.pagar.title" );
	}

	public function getType(){
		
		return "PedidoPagar";
		
	}	

	protected function parseXTemplate(XTemplate $xtpl){
		
		$xtpl->assign( "pedido_legend", $this->localize( "pagar.pedido.legend") );
		$xtpl->assign( "forma_pago_legend", $this->localize( "pagar.forma_pago.legend") );
		
		
		$xtpl->assign( "lbl_efectivo", $this->localize( "forma.pago.efectivo") );
		/*$xtpl->assign( "lbl_cajaChica", $this->localize( "forma.pago.cajaChica") );
		$xtpl->assign( "lbl_bapro", $this->localize( "forma.pago.bapro") );*/
		$xtpl->assign( "lbl_anular", $this->localize( "pedido.anular") );
		$xtpl->assign( "lbl_pendiente", $this->localize( "forma.pago.pendiente") );
		/*if( MientrasUIUtils::isCajaSelected() ){
			$xtpl->assign( "linkPagarEfectivo", $this->getLinkActionPagarPedido($this->getPedido(), MientrasUIUtils::getCaja(), $this->getBackTo()) );
			$xtpl->parse("main.forma_pago_caja");	
		}
		
		if( MientrasUIUtils::isAdminLogged() ){
			$xtpl->assign( "linkPagarCajaChica", $this->getLinkActionPagarPedido($this->getPedido(), MientrasUtils::getCuentaCajaChica(), $this->getBackTo()) );
			$xtpl->parse("main.forma_pago_cajaChica");
			
			$xtpl->assign( "linkPagarBAPRO", $this->getLinkActionPagarPedido($this->getPedido(), MientrasUtils::getCuentaBAPRO(), $this->getBackTo()) );
			$xtpl->parse("main.forma_pago_bapro");
		}*/
		$xtpl->assign( "linkPagarEfectivo", $this->getLinkActionPagarPedido($this->getPedido(), MientrasUtils::getCuentaUnica(), $this->getBackTo()) );
		$xtpl->parse("main.forma_pago_caja");	
		
		$xtpl->assign( "linkAnular", $this->getLinkPedidoAnular($this->getPedido()) );
		
		
		$backTo = $this->getBackTo();
		if( empty($backTo) ){
			$backTo = "Pedidos";
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


	public function getPedido()
	{
	    return $this->pedido;
	}

	public function setPedido($pedido)
	{
	    $this->pedido = $pedido;
	}
	
	public function setPedidoOid($pedidoOid)
	{
		if(!empty($pedidoOid)){
			$pedido = UIServiceFactory::getUIPedidoService()->get($pedidoOid);
			$this->setPedido($pedido);
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
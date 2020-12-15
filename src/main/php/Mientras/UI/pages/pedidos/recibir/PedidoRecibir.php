<?php
namespace Mientras\UI\pages\pedidos\recibir;

use Mientras\UI\service\UIServiceFactory;

use Mientras\Core\utils\MientrasUtils;
use Mientras\UI\utils\MientrasUIUtils;

use Mientras\UI\pages\MientrasPage;

use Rasty\utils\XTemplate;
use Mientras\Core\model\Pedido;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;

class PedidoRecibir extends MientrasPage{

	/**
	 * pedido a recibir.
	 * @var Pedido
	 */
	private $pedido;

	private $error;
	
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
		return $this->localize( "pedido.recibir.title" );
	}

	public function getType(){
		
		return "PedidoRecibir";
		
	}	

	protected function parseXTemplate(XTemplate $xtpl){
		
		$xtpl->assign( "pedido_legend", $this->localize( "recibirPedido.pedido.legend") );
		
		
		$xtpl->assign( "pedidoOid", $this->getPedido()->getOid() );
		
		$xtpl->assign( "linkRecibirPedido", $this->getLinkActionRecibirPedido($this->getPedido()) );
		
		$msg = $this->getError();
		
		if( !empty($msg) ){
			
			$xtpl->assign("msg", $msg);
			//$xtpl->assign("msg",  );
			$xtpl->parse("main.msg_error" );
		}
		
		$xtpl->assign( "lbl_submit", $this->localize("recibirPedido.confirm") );
		$xtpl->assign( "lbl_cancel", $this->localize("recibirPedido.cancel") );
		
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
}
?>
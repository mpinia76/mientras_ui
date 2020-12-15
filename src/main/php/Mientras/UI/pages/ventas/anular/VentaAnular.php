<?php
namespace Mientras\UI\pages\ventas\anular;

use Mientras\UI\service\UIServiceFactory;

use Mientras\Core\utils\MientrasUtils;
use Mientras\UI\utils\MientrasUIUtils;

use Mientras\UI\pages\MientrasPage;

use Rasty\utils\XTemplate;
use Mientras\Core\model\Venta;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;

class VentaAnular extends MientrasPage{

	/**
	 * venta a anular.
	 * @var Venta
	 */
	private $venta;

	private $error;
	
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
		return $this->localize( "venta.anular.title" );
	}

	public function getType(){
		
		return "VentaAnular";
		
	}	

	protected function parseXTemplate(XTemplate $xtpl){
		
		$xtpl->assign( "venta_legend", $this->localize( "anularVenta.venta.legend") );
		
		$xtpl->assign( "ventaOid", $this->getVenta()->getOid() );
		
		$xtpl->assign( "linkAnularVenta", $this->getLinkActionAnularVenta($this->getVenta()) );
		
		$msg = $this->getError();
		
		if( !empty($msg) ){
			
			$xtpl->assign("msg", $msg);
			//$xtpl->assign("msg",  );
			$xtpl->parse("main.msg_error" );
		}
		
		$xtpl->assign( "lbl_submit", $this->localize("anularVenta.confirm") );
		$xtpl->assign( "lbl_cancel", $this->localize("anularVenta.cancel") );
		
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
}
?>
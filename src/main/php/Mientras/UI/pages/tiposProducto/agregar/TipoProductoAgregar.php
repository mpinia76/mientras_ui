<?php
namespace Mientras\UI\pages\tiposProducto\agregar;

use Mientras\UI\pages\MientrasPage;

use Rasty\utils\XTemplate;
use Mientras\Core\model\TipoProducto;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;

class TipoProductoAgregar extends MientrasPage{

	/**
	 * TipoProducto a agregar.
	 * @var TipoProducto
	 */
	private $TipoProducto;

	
	public function __construct(){
		
		//inicializamos el TipoProducto.
		$TipoProducto = new TipoProducto();
		
		//$TipoProducto->setNombre("Bernardo");
		//$TipoProducto->setEmail("ber@mail.com");
		$this->setTipoProducto($TipoProducto);
		
		
	}
	
	public function getMenuGroups(){

		//TODO construirlo a partir del usuario 
		//y utilizando permisos
		
		$menuGroup = new MenuGroup();
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "form.volver") );
		$menuOption->setPageName("TiposProducto");
		$menuGroup->addMenuOption( $menuOption );
		
		
		return array($menuGroup);
	}
	
	public function getTitle(){
		return $this->localize( "tipoProducto.agregar.title" );
	}

	public function getType(){
		
		return "TipoProductoAgregar";
		
	}	

	protected function parseXTemplate(XTemplate $xtpl){
		$tipoProductoForm = $this->getComponentById("tipoProductoForm");
		$tipoProductoForm->fillFromSaved( $this->getTipoProducto() );
		
	}


	public function getTipoProducto()
	{
	    return $this->TipoProducto;
	}

	public function setTipoProducto($TipoProducto)
	{
	    $this->TipoProducto = $TipoProducto;
	}
	
	
					
	public function getMsgError(){
		return "";
	}
}
?>
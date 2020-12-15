<?php
namespace Mientras\UI\pages\marcasProducto\agregar;

use Mientras\UI\pages\MientrasPage;

use Rasty\utils\XTemplate;
use Mientras\Core\model\MarcaProducto;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;

class MarcaProductoAgregar extends MientrasPage{

	/**
	 * MarcaProducto a agregar.
	 * @var MarcaProducto
	 */
	private $MarcaProducto;

	
	public function __construct(){
		
		//inicializamos el MarcaProducto.
		$MarcaProducto = new MarcaProducto();
		
		//$MarcaProducto->setNombre("Bernardo");
		//$MarcaProducto->setEmail("ber@mail.com");
		$this->setMarcaProducto($MarcaProducto);
		
		
	}
	
	public function getMenuGroups(){

		//TODO construirlo a partir del usuario 
		//y utilizando permisos
		
		$menuGroup = new MenuGroup();
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "form.volver") );
		$menuOption->setPageName("MarcasProducto");
		$menuGroup->addMenuOption( $menuOption );
		
		
		return array($menuGroup);
	}
	
	public function getTitle(){
		return $this->localize( "marcaProducto.agregar.title" );
	}

	public function getType(){
		
		return "MarcaProductoAgregar";
		
	}	

	protected function parseXTemplate(XTemplate $xtpl){
		$marcaProductoForm = $this->getComponentById("marcaProductoForm");
		$marcaProductoForm->fillFromSaved( $this->getMarcaProducto() );
		
	}


	public function getMarcaProducto()
	{
	    return $this->MarcaProducto;
	}

	public function setMarcaProducto($MarcaProducto)
	{
	    $this->MarcaProducto = $MarcaProducto;
	}
	
	
					
	public function getMsgError(){
		return "";
	}
}
?>
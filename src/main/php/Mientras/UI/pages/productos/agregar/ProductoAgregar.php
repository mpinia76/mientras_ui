<?php
namespace Mientras\UI\pages\productos\agregar;

use Mientras\UI\pages\MientrasPage;

use Rasty\utils\XTemplate;
use Mientras\Core\model\Producto;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;

class ProductoAgregar extends MientrasPage{

	/**
	 * producto a agregar.
	 * @var Producto
	 */
	private $producto;

	
	public function __construct(){
		
		//inicializamos el producto.
		$producto = new Producto();
		
		//$producto->setNombre("Bernardo");
		//$producto->setEmail("ber@mail.com");
		$this->setProducto($producto);
		
		
	}
	
	public function getMenuGroups(){

		//TODO construirlo a partir del usuario 
		//y utilizando permisos
		
		$menuGroup = new MenuGroup();
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "form.volver") );
		$menuOption->setPageName("Productos");
		$menuGroup->addMenuOption( $menuOption );
		
		
		return array($menuGroup);
	}
	
	public function getTitle(){
		return $this->localize( "producto.agregar.title" );
	}

	public function getType(){
		
		return "ProductoAgregar";
		
	}	

	protected function parseXTemplate(XTemplate $xtpl){
		$productoForm = $this->getComponentById("productoForm");
		$productoForm->fillFromSaved( $this->getProducto() );
		
	}


	public function getProducto()
	{
	    return $this->producto;
	}

	public function setProducto($producto)
	{
	    $this->producto = $producto;
	}
	
	
					
	public function getMsgError(){
		return "";
	}
}
?>
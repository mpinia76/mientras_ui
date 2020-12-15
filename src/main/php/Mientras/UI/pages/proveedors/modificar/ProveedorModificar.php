<?php
namespace Mientras\UI\pages\proveedors\modificar;

use Mientras\UI\pages\MientrasPage;

use Mientras\UI\service\UIServiceFactory;

use Rasty\utils\XTemplate;
use Mientras\Core\model\Proveedor;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;

class ProveedorModificar extends MientrasPage{

	/**
	 * proveedor a modificar.
	 * @var Proveedor
	 */
	private $proveedor;

	
	public function __construct(){
		
		//inicializamos el proveedor.
		$proveedor = new Proveedor();
		$this->setProveedor($proveedor);
				
	}
	
	public function getMenuGroups(){

		//TODO construirlo a partir del usuario 
		//y utilizando permisos
		
		$menuGroup = new MenuGroup();
		
		return array($menuGroup);
	}
	
	public function setProveedorOid($oid){
		
		//a partir del id buscamos el proveedor a modificar.
		$proveedor = UIServiceFactory::getUIProveedorService()->get($oid);
		
		$this->setProveedor($proveedor);
		
	}
	
	public function getTitle(){
		return $this->localize( "proveedor.modificar.title" );
	}

	public function getType(){
		
		return "ProveedorModificar";
		
	}	

	protected function parseXTemplate(XTemplate $xtpl){
		
	}

	public function getProveedor(){
		
	    return $this->proveedor;
	}

	public function setProveedor($proveedor)
	{
	    $this->proveedor = $proveedor;
	}
}
?>
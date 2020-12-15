<?php
namespace Mientras\UI\pages\ivas\modificar;

use Mientras\UI\pages\MientrasPage;

use Mientras\UI\service\UIServiceFactory;

use Rasty\utils\XTemplate;
use Mientras\Core\model\Iva;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;

class IvaModificar extends MientrasPage{

	/**
	 * iva a modificar.
	 * @var Iva
	 */
	private $iva;

	
	public function __construct(){
		
		//inicializamos el iva.
		$iva = new Iva();
		$this->setIva($iva);
				
	}
	
	public function getMenuGroups(){

		//TODO construirlo a partir del usuario 
		//y utilizando permisos
		
		$menuGroup = new MenuGroup();
		
		return array($menuGroup);
	}
	
	public function setIvaOid($oid){
		
		//a partir del id buscamos el iva a modificar.
		$iva = UIServiceFactory::getUIIvaService()->get($oid);
		
		$this->setIva($iva);
		
	}
	
	public function getTitle(){
		return $this->localize( "iva.modificar.title" );
	}

	public function getType(){
		
		return "IvaModificar";
		
	}	

	protected function parseXTemplate(XTemplate $xtpl){
		
	}

	public function getIva(){
		
	    return $this->iva;
	}

	public function setIva($iva)
	{
	    $this->iva = $iva;
	}
}
?>
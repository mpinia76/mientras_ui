<?php
namespace Mientras\UI\pages\gastos\agregar;

use Mientras\Core\utils\MientrasUtils;
use Mientras\UI\utils\MientrasUIUtils;

use Mientras\UI\pages\MientrasPage;

use Rasty\utils\XTemplate;
use Mientras\Core\model\Gasto;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;

class GastoAgregar extends MientrasPage{

	/**
	 * gasto a agregar.
	 * @var Gasto
	 */
	private $gasto;

	
	public function __construct(){
		
		//inicializamos el gasto.
		$gasto = new Gasto();
		
		$gasto->setFecha( new \Datetime() );
		
		$gasto->setConcepto( MientrasUtils::getConceptoGastoVarios() );
		
		$this->setGasto($gasto);

		
	}
	
	public function getMenuGroups(){

		//TODO construirlo a partir del usuario 
		//y utilizando permisos
		
		$menuGroup = new MenuGroup();
		
//		$menuOption = new MenuOption();
//		$menuOption->setLabel( $this->localize( "form.volver") );
//		$menuOption->setPageName("Gastos");
//		$menuGroup->addMenuOption( $menuOption );
//		
		
		return array($menuGroup);
	}
	
	public function getTitle(){
		return $this->localize( "gasto.agregar.title" );
	}

	public function getType(){
		
		return "GastoAgregar";
		
	}	

	protected function parseXTemplate(XTemplate $xtpl){
		
		
	}


	public function getGasto()
	{
	    return $this->gasto;
	}

	public function setGasto($gasto)
	{
	    $this->gasto = $gasto;
	}
	
	
					
	public function getMsgError(){
		return "";
	}
}
?>
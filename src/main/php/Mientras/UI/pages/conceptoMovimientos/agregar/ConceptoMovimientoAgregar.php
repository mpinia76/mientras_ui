<?php
namespace Mientras\UI\pages\conceptoMovimientos\agregar;

use Mientras\UI\pages\MientrasPage;

use Rasty\utils\XTemplate;
use Mientras\Core\model\ConceptoMovimiento;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;

class ConceptoMovimientoAgregar extends MientrasPage{

	/**
	 * ConceptoMovimiento a agregar.
	 * @var ConceptoMovimiento
	 */
	private $ConceptoMovimiento;

	
	public function __construct(){
		
		//inicializamos el ConceptoMovimiento.
		$ConceptoMovimiento = new ConceptoMovimiento();
		
		//$ConceptoMovimiento->setNombre("Bernardo");
		//$ConceptoMovimiento->setEmail("ber@mail.com");
		$this->setConceptoMovimiento($ConceptoMovimiento);
		
		
	}
	
	public function getMenuGroups(){

		//TODO construirlo a partir del usuario 
		//y utilizando permisos
		
		$menuGroup = new MenuGroup();
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "form.volver") );
		$menuOption->setPageName("ConceptoMovimientos");
		$menuGroup->addMenuOption( $menuOption );
		
		
		return array($menuGroup);
	}
	
	public function getTitle(){
		return $this->localize( "conceptoMovimiento.agregar.title" );
	}

	public function getType(){
		
		return "ConceptoMovimientoAgregar";
		
	}	

	protected function parseXTemplate(XTemplate $xtpl){
		$conceptoMovimientoForm = $this->getComponentById("conceptoMovimientoForm");
		$conceptoMovimientoForm->fillFromSaved( $this->getConceptoMovimiento() );
		
	}


	public function getConceptoMovimiento()
	{
	    return $this->ConceptoMovimiento;
	}

	public function setConceptoMovimiento($ConceptoMovimiento)
	{
	    $this->ConceptoMovimiento = $ConceptoMovimiento;
	}
	
	
					
	public function getMsgError(){
		return "";
	}
}
?>
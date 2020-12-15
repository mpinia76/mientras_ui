<?php
namespace Mientras\UI\pages\conceptoMovimientos\modificar;

use Mientras\UI\pages\MientrasPage;

use Mientras\UI\service\UIServiceFactory;

use Rasty\utils\XTemplate;
use Mientras\Core\model\ConceptoMovimiento;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;

class ConceptoMovimientoModificar extends MientrasPage{

	/**
	 * conceptoMovimiento a modificar.
	 * @var ConceptoMovimiento
	 */
	private $conceptoMovimiento;

	
	public function __construct(){
		
		//inicializamos el conceptoMovimiento.
		$conceptoMovimiento = new ConceptoMovimiento();
		$this->setConceptoMovimiento($conceptoMovimiento);
				
	}
	
	public function getMenuGroups(){

		//TODO construirlo a partir del usuario 
		//y utilizando permisos
		
		$menuGroup = new MenuGroup();
		
		return array($menuGroup);
	}
	
	public function setConceptoMovimientoOid($oid){
		
		//a partir del id buscamos el conceptoMovimiento a modificar.
		$conceptoMovimiento = UIServiceFactory::getUIConceptoMovimientoService()->get($oid);
		
		$this->setConceptoMovimiento($conceptoMovimiento);
		
	}
	
	public function getTitle(){
		return $this->localize( "conceptoMovimiento.modificar.title" );
	}

	public function getType(){
		
		return "ConceptoMovimientoModificar";
		
	}	

	protected function parseXTemplate(XTemplate $xtpl){
		
	}

	public function getConceptoMovimiento(){
		
	    return $this->conceptoMovimiento;
	}

	public function setConceptoMovimiento($conceptoMovimiento)
	{
	    $this->conceptoMovimiento = $conceptoMovimiento;
	}
}
?>
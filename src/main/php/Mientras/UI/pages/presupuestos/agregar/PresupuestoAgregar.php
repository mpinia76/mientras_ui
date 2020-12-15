<?php
namespace Mientras\UI\pages\presupuestos\agregar;

use Mientras\Core\utils\MientrasUtils;
use Mientras\UI\utils\MientrasUIUtils;

use Mientras\UI\pages\MientrasPage;

use Rasty\utils\XTemplate;
use Mientras\Core\model\Presupuesto;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;

class PresupuestoAgregar extends MientrasPage{

	/**
	 * presupuesto a agregar.
	 * @var Presupuesto
	 */
	private $presupuesto;

	
	public function __construct(){
		
		//inicializamos el presupuesto.
		$presupuesto = new Presupuesto();
		
		$presupuesto->setFecha( new \Datetime() );
		
		$presupuesto->setCliente( MientrasUtils::getClienteDefault() );
		
		$this->setPresupuesto($presupuesto);

		
	}
	
	public function getMenuGroups(){

		//TODO construirlo a partir del usuario 
		//y utilizando permisos
		
		$menuGroup = new MenuGroup();
		
//		$menuOption = new MenuOption();
//		$menuOption->setLabel( $this->localize( "form.volver") );
//		$menuOption->setPageName("Presupuestos");
//		$menuGroup->addMenuOption( $menuOption );
//		
		
		return array($menuGroup);
	}
	
	public function getTitle(){
		return $this->localize( "presupuesto.agregar.title" );
	}

	public function getType(){
		
		return "PresupuestoAgregar";
		
	}	

	protected function parseXTemplate(XTemplate $xtpl){
		
		MientrasUIUtils::setDetallesPresupuestoSession( array() );
	}


	public function getPresupuesto()
	{
	    return $this->presupuesto;
	}

	public function setPresupuesto($presupuesto)
	{
	    $this->presupuesto = $presupuesto;
	}
	
	
					
	public function getMsgError(){
		return "";
	}
}
?>
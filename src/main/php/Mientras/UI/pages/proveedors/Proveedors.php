<?php
namespace Mientras\UI\pages\proveedors;

use Mientras\UI\pages\MientrasPage;

use Mientras\UI\components\filter\model\UIProveedorCriteria;

use Mientras\UI\components\grid\model\ProveedorGridModel;

use Mientras\UI\service\UIProveedorService;

use Mientras\UI\utils\MientrasUtils;

use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;
use Rasty\i18n\Locale;

use Mientras\Core\model\Proveedor;
use Mientras\Core\criteria\ProveedorCriteria;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;


/**
 * Página para consultar los proveedors.
 * 
 * @author Marcos
 * @since 10/07/2020
 * 
 */
class Proveedors extends MientrasPage{

	
	private $proveedorCriteria;
	
	public function __construct(){
		$proveedorCriteria = new ProveedorCriteria();
		
		
		$this->setProveedorCriteria($proveedorCriteria);
	}
	
	public function getTitle(){
		return $this->localize( "proveedors.title" );
	}

	public function getMenuGroups(){

		//TODO construirlo a partir del usuario 
		//y utilizando permisos
		
		
		$menuGroup = new MenuGroup();
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "proveedor.agregar") );
		$menuOption->setPageName("ProveedorAgregar");
		$menuOption->setImageSource( $this->getWebPath() . "css/images/add_over_48.png" );
		$menuGroup->addMenuOption( $menuOption );
		
		
		
		
		
		
		return array($menuGroup);
	}
	
	public function getType(){
		
		return "Proveedors";
		
	}	

	public function getModelClazz(){
		return get_class( new ProveedorGridModel() );
	}

	public function getUicriteriaClazz(){
		return get_class( new UIProveedorCriteria() );
	}
	
	protected function parseXTemplate(XTemplate $xtpl){

		$xtpl->assign("legend_operaciones", $this->localize("grid.operaciones") );
		$xtpl->assign("legend_resultados", $this->localize("grid.resultados") );
		
		$xtpl->assign("agregar_label", $this->localize("proveedor.agregar") );
		
		$proveedorFilter = $this->getComponentById("proveedorsFilter");
		
		$proveedorFilter->fillFromSaved( $this->getProveedorCriteria() );
	}
	
	public function getProveedorCriteria()
	{
	    return $this->proveedorCriteria;
	}

	public function setProveedorCriteria($proveedorCriteria)
	{
	    $this->proveedorCriteria = $proveedorCriteria;
	}

}
?>
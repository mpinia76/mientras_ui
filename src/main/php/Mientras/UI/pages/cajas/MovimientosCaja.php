<?php
namespace Mientras\UI\pages\cajas;

use Mientras\UI\service\UIServiceFactory;

use Mientras\UI\components\filter\model\UIMovimientoCajaCriteria;

use Mientras\UI\components\grid\model\MovimientoCajaGridModel;

use Mientras\UI\pages\MientrasPage;

use Mientras\UI\utils\MientrasUtils;

use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;
use Rasty\i18n\Locale;

use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;


/**
 * Página para consultar los movimientos de caja.
 * 
 * @author Marcos
 * @since 14-03-2018
 * 
 */
class MovimientosCaja extends MientrasPage{

	
	public function __construct(){
		
	}
	
	public function getTitle(){
		return $this->localize( "caja.movimientos.title" );
	}

	public function getMenuGroups(){

		//TODO construirlo a partir del usuario 
		//y utilizando permisos
		
		$menuGroup = new MenuGroup();
		
//		$menuOption = new MenuOption();
//		$menuOption->setLabel( $this->localize( "cliente.agregar") );
//		$menuOption->setPageName("ClienteAgregar");
//		$menuOption->setImageSource( $this->getWebPath() . "css/images/add_over_48.png" );
//		$menuGroup->addMenuOption( $menuOption );
		
		
		return array($menuGroup);
	}
	
	public function getType(){
		
		return "MovimientosCaja";
		
	}	

	public function getModelClazz(){
		return get_class( new MovimientoCajaGridModel() );
	}

	public function getUicriteriaClazz(){
		return get_class( new UIMovimientoCajaCriteria() );
	}
	
	protected function parseXTemplate(XTemplate $xtpl){

		$xtpl->assign("legend_operaciones", $this->localize("grid.operaciones") );
		$xtpl->assign("legend_resultados", $this->localize("grid.resultados") );
		
		//$xtpl->assign("agregar_label", $this->localize("cliente.agregar") );
	}

//	public function getCaja(){
//
//		//lo fijamos en la cuenta BAPRO.
//		return UIServiceFactory::getUICajaService()->getCajaBAPRO();
//	}

	public function getCajaChica(){
		
		return UIServiceFactory::getUICuentaService()->getCajaChica();
	}	
}
?>
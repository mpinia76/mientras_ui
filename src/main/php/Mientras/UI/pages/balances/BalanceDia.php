<?php
namespace Mientras\UI\pages\balances;

use Mientras\UI\pages\MientrasPage;

use Mientras\UI\components\filter\model\UIProductoCriteria;



use Mientras\UI\service\UIVentaService;

use Mientras\UI\utils\MientrasUtils;

use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;
use Rasty\i18n\Locale;

use Mientras\Core\model\Caja;
use Mientras\Core\criteria\VentaCriteria;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;


/**
 * Página para consultar las balances.
 * 
 * @author Marcos
 * @since 08/10/2019
 * 
 */
class BalanceDia extends MientrasPage{

	
	
	public function __construct(){
		
	}
	
	public function getTitle(){
		return $this->localize("balanceDia.title") ;
	}

	public function getMenuGroups(){

		//TODO construirlo a partir del usuario 
		//y utilizando permisos
		
		$menuGroup = new MenuGroup();
		
		
		
		
		return array($menuGroup);
	}
	
	public function getType(){
		
		return "BalanceDia";
		
	}	

	
	public function getUicriteriaClazz(){
		return get_class( new UIProductoCriteria() );
	}
	
	protected function parseXTemplate(XTemplate $xtpl){

		$xtpl->assign("legend_operaciones", $this->localize("grid.operaciones") );
		$xtpl->assign("legend_resultados", $this->localize("grid.resultados") );
		
		
	}
	
	

}
?>
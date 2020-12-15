<?php
namespace Mientras\UI\components\grid\model;

use Mientras\UI\utils\MientrasUIUtils;

use Mientras\UI\components\grid\formats\GridImporteFormat;



use Mientras\UI\components\filter\model\UIComboCriteria;

use Rasty\factory\ComponentConfig;
use Rasty\factory\ComponentFactory;

use Mientras\Core\model\EstadoCombo;

use Rasty\Grid\entitygrid\EntityGrid;
use Rasty\Grid\entitygrid\model\EntityGridModel;
use Rasty\Grid\entitygrid\model\GridModelBuilder;
use Rasty\Grid\filter\model\UICriteria;
use Rasty\Grid\entitygrid\model\GridDatetimeFormat;
use Mientras\UI\service\UIServiceFactory;
use Rasty\utils\RastyUtils;
use Rasty\utils\Logger;

use Rasty\Menu\menu\model\MenuOption;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuActionOption;
use Rasty\Menu\menu\model\MenuActionAjaxOption;

/**
 * Model para la grilla de Combos.
 * 
 * @author Marcos
 * @since 28-08-2019
 */
class ComboGridModel extends EntityGridModel{

	public function __construct() {

        parent::__construct();
        $this->initModel();
        
    }
    
    public function getService(){
    	
    	return UIServiceFactory::getUIComboService();
    }
    
   
    
	public function getFilter(){
//    	
    	$componentConfig = new ComponentConfig();
	    $componentConfig->setId( "combosfilter" );
		$componentConfig->setType( "ComboFilter" );
//		
//		//TODO esto setearlo en el .rasty
	    return ComponentFactory::buildByType($componentConfig, $this);
	    
    	/*$filter = new UIGastoCriteria();
    	
		return $filter;  */
		
    }
    
        
	protected function initModel() {

		$this->setHasCheckboxes( false );
		
		$column = GridModelBuilder::buildColumn( "oid", "combo.oid", 20, EntityGrid::TEXT_ALIGN_RIGHT );
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "nombre", "combo.nombre", 20, EntityGrid::TEXT_ALIGN_LEFT);
		$this->addColumn( $column );
		
		
		
		
		
		$column = GridModelBuilder::buildColumn( "precio", "combo.precio", 20, EntityGrid::TEXT_ALIGN_RIGHT, new GridImporteFormat() );
		$column->setCssClass("importe");
		$this->addColumn( $column );
		
		
				
		
	}

	
	
	public function getDefaultFilterField() {
        return "fecha";
    }

	public function getDefaultOrderField(){
		return "fecha";
	}    

	public function getDefaultOrderType(){
		return "DESC";
	}
	
    /**
	 * opciones de menú dado el item
	 * @param unknown_type $item
	 */
	public function getMenuGroups( $item ){
	
		$group = new MenuGroup();
		$group->setLabel("grupo");
		$options = array();
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.combos.modificar") );
		$menuOption->setPageName( "ComboModificar" );
		$menuOption->addParam("oid",$item->getOid());
		
		$menuOption->setImageSource( $this->getWebPath() . "css/images/editar_32.png" );
		$options[] = $menuOption ;

		
		
						
		
		
		$menuOption = new MenuActionAjaxOption();
		$menuOption->setLabel( $this->localize( "menu.combo.eliminar") );
		$menuOption->setActionName( "EliminarCombo" );
		$menuOption->setConfirmMessage( $this->localize( "combo.eliminar.confirm.msg") );
		$menuOption->setConfirmTitle( $this->localize( "combo.eliminar.confirm.title") );
		$menuOption->setOnSuccessCallback( "eliminarCallback" );
		$menuOption->addParam("comboOid",$item->getOid());
		
		$menuOption->setImageSource( $this->getWebPath() . "css/images/eliminar_32.png" );
		$options[] = $menuOption ;
		
		$group->setMenuOptions( $options );
		
		return array( $group );
		
	} 
	
	
    
}
?>
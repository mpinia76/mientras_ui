<?php
namespace Mientras\UI\components\grid\model;

use Mientras\UI\components\grid\formats\GridImporteFormat;

use Mientras\UI\utils\MientrasUIUtils;

use Mientras\UI\components\filter\model\UIParametroCriteria;

use Rasty\Grid\entitygrid\EntityGrid;
use Rasty\Grid\entitygrid\model\EntityGridModel;
use Rasty\Grid\entitygrid\model\GridModelBuilder;
use Rasty\Grid\filter\model\UICriteria;

use Mientras\Core\utils\MientrasUtils;

use Mientras\UI\service\UIServiceFactory;
use Rasty\utils\RastyUtils;
use Rasty\utils\Logger;
use Rasty\security\RastySecurityContext;

use Rasty\Menu\menu\model\MenuOption;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuActionOption;
use Rasty\Menu\menu\model\MenuActionAjaxOption;

/**
 * Model para la grilla de parametros.
 * 
 * @author Marcos
 * @since 16/07/2018
 */
class ParametroGridModel extends EntityGridModel{

	public function __construct() {

        parent::__construct();
        $this->initModel();
        
    }
    
    public function getService(){
    	
    	return UIServiceFactory::getUIParametroService();
    }
    
    public function getFilter(){
    	
    	$filter = new UIParametroCriteria();
		return $filter;    	
    }
        
	protected function initModel() {

		$this->setHasCheckboxes( false );
		
		$column = GridModelBuilder::buildColumn( "oid", "parametro.oid", 20, EntityGrid::TEXT_ALIGN_RIGHT );
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "nombre", "parametro.nombre", 30, EntityGrid::TEXT_ALIGN_LEFT ) ;
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "valor", "parametro.valor", 30, EntityGrid::TEXT_ALIGN_RIGHT ) ;
		$this->addColumn( $column );
		
		
	}

	public function getDefaultFilterField() {
        return "nombre";
    }

	public function getDefaultOrderField(){
		return "nombre";
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
		$menuOption->setLabel( $this->localize( "menu.parametros.modificar") );
		$menuOption->setPageName( "ParametroModificar" );
		$menuOption->addParam("oid",$item->getOid());
		$menuOption->setImageSource( $this->getWebPath() . "css/images/editar_32.png" );
		$options[] = $menuOption ;

		
		
						
		
		
		
		
		$group->setMenuOptions( $options );
		
		return array( $group );
		
	} 
    
}
?>
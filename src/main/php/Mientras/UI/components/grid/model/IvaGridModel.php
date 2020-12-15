<?php
namespace Mientras\UI\components\grid\model;

use Mientras\UI\components\grid\formats\GridImporteFormat;

use Mientras\UI\utils\MientrasUIUtils;

use Mientras\UI\components\filter\model\UIIvaCriteria;

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
 * Model para la grilla de ivas.
 * 
 * @author Marcos
 * @since 05/03/2018
 */
class IvaGridModel extends EntityGridModel{

	public function __construct() {

        parent::__construct();
        $this->initModel();
        
    }
    
    public function getService(){
    	
    	return UIServiceFactory::getUIIvaService();
    }
    
    public function getFilter(){
    	
    	$filter = new UIIvaCriteria();
		return $filter;    	
    }
        
	protected function initModel() {

		$this->setHasCheckboxes( false );
		
		$column = GridModelBuilder::buildColumn( "oid", "iva.oid", 20, EntityGrid::TEXT_ALIGN_RIGHT );
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "nombre", "iva.nombre", 30, EntityGrid::TEXT_ALIGN_LEFT ) ;
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
		$menuOption->setLabel( $this->localize( "menu.ivas.modificar") );
		$menuOption->setPageName( "IvaModificar" );
		$menuOption->addParam("oid",$item->getOid());
		$menuOption->setImageSource( $this->getWebPath() . "css/images/editar_32.png" );
		$options[] = $menuOption ;

		
		
						
		
		
		$menuOption = new MenuActionAjaxOption();
		$menuOption->setLabel( $this->localize( "menu.iva.eliminar") );
		$menuOption->setActionName( "EliminarIva" );
		$menuOption->setConfirmMessage( $this->localize( "iva.eliminar.confirm.msg") );
		$menuOption->setConfirmTitle( $this->localize( "iva.eliminar.confirm.title") );
		$menuOption->setOnSuccessCallback( "eliminarCallback" );
		$menuOption->addParam("ivaOid",$item->getOid());
		$menuOption->setImageSource( $this->getWebPath() . "css/images/eliminar_32.png" );
		$options[] = $menuOption ;
		
		$group->setMenuOptions( $options );
		
		return array( $group );
		
	} 
    
}
?>
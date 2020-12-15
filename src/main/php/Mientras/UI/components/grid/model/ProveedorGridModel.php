<?php
namespace Mientras\UI\components\grid\model;

use Mientras\UI\components\grid\formats\GridImporteFormat;

use Mientras\UI\utils\MientrasUIUtils;

use Mientras\UI\components\filter\model\UIProveedorCriteria;

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
 * Model para la grilla de proveedors.
 * 
 * @author Marcos
 * @since 10/07/2020
 */
class ProveedorGridModel extends EntityGridModel{

	public function __construct() {

        parent::__construct();
        $this->initModel();
        
    }
    
    public function getService(){
    	
    	return UIServiceFactory::getUIProveedorService();
    }
    
    public function getFilter(){
    	
    	$filter = new UIProveedorCriteria();
		return $filter;    	
    }
        
	protected function initModel() {

		$this->setHasCheckboxes( false );
		
		$column = GridModelBuilder::buildColumn( "oid", "proveedor.oid", 20, EntityGrid::TEXT_ALIGN_RIGHT );
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "nombre", "proveedor.nombre", 30, EntityGrid::TEXT_ALIGN_LEFT ) ;
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "razonSocial", "proveedor.razonSocial", 30, EntityGrid::TEXT_ALIGN_LEFT ) ;
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "documento", "proveedor.documento", 10, EntityGrid::TEXT_ALIGN_CENTER ) ;
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "telefono", "proveedor.telefono", 30, EntityGrid::TEXT_ALIGN_RIGHT ) ;
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "celular", "proveedor.celular", 30, EntityGrid::TEXT_ALIGN_RIGHT ) ;
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "direccion", "proveedor.direccion", 30, EntityGrid::TEXT_ALIGN_LEFT) ;
		$this->addColumn( $column );
	
		/*$column = GridModelBuilder::buildColumn( "saldo", "proveedor.saldo", 30, EntityGrid::TEXT_ALIGN_RIGHT, new GridImporteFormat() ) ;
		$this->addColumn( $column );*/
		
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
		$menuOption->setLabel( $this->localize( "menu.proveedors.modificar") );
		$menuOption->setPageName( "ProveedorModificar" );
		$menuOption->addParam("oid",$item->getOid());
		$menuOption->setImageSource( $this->getWebPath() . "css/images/editar_32.png" );
		$options[] = $menuOption ;

		
		
						
		
		
		$menuOption = new MenuActionAjaxOption();
		$menuOption->setLabel( $this->localize( "menu.proveedor.eliminar") );
		$menuOption->setActionName( "EliminarProveedor" );
		$menuOption->setConfirmMessage( $this->localize( "proveedor.eliminar.confirm.msg") );
		$menuOption->setConfirmTitle( $this->localize( "proveedor.eliminar.confirm.title") );
		$menuOption->setOnSuccessCallback( "eliminarCallback" );
		$menuOption->addParam("proveedorOid",$item->getOid());
		$menuOption->setImageSource( $this->getWebPath() . "css/images/eliminar_32.png" );
		$options[] = $menuOption ;
		
	
	
		
		$group->setMenuOptions( $options );
		
		return array( $group );
		
	} 
    
}
?>
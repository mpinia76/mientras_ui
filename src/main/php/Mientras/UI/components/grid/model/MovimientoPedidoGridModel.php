<?php
namespace Mientras\UI\components\grid\model;

use Mientras\UI\components\grid\formats\GridImporteFormat;

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
 * Model para la grilla de movimientos de cuenta.
 * 
 * @author Marcos
 * @since 10/07/2020
 */
class MovimientoPedidoGridModel extends EntityGridModel{

	public function __construct() {

        parent::__construct();
        $this->initModel();
        
    }
    
    public function getService(){
    	
    	return UIServiceFactory::getUIMovimientoPedidoService();
    }
    
    public function getFilter(){
//    	
//    	$componentConfig = new ComponentConfig();
//	    $componentConfig->setId( "movimientofilter" );
//		$componentConfig->setType( "MovimientoFilter" );
//		
//		//TODO esto setearlo en el .rasty
//	    $this->filter = ComponentFactory::buildByType($componentConfig, $this);
	    
    	$filter = new UIMovimientoPedidoCriteria();
		return $filter;    	
    }
        
	protected function initModel() {

		$this->setHasCheckboxes( false );
		
		$column = GridModelBuilder::buildColumn( "oid", "movimientoCaja.oid", 20, EntityGrid::TEXT_ALIGN_RIGHT );
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "fecha", "movimientoCaja.fecha", 20, EntityGrid::TEXT_ALIGN_CENTER, new GridDatetimeFormat("d/m/Y H:i:s") );
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "descripcion", "movimientoCaja.concepto", 30, EntityGrid::TEXT_ALIGN_LEFT ) ;
		$this->addColumn( $column );

		/*$column = GridModelBuilder::buildColumn( "observaciones", "movimientoCaja.observaciones", 30, EntityGrid::TEXT_ALIGN_LEFT ) ;
		$this->addColumn( $column );*/
		
		$column = GridModelBuilder::buildColumn( "haber", "movimientoCaja.haber", 20, EntityGrid::TEXT_ALIGN_RIGHT, new GridImporteFormat() );
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "debe", "movimientoCaja.debe", 20, EntityGrid::TEXT_ALIGN_RIGHT, new GridImporteFormat() );
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "saldo", "movimientoCaja.saldo", 20, EntityGrid::TEXT_ALIGN_RIGHT, new GridImporteFormat() );
		$this->addColumn( $column );
				
	}

	public function getDefaultFilterField() {
        return "oid";
    }

	public function getDefaultOrderField(){
		return "oid";
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
		
//		$menuOption = new MenuOption();
//		$menuOption->setLabel( $this->localize( "menu.producto.modificar") );
//		$menuOption->setPageName( "ProductoModificar" );
//		$menuOption->addParam("oid",$item->getOid());
//		$menuOption->setImageSource( $this->getWebPath() . "css/images/editar_32.png" );
//		$options[] = $menuOption ;
//		
//		
		/*
		$menuOption = new MenuActionAjaxOption();
		$menuOption->setLabel( $this->localize( "menu.producto.eliminar") );
		$menuOption->setActionName( "EliminarProducto" );
		$menuOption->setConfirmMessage( $this->localize( "producto.eliminar.confirm.msg") );
		$menuOption->setConfirmTitle( $this->localize( "producto.eliminar.confirm.title") );
		$menuOption->setOnSuccessCallback( "eliminarCallback" );
		$menuOption->addParam("oid",$item->getOid());
		$menuOption->setImageSource( $this->getWebPath() . "css/images/eliminar_32.png" );
		$options[] = $menuOption ;
		*/
		$group->setMenuOptions( $options );
		
		return array( $group );
		
	} 
    
}
?>
<?php
namespace Mientras\UI\components\grid\model;

use Mientras\UI\utils\MientrasUIUtils;

use Mientras\UI\components\grid\formats\GridImporteFormat;

use Mientras\UI\components\grid\formats\GridEstadoGastoFormat;

use Mientras\UI\components\filter\model\UIGastoCriteria;

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
 * Model para la grilla de Gastos.
 * 
 * @author Bernardo
 * @since 28/05/2014
 */
class GastoGridModel extends EntityGridModel{

	public function __construct() {

        parent::__construct();
        $this->initModel();
        
    }
    
    public function getService(){
    	
    	return UIServiceFactory::getUIGastoService();
    }
    
    public function getFilter(){
//    	
//    	$componentConfig = new ComponentConfig();
//	    $componentConfig->setId( "movimientofilter" );
//		$componentConfig->setType( "MovimientoFilter" );
//		
//		//TODO esto setearlo en el .rasty
//	    $this->filter = ComponentFactory::buildByType($componentConfig, $this);
	    
    	$filter = new UIGastoCriteria();
		return $filter;    	
    }
        
	protected function initModel() {

		$this->setHasCheckboxes( false );
		
		$column = GridModelBuilder::buildColumn( "oid", "gasto.oid", 20, EntityGrid::TEXT_ALIGN_RIGHT );
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "fecha", "gasto.fecha", 20, EntityGrid::TEXT_ALIGN_CENTER, new GridDatetimeFormat("d/m/Y H:i:s") );
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "fechaVencimiento", "gasto.fechaVencimiento", 20, EntityGrid::TEXT_ALIGN_CENTER, new GridDatetimeFormat("d/m/Y") );
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "concepto", "gasto.concepto", 30, EntityGrid::TEXT_ALIGN_LEFT ) ;
		$this->addColumn( $column );

		$column = GridModelBuilder::buildColumn( "monto", "gasto.monto", 20, EntityGrid::TEXT_ALIGN_RIGHT, new GridImporteFormat() );
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "observaciones", "gasto.observaciones", 20, EntityGrid::TEXT_ALIGN_LEFT );
		$this->addColumn( $column );

		$column = GridModelBuilder::buildColumn( "estado", "gasto.estado", 20, EntityGrid::TEXT_ALIGN_LEFT, new GridEstadoGastoFormat() );
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
		
		if( $item->podesAnularte() ){
			$menuOption = new MenuOption();
			$menuOption->setLabel( $this->localize( "menu.gastos.anular") );
			$menuOption->setPageName( "GastoAnular" );
			$menuOption->addParam("gastoOid",$item->getOid());
			//$menuOption->setImageSource( $this->getWebPath() . "css/images/anular_32.png" );
			$menuOption->setIconClass( "icon-anular" );
			$options[] = $menuOption ;
		}
		
		if( $item->podesPagarte() ){
			$menuOption = new MenuOption();
			$menuOption->setLabel( $this->localize( "menu.gastos.pagar") );
			$menuOption->setPageName( "GastoPagar" );
			$menuOption->addParam("gastoOid",$item->getOid());
			//$menuOption->setImageSource( $this->getWebPath() . "css/images/pagar_32.png" );
			$menuOption->setIconClass( "icon-pagar fg-green" );
			$options[] = $menuOption ;
		}
		
		
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
	
	public function getRowStyleClass($item){
		
		//return MientrasUIUtils::getEstadoGastoCss($item->getEstado());
		
	}
	
}
?>
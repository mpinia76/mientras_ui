<?php
namespace Mientras\UI\components\grid\model;

use Mientras\UI\utils\MientrasUIUtils;

use Mientras\UI\components\grid\formats\GridImporteFormat;

use Mientras\UI\components\grid\formats\GridEstadoVentaFormat;

use Mientras\UI\components\filter\model\UIVentaCriteria;

use Rasty\factory\ComponentConfig;
use Rasty\factory\ComponentFactory;

use Mientras\Core\model\EstadoVenta;

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
 * Model para la grilla de Ventas.
 * 
 * @author Bernardo
 * @since 13-06-2014
 */
class VentaGridModel extends EntityGridModel{

	public function __construct() {

        parent::__construct();
        $this->initModel();
        
    }
    
    public function getService(){
    	
    	return UIServiceFactory::getUIVentaService();
    }
    
   
    
	public function getFilter(){
//    	
    	$componentConfig = new ComponentConfig();
	    $componentConfig->setId( "ventasfilter" );
		$componentConfig->setType( "VentaFilter" );
//		
//		//TODO esto setearlo en el .rasty
	    return ComponentFactory::buildByType($componentConfig, $this);
	    
    	/*$filter = new UIGastoCriteria();
    	
		return $filter;  */
		
    }
    
        
	protected function initModel() {

		$this->setHasCheckboxes( false );
		
		$column = GridModelBuilder::buildColumn( "oid", "venta.oid", 20, EntityGrid::TEXT_ALIGN_RIGHT );
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "fecha", "venta.fecha", 20, EntityGrid::TEXT_ALIGN_CENTER, new GridDatetimeFormat("d/m/Y H:i:s") );
		$this->addColumn( $column );
		
		
		
		$column = GridModelBuilder::buildColumn( "cliente", "venta.cliente", 20, EntityGrid::TEXT_ALIGN_LEFT );
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "monto", "venta.monto", 20, EntityGrid::TEXT_ALIGN_RIGHT, new GridImporteFormat() );
		$column->setCssClass("importe");
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "montoActualizado", "venta.montoActualizado", 20, EntityGrid::TEXT_ALIGN_RIGHT, new GridImporteFormat() );
		$column->setCssClass("importe");
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "montoPagado", "venta.montoPagado", 20, EntityGrid::TEXT_ALIGN_RIGHT, new GridImporteFormat() );
		$column->setCssClass("importe");
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "montoDebe", "venta.montoDebe", 20, EntityGrid::TEXT_ALIGN_RIGHT, new GridImporteFormat() );
		$column->setCssClass("importe");
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "observaciones", "venta.observaciones", 20, EntityGrid::TEXT_ALIGN_LEFT );
		$this->addColumn( $column );

		$column = GridModelBuilder::buildColumn( "estado", "venta.estado", 20, EntityGrid::TEXT_ALIGN_LEFT, new GridEstadoVentaFormat() );
		$this->addColumn( $column );
				
		
	}

	public function getRowStyleClass($item){
		
		return MientrasUIUtils::getEstadoVentaCss($item->getEstado());
		
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
			$menuOption->setLabel( $this->localize( "menu.ventas.anular") );
			$menuOption->setPageName( "VentaAnular" );
			$menuOption->addParam("ventaOid",$item->getOid());
			$menuOption->setIconClass( "icon-anular" );
			$options[] = $menuOption ;
		}
		
		if( $item->podesCobrarte() ){
			$menuOption = new MenuOption();
			$menuOption->setLabel( $this->localize( "menu.ventas.cobrar") );
			$menuOption->setPageName( "VentaCobrar" );
			$menuOption->addParam("ventaOid",$item->getOid());
			$menuOption->setIconClass( "icon-cobrar-venta fg-green" );
			$options[] = $menuOption ;
			
		}
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.ventas.pdf") );
		$menuOption->setPdf(1);
		$menuOption->setTarget("_blank");
		$menuOption->setPageName( "VentaPDF" );
		$menuOption->addParam("ventaOid",$item->getOid());
		$menuOption->setImageSource( $this->getWebPath() . "css/images/pdf_16.png" );
		$options[] = $menuOption ;
		
		
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.ventas.devolver") );
		$menuOption->setPageName( "VentaDevolver" );
		$menuOption->addParam("ventaOid",$item->getOid());
		$menuOption->setImageSource( $this->getWebPath() . "css/images/movimientos_16.png" );
		$options[] = $menuOption ;
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.ventas.agregar.productos") );
		$menuOption->setPageName( "VentaAgregarProducto" );
		$menuOption->addParam("ventaOid",$item->getOid());
		$menuOption->setIconClass( "icon-agregar" );
		$options[] = $menuOption ;
		
		
		$group->setMenuOptions( $options );
		
		return array( $group );
		
	} 
	
	public function getHeaderContent(){
		/*$filter = $this->getFilter();
		$filter->fill( $this->getDefaultOrderField(), $this->getDefaultOrderType() );
		//print_r($filter->getCriteria());
		$service = $this->getService();
			
		
			
		
		
		
		return 'Bruto: <strong>'.MientrasUIUtils::formatMontoToView($service->getTotales($filter->getCriteria())).'</strong> Neto: <strong>'.MientrasUIUtils::formatMontoToView($service->getGanancias($filter->getCriteria())).'</strong>';*/
	}
    
}
?>
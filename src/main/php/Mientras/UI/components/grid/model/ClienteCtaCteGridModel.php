<?php
namespace Mientras\UI\components\grid\model;

use Mientras\UI\components\grid\formats\GridImporteFormat;

use Mientras\UI\utils\MientrasUIUtils;

use Mientras\UI\components\filter\model\UIClienteCriteria;

use Rasty\factory\ComponentConfig;
use Rasty\factory\ComponentFactory;

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
 * Model para la grilla de clientes.
 * 
 * @author Marcos
 * @since 12/09/2019
 */
class ClienteCtaCteGridModel extends EntityGridModel{

	public function __construct() {

        parent::__construct();
        $this->initModel();
        
    }
    
    public function getService(){
    	
    	return UIServiceFactory::getUIClienteService();
    }
    
    public function getFilter(){
    	
    	
		
		$componentConfig = new ComponentConfig();
	    $componentConfig->setId( "clientesfilter" );
		$componentConfig->setType( "ClienteFilter" );
//		
//		//TODO esto setearlo en el .rasty
	    return ComponentFactory::buildByType($componentConfig, $this);
		
    }
        
	protected function initModel() {

		$this->setHasCheckboxes( false );
		
		$column = GridModelBuilder::buildColumn( "oid", "cliente.oid", 20, EntityGrid::TEXT_ALIGN_RIGHT );
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "nombre", "cliente.nombre", 30, EntityGrid::TEXT_ALIGN_LEFT ) ;
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "documento", "cliente.documento", 10, EntityGrid::TEXT_ALIGN_CENTER ) ;
		$this->addColumn( $column );
		
		
	
		$column = GridModelBuilder::buildColumn( "saldo", "cliente.saldo", 30, EntityGrid::TEXT_ALIGN_RIGHT, new GridImporteFormat() ) ;
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
		
		
		
	
	//si tiene cta cte mostramos el link
		if( $item->hasCuentaCorriente() ){
			
			$menuOption = new MenuOption();
			$menuOption->setLabel( $this->localize( "menu.clientes.cuentaCorriente") );
			$menuOption->setPageName( "MovimientosCtaCte" );
			$menuOption->addParam("oid",$item->getCuentaCorriente()->getOid());
			$menuOption->setImageSource( $this->getWebPath() . "css/images/ctacte_32.png" );
			$options[] = $menuOption ;
			
		}
		
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.cobrarCuentaCorriente") );
		$menuOption->setPageName( "CobrarCtaCte" );
		$menuOption->addParam("clienteOid",$item->getOid());
		$menuOption->setImageSource( $this->getWebPath() . "css/images/cobros_48.png" );
		$options[] = $menuOption ;
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.actualizarCuentaCorriente") );
		$menuOption->setPageName( "ActualizarCtaCte" );
		$menuOption->addParam("clienteOid",$item->getOid());
		$menuOption->setImageSource( $this->getWebPath() . "css/images/gastos_32.png" );
		$options[] = $menuOption ;
		
		
		$group->setMenuOptions( $options );
		
		return array( $group );
		
	} 
	
	public function getHeaderContent(){
		$filter = $this->getFilter();
		$filter->fill( $this->getDefaultOrderField(), $this->getDefaultOrderType() );
		
		$service = $this->getService();
			
		
			
		
		
		
		return 'Total: '.MientrasUIUtils::formatMontoToView($service->getTotalCtaCte($filter->getCriteria()));
	}
    
    
}
?>
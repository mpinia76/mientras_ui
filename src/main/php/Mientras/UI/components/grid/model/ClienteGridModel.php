<?php
namespace Mientras\UI\components\grid\model;

use Mientras\UI\components\grid\formats\GridImporteFormat;

use Mientras\UI\utils\MientrasUIUtils;

use Mientras\UI\components\filter\model\UIClienteCriteria;

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
 * @since 02/03/2018
 */
class ClienteGridModel extends EntityGridModel{

	public function __construct() {

        parent::__construct();
        $this->initModel();
        
    }
    
    public function getService(){
    	
    	return UIServiceFactory::getUIClienteService();
    }
    
    public function getFilter(){
    	
    	$filter = new UIClienteCriteria();
		return $filter;    	
    }
        
	protected function initModel() {

		$this->setHasCheckboxes( false );
		
		$column = GridModelBuilder::buildColumn( "oid", "cliente.oid", 20, EntityGrid::TEXT_ALIGN_RIGHT );
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "nombre", "cliente.nombre", 30, EntityGrid::TEXT_ALIGN_LEFT ) ;
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "documento", "cliente.documento", 10, EntityGrid::TEXT_ALIGN_CENTER ) ;
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "telefono", "cliente.telefono", 30, EntityGrid::TEXT_ALIGN_RIGHT ) ;
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "celular", "cliente.celular", 30, EntityGrid::TEXT_ALIGN_RIGHT ) ;
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "direccion", "cliente.direccion", 30, EntityGrid::TEXT_ALIGN_LEFT) ;
		$this->addColumn( $column );
	
		/*$column = GridModelBuilder::buildColumn( "saldo", "cliente.saldo", 30, EntityGrid::TEXT_ALIGN_RIGHT, new GridImporteFormat() ) ;
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
		$menuOption->setLabel( $this->localize( "menu.clientes.modificar") );
		$menuOption->setPageName( "ClienteModificar" );
		$menuOption->addParam("oid",$item->getOid());
		$menuOption->setImageSource( $this->getWebPath() . "css/images/editar_32.png" );
		$options[] = $menuOption ;

		
		
						
		
		
		$menuOption = new MenuActionAjaxOption();
		$menuOption->setLabel( $this->localize( "menu.cliente.eliminar") );
		$menuOption->setActionName( "EliminarCliente" );
		$menuOption->setConfirmMessage( $this->localize( "cliente.eliminar.confirm.msg") );
		$menuOption->setConfirmTitle( $this->localize( "cliente.eliminar.confirm.title") );
		$menuOption->setOnSuccessCallback( "eliminarCallback" );
		$menuOption->addParam("clienteOid",$item->getOid());
		$menuOption->setImageSource( $this->getWebPath() . "css/images/eliminar_32.png" );
		$options[] = $menuOption ;
		
	
	//si tiene cta cte mostramos el link
		if( $item->hasCuentaCorriente() ){
			
			$menuOption = new MenuOption();
			$menuOption->setLabel( $this->localize( "menu.clientes.cuentaCorriente") );
			$menuOption->setPageName( "MovimientosCtaCte" );
			$menuOption->addParam("oid",$item->getCuentaCorriente()->getOid());
			$menuOption->setImageSource( $this->getWebPath() . "css/images/ctacte_32.png" );
			$options[] = $menuOption ;
			
		}else{

			//si es administrador le dejamos crear la cuenta corriente
			
			if( MientrasUIUtils::isAdminLogged() ){
				$menuOption = new MenuActionAjaxOption();
				$menuOption->setLabel( $this->localize( "menu.clientes.cuentaCorriente.agregar") );
				$menuOption->setActionName( "AgregarCuentaCorrienteJson" );
				$menuOption->setConfirmMessage( $this->localize( "cliente.cuentaCorriente.agregar.confirm.msg") );
				$menuOption->setConfirmTitle( $this->localize( "cliente.cuentaCorriente.agregar.confirm.title") );
				$menuOption->setOnSuccessCallback( "cuentaCorrienteAgregarCallback" );
				$menuOption->addParam("clienteOid",$item->getOid());
				$menuOption->setImageSource( $this->getWebPath() . "css/images/add_over.png" );
				$options[] = $menuOption ;
					
			}
			
					
			
		}
		
		$group->setMenuOptions( $options );
		
		return array( $group );
		
	} 
    
}
?>
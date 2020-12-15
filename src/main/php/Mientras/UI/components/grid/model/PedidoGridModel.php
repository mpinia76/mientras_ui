<?php
namespace Mientras\UI\components\grid\model;

use Mientras\UI\utils\MientrasUIUtils;

use Mientras\UI\components\grid\formats\GridImporteFormat;

use Mientras\UI\components\grid\formats\GridEstadoPedidoFormat;

use Mientras\UI\components\filter\model\UIPedidoCriteria;

use Mientras\Core\model\EstadoPedido;

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
 * Model para la grilla de Pedidos.
 *
 * @author Marcos
 * @since 10/07/2020
 */
class PedidoGridModel extends EntityGridModel{

	public function __construct() {

        parent::__construct();
        $this->initModel();

    }

    public function getService(){

    	return UIServiceFactory::getUIPedidoService();
    }

    public function getFilter(){
//
//    	$componentConfig = new ComponentConfig();
//	    $componentConfig->setId( "movimientofilter" );
//		$componentConfig->setType( "MovimientoFilter" );
//
//		//TODO esto setearlo en el .rasty
//	    $this->filter = ComponentFactory::buildByType($componentConfig, $this);

    	$filter = new UIPedidoCriteria();
		return $filter;
    }

	protected function initModel() {

		$this->setHasCheckboxes( false );

		$column = GridModelBuilder::buildColumn( "oid", "pedido.oid", 20, EntityGrid::TEXT_ALIGN_RIGHT );
		$this->addColumn( $column );

        $column = GridModelBuilder::buildColumn( "proveedor", "pedido.proveedor", 20, EntityGrid::TEXT_ALIGN_LEFT );
        $this->addColumn( $column );

		$column = GridModelBuilder::buildColumn( "fechaHora", "pedido.fechaHora", 20, EntityGrid::TEXT_ALIGN_CENTER, new GridDatetimeFormat("d/m/Y H:i") );
		$this->addColumn( $column );

		$column = GridModelBuilder::buildColumn( "fechaHoraRecibido", "pedido.fechaHoraRecibido", 20, EntityGrid::TEXT_ALIGN_CENTER, new GridDatetimeFormat("d/m/Y H:i") );
		$this->addColumn( $column );

		$column = GridModelBuilder::buildColumn( "monto", "pedido.monto", 20, EntityGrid::TEXT_ALIGN_RIGHT, new GridImporteFormat() );
		$this->addColumn( $column );

		$column = GridModelBuilder::buildColumn( "observaciones", "pedido.observaciones", 20, EntityGrid::TEXT_ALIGN_LEFT );
		$this->addColumn( $column );

		$column = GridModelBuilder::buildColumn( "estado", "pedido.estado", 20, EntityGrid::TEXT_ALIGN_LEFT, new GridEstadoPedidoFormat() );
		$this->addColumn( $column );


	}

	public function getDefaultFilterField() {
        return "fechaHora";
    }

	public function getDefaultOrderField(){
		return "fechaHora";
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
			$menuOption->setLabel( $this->localize( "menu.pedidos.anular") );
			$menuOption->setPageName( "PedidoAnular" );
			$menuOption->addParam("pedidoOid",$item->getOid());
			//$menuOption->setImageSource( $this->getWebPath() . "css/images/anular_32.png" );
			$menuOption->setIconClass( "icon-anular fg-red" );
			$options[] = $menuOption ;
		}

		if( $item->podesPagarte() ){
			$menuOption = new MenuOption();
			$menuOption->setLabel( $this->localize( "menu.pedidos.pagar") );
			$menuOption->setPageName( "PedidoPagar" );
			$menuOption->addParam("pedidoOid",$item->getOid());
			//$menuOption->setImageSource( $this->getWebPath() . "css/images/pagar_32.png" );
			$menuOption->setIconClass( "icon-pagar fg-green" );
			$options[] = $menuOption ;
		}

		if( $item->podesRecibirte() ){
			$menuOption = new MenuOption();
			$menuOption->setLabel( $this->localize( "menu.pedidos.recibir") );
			$menuOption->setPageName( "PedidoRecibir" );
			$menuOption->addParam("pedidoOid",$item->getOid());
			$menuOption->setIconClass( "icon-recibir-pedido fg-darkBlue" );
			$options[] = $menuOption ;

		}elseif( $item->podesAnularRecepcion() ){
			$menuOption = new MenuOption();
			$menuOption->setLabel( $this->localize( "menu.pedidos.anularRecibir") );
			$menuOption->setPageName( "PedidoAnularRecibir" );
			$menuOption->addParam("pedidoOid",$item->getOid());
			$menuOption->setIconClass( "icon-anularRecibir-pedido fg-red" );
			$options[] = $menuOption ;
		}

		$group->setMenuOptions( $options );

		return array( $group );

	}

	public function getRowStyleClass($item){

		return MientrasUIUtils::getEstadoPedidoCss($item->getEstado());

	}
}
?>

<?php

namespace Mientras\UI\components\filter\movimiento;


use Mientras\UI\service\UIServiceFactory;

use Mientras\UI\utils\MientrasUIUtils;

use Mientras\UI\components\grid\model\MovimientoPedidoGridModel;

use Mientras\UI\components\filter\model\UIMovimientoPedidoCriteria;


use Rasty\Grid\filter\Filter;
use Rasty\utils\XTemplate;
use Rasty\utils\LinkBuilder;

/**
 * Filtro para buscar movimientos de Pedido
 * 
 * @author Marcos
 * @since 10-07-2020
 */
class MovimientoPedidoFilter extends Filter{
		
	
	
	public function getType(){
		
		return "MovimientoPedidoFilter";
	}
	
	public function __construct(){
		
		parent::__construct();
		
		$this->setGridModelClazz( get_class( new MovimientoPedidoGridModel() ));
		
		$this->setUicriteriaClazz( get_class( new UIMovimientoPedidoCriteria()) );
		
		
		$this->addProperty("fechaDesde");
		$this->addProperty("fechaHasta");
		
	}
	
	protected function parseXTemplate(XTemplate $xtpl){

		//rellenamos el banco con bapro
		//$this->fillInput("cuenta", UIServiceFactory::getUIBancoService()->getCajaBAPRO() );
		
		parent::parseXTemplate($xtpl);

		$xtpl->assign("lbl_fechaDesde",  $this->localize( "criteria.fechaDesde" ) );
		$xtpl->assign("lbl_fechaHasta",  $this->localize( "criteria.fechaHasta" ) );
		
		
	}
	
	
	
}
?>
<?php

namespace Mientras\UI\components\filter\movimiento;

use Mientras\UI\service\UIServiceFactory;

use Mientras\UI\utils\MientrasUIUtils;

use Mientras\UI\components\grid\model\MovimientoCajaGridModel;

use Mientras\UI\components\filter\model\UIMovimientoCajaCriteria;

use Mientras\UI\components\filter\model\UIMovimientoCriteria;

use Mientras\UI\components\grid\model\MovimientoGridModel;

use Rasty\Grid\filter\Filter;
use Rasty\utils\XTemplate;
use Rasty\utils\LinkBuilder;

/**
 * Filtro para buscar movimientos de Caja
 * 
 * @author Marcos
 * @since 14-03-2018
 */
class MovimientoCajaFilter extends MovimientoFilter{
		
	
	public function getType(){
		
		return "MovimientoCajaFilter";
	}
	
	
	protected function parseXTemplate(XTemplate $xtpl){

		//rellenamos el nombre con el texto inicial
		//$this->fillInput("cuenta", MientrasUIUtils::getCaja() );
		
		parent::parseXTemplate($xtpl);
		
		$xtpl->assign("lbl_saldo",  $this->localize( "cuenta.saldo" ) );
		
			
	}
	
}
?>
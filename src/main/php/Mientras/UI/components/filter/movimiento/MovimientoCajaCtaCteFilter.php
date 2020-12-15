<?php

namespace Mientras\UI\components\filter\movimiento;


use Mientras\UI\service\UIServiceFactory;

use Mientras\UI\utils\MientrasUIUtils;

use Mientras\UI\components\grid\model\MovimientoCajaCtaCteGridModel;

use Mientras\UI\components\filter\model\UIMovimientoCajaCriteria;
use Mientras\UI\components\filter\model\UICuentaCorrienteCriteria;

use Rasty\Grid\filter\Filter;
use Rasty\utils\XTemplate;
use Rasty\utils\LinkBuilder;

/**
 * Filtro para buscar movimientos de Caja
 * 
 * @author Marcos
 * @since 07-04-2018
 */
class MovimientoCajaCtaCteFilter extends Filter{
		
	
	
	public function getType(){
		
		return "MovimientoCajaCtaCteFilter";
	}
	
	public function __construct(){
		
		parent::__construct();
		
		$this->setGridModelClazz( get_class( new MovimientoCajaCtaCteGridModel() ));
		
		$this->setUicriteriaClazz( get_class( new UIMovimientoCajaCriteria()) );
		
		
		$this->addProperty("fechaDesde");
		$this->addProperty("fechaHasta");
		//$this->addProperty("cuentas");
	}
	
	
	public function fillEntity($entity){
		
		parent::fillEntity($entity);
		
		
		$ctasctes = UIServiceFactory::getUICuentaCorrienteService()->getList( new UICuentaCorrienteCriteria() );
		$arrayCtasctes = array();
		foreach ($ctasctes as $ctacte) {
			$arrayCtasctes[] = $ctacte->getOid();;
		}
	
	
		
		$entity->setCuentas( $arrayCtasctes );		
		
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
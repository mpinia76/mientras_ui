<?php

namespace Mientras\UI\components\filter\gasto;

use Mientras\UI\components\filter\model\UIGastoCriteria;
use Mientras\UI\service\finder\ConceptoGastoFinder;
use Mientras\UI\service\UIServiceFactory;
use Mientras\UI\components\filter\model\UIConceptoGastoCriteria;

use Mientras\UI\components\grid\model\GastoGridModel;

use Rasty\Grid\filter\Filter;
use Rasty\utils\XTemplate;
use Rasty\utils\LinkBuilder;

/**
 * Filtro para buscar gastos
 * 
 * @author Marcos
 * @since 12/03/2018
 */
class GastoFilter extends Filter{
		
	public function getType(){
		
		return "GastoFilter";
	}
	

	public function __construct(){
		
		parent::__construct();
		
		$this->setGridModelClazz( get_class( new GastoGridModel() ));
		
		$this->setUicriteriaClazz( get_class( new UIGastoCriteria()) );
		
		//$this->setSelectRowCallback("seleccionarGasto");
		
		//agregamos las propiedades a popular en el submit.
		$this->addProperty("fechaDesde");
		$this->addProperty("fechaHasta");
		$this->addProperty("concepto");
		$this->addProperty("filtroPredefinido");
		$this->addProperty("observaciones");
	}
	
	protected function parseXTemplate(XTemplate $xtpl){

		//rellenamos el nombre con el texto inicial
		//$this->fillInput("nombre", $this->getInitialText() );
		
		parent::parseXTemplate($xtpl);
		
		$xtpl->assign("lbl_fechaDesde",  $this->localize("criteria.fechaDesde") );
		$xtpl->assign("lbl_fechaHasta",  $this->localize("criteria.fechaHasta") );
		$xtpl->assign("lbl_concepto", $this->localize("gasto.concepto") );
		$xtpl->assign("lbl_observaciones", $this->localize("gasto.observaciones") );
				
		$xtpl->assign("lbl_predefinidos",  $this->localize("criteria.predefinidos") );
		
		//$xtpl->assign("linkSeleccionar",  LinkBuilder::getPageUrl( "HistoriaClinica") );
		$xtpl->assign("linkSeleccionar",  LinkBuilder::getPageUrl( "GastoModificar") );
		
		
	}
	
	public function getFiltrosPredefinidos(){
		
		$items = array();
		
		$items[ UIGastoCriteria::POR_VENCER ] = $this->localize("gasto.filter.porVencer");
		$items[ UIGastoCriteria::IMPAGOS ] = $this->localize("gasto.filter.impagos");
		$items[ UIGastoCriteria::HOY ] = $this->localize("gasto.filter.hoy");
		$items[ UIGastoCriteria::SEMANA_ACTUAL ] = $this->localize("gasto.filter.semanaActual");
		$items[ UIGastoCriteria::MES_ACTUAL ] = $this->localize("gasto.filter.mesActual");
		$items[ UIGastoCriteria::ANIO_ACTUAL ] = $this->localize("gasto.filter.anioActual");
		
		
		return $items;
		
	}
	
	public function getConceptos(){
		
		$conceptos = UIServiceFactory::getUIConceptoGastoService()->getList( new UIConceptoGastoCriteria() );
		
		return $conceptos;
		
	}
	
	public function getConceptoGastoFinderClazz(){
		
		return get_class( new ConceptoGastoFinder() );
		
	}	
	
}
?>
<?php

namespace Mientras\UI\components\filter\conceptoMovimiento;

use Mientras\UI\components\filter\model\UIConceptoMovimientoCriteria;

use Mientras\UI\components\grid\model\ConceptoMovimientoGridModel;

use Rasty\Grid\filter\Filter;
use Rasty\utils\XTemplate;
use Rasty\utils\LinkBuilder;

/**
 * Filtro para buscar conceptoMovimientos
 * 
 * @author Marcos
 * @since 12/03/2018
 */
class ConceptoMovimientoFilter extends Filter{
		
	public function getType(){
		
		return "ConceptoMovimientoFilter";
	}
	

	public function __construct(){
		
		parent::__construct();
		
		$this->setGridModelClazz( get_class( new ConceptoMovimientoGridModel() ));
		
		$this->setUicriteriaClazz( get_class( new UIConceptoMovimientoCriteria()) );
		
		//$this->setSelectRowCallback("seleccionarConceptoMovimiento");
		
		//agregamos las propiedades a popular en el submit.
		$this->addProperty("nombre");
		
	}
	
	protected function parseXTemplate(XTemplate $xtpl){

		//rellenamos el nombre con el texto inicial
		$this->fillInput("nombre", $this->getInitialText() );
		
		parent::parseXTemplate($xtpl);
		
		$xtpl->assign("lbl_nombre",  $this->localize("conceptoMovimiento.nombre") );
		
		//$xtpl->assign("linkSeleccionar",  LinkBuilder::getPageUrl( "HistoriaClinica") );
		$xtpl->assign("linkSeleccionar",  LinkBuilder::getPageUrl( "ConceptoMovimientoModificar") );
		
		
	}
}
?>
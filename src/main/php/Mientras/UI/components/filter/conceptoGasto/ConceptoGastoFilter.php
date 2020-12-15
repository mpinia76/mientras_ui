<?php

namespace Mientras\UI\components\filter\conceptoGasto;

use Mientras\UI\components\filter\model\UIConceptoGastoCriteria;

use Mientras\UI\components\grid\model\ConceptoGastoGridModel;

use Rasty\Grid\filter\Filter;
use Rasty\utils\XTemplate;
use Rasty\utils\LinkBuilder;

/**
 * Filtro para buscar conceptoGastos
 * 
 * @author Marcos
 * @since 05/03/2018
 */
class ConceptoGastoFilter extends Filter{
		
	public function getType(){
		
		return "ConceptoGastoFilter";
	}
	

	public function __construct(){
		
		parent::__construct();
		
		$this->setGridModelClazz( get_class( new ConceptoGastoGridModel() ));
		
		$this->setUicriteriaClazz( get_class( new UIConceptoGastoCriteria()) );
		
		//$this->setSelectRowCallback("seleccionarConceptoGasto");
		
		//agregamos las propiedades a popular en el submit.
		$this->addProperty("nombre");
		
	}
	
	protected function parseXTemplate(XTemplate $xtpl){

		//rellenamos el nombre con el texto inicial
		$this->fillInput("nombre", $this->getInitialText() );
		
		parent::parseXTemplate($xtpl);
		
		$xtpl->assign("lbl_nombre",  $this->localize("conceptoGasto.nombre") );
		
		//$xtpl->assign("linkSeleccionar",  LinkBuilder::getPageUrl( "HistoriaClinica") );
		$xtpl->assign("linkSeleccionar",  LinkBuilder::getPageUrl( "ConceptoGastoModificar") );
		
		
	}
}
?>
<?php

namespace Mientras\UI\components\filter\parametro;

use Mientras\UI\components\filter\model\UIParametroCriteria;

use Mientras\UI\components\grid\model\ParametroGridModel;

use Rasty\Grid\filter\Filter;
use Rasty\utils\XTemplate;
use Rasty\utils\LinkBuilder;

/**
 * Filtro para buscar parametros
 * 
 * @author Marcos
 * @since 16/07/2018
 */
class ParametroFilter extends Filter{
		
	public function getType(){
		
		return "ParametroFilter";
	}
	

	public function __construct(){
		
		parent::__construct();
		
		$this->setGridModelClazz( get_class( new ParametroGridModel() ));
		
		$this->setUicriteriaClazz( get_class( new UIParametroCriteria()) );
		
		//$this->setSelectRowCallback("seleccionarParametro");
		
		//agregamos las propiedades a popular en el submit.
		$this->addProperty("nombre");
		
	}
	
	protected function parseXTemplate(XTemplate $xtpl){

		//rellenamos el nombre con el texto inicial
		$this->fillInput("nombre", $this->getInitialText() );
		
		parent::parseXTemplate($xtpl);
		
		$xtpl->assign("lbl_nombre",  $this->localize("parametro.nombre") );
		
		//$xtpl->assign("linkSeleccionar",  LinkBuilder::getPageUrl( "HistoriaClinica") );
		$xtpl->assign("linkSeleccionar",  LinkBuilder::getPageUrl( "ParametroModificar") );
		
		
	}
}
?>
<?php

namespace Mientras\UI\components\filter\iva;

use Mientras\UI\components\filter\model\UIIvaCriteria;

use Mientras\UI\components\grid\model\IvaGridModel;

use Rasty\Grid\filter\Filter;
use Rasty\utils\XTemplate;
use Rasty\utils\LinkBuilder;

/**
 * Filtro para buscar ivas
 * 
 * @author Marcos
 * @since 05/03/2018
 */
class IvaFilter extends Filter{
		
	public function getType(){
		
		return "IvaFilter";
	}
	

	public function __construct(){
		
		parent::__construct();
		
		$this->setGridModelClazz( get_class( new IvaGridModel() ));
		
		$this->setUicriteriaClazz( get_class( new UIIvaCriteria()) );
		
		//$this->setSelectRowCallback("seleccionarIva");
		
		//agregamos las propiedades a popular en el submit.
		$this->addProperty("nombre");
		
	}
	
	protected function parseXTemplate(XTemplate $xtpl){

		//rellenamos el nombre con el texto inicial
		$this->fillInput("nombre", $this->getInitialText() );
		
		parent::parseXTemplate($xtpl);
		
		$xtpl->assign("lbl_nombre",  $this->localize("iva.nombre") );
		
		//$xtpl->assign("linkSeleccionar",  LinkBuilder::getPageUrl( "HistoriaClinica") );
		$xtpl->assign("linkSeleccionar",  LinkBuilder::getPageUrl( "IvaModificar") );
		
		
	}
}
?>
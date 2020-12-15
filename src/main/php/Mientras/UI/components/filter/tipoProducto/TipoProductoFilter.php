<?php

namespace Mientras\UI\components\filter\tipoProducto;

use Mientras\UI\components\filter\model\UITipoProductoCriteria;

use Mientras\UI\components\grid\model\TipoProductoGridModel;

use Rasty\Grid\filter\Filter;
use Rasty\utils\XTemplate;
use Rasty\utils\LinkBuilder;

/**
 * Filtro para buscar tiposProducto
 * 
 * @author Marcos
 * @since 05/03/2018
 */
class TipoProductoFilter extends Filter{
		
	public function getType(){
		
		return "TipoProductoFilter";
	}
	

	public function __construct(){
		
		parent::__construct();
		
		$this->setGridModelClazz( get_class( new TipoProductoGridModel() ));
		
		$this->setUicriteriaClazz( get_class( new UITipoProductoCriteria()) );
		
		//$this->setSelectRowCallback("seleccionarTipoProducto");
		
		//agregamos las propiedades a popular en el submit.
		$this->addProperty("nombre");
		
	}
	
	protected function parseXTemplate(XTemplate $xtpl){

		//rellenamos el nombre con el texto inicial
		$this->fillInput("nombre", $this->getInitialText() );
		
		parent::parseXTemplate($xtpl);
		
		$xtpl->assign("lbl_nombre",  $this->localize("tipoProducto.nombre") );
		
		//$xtpl->assign("linkSeleccionar",  LinkBuilder::getPageUrl( "HistoriaClinica") );
		$xtpl->assign("linkSeleccionar",  LinkBuilder::getPageUrl( "TipoProductoModificar") );
		
		
	}
}
?>
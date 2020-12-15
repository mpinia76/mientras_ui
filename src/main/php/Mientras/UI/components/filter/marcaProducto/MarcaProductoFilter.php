<?php

namespace Mientras\UI\components\filter\marcaProducto;

use Mientras\UI\components\filter\model\UIMarcaProductoCriteria;

use Mientras\UI\components\grid\model\MarcaProductoGridModel;

use Rasty\Grid\filter\Filter;
use Rasty\utils\XTemplate;
use Rasty\utils\LinkBuilder;

/**
 * Filtro para buscar marcasProducto
 * 
 * @author Marcos
 * @since 05/03/2018
 */
class MarcaProductoFilter extends Filter{
		
	public function getType(){
		
		return "MarcaProductoFilter";
	}
	

	public function __construct(){
		
		parent::__construct();
		
		$this->setGridModelClazz( get_class( new MarcaProductoGridModel() ));
		
		$this->setUicriteriaClazz( get_class( new UIMarcaProductoCriteria()) );
		
		//$this->setSelectRowCallback("seleccionarMarcaProducto");
		
		//agregamos las propiedades a popular en el submit.
		$this->addProperty("nombre");
		
	}
	
	protected function parseXTemplate(XTemplate $xtpl){

		//rellenamos el nombre con el texto inicial
		$this->fillInput("nombre", $this->getInitialText() );
		
		parent::parseXTemplate($xtpl);
		
		$xtpl->assign("lbl_nombre",  $this->localize("marcaProducto.nombre") );
		
		//$xtpl->assign("linkSeleccionar",  LinkBuilder::getPageUrl( "HistoriaClinica") );
		$xtpl->assign("linkSeleccionar",  LinkBuilder::getPageUrl( "MarcaProductoModificar") );
		
		
	}
}
?>
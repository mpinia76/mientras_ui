<?php

namespace Mientras\UI\components\filter\producto;

use Mientras\UI\components\filter\model\UIProductoCriteria;

use Mientras\UI\components\grid\model\ProductoGridModel;

use Rasty\Grid\filter\Filter;
use Rasty\utils\XTemplate;
use Rasty\utils\LinkBuilder;

/**
 * Filtro para buscar productos
 * 
 * @author Marcos
 * @since 02/03/2018
 */
class ProductoFilter extends Filter{
		
	public function getType(){
		
		return "ProductoFilter";
	}
	

	public function __construct(){
		
		parent::__construct();
		
		$this->setGridModelClazz( get_class( new ProductoGridModel() ));
		
		$this->setUicriteriaClazz( get_class( new UIProductoCriteria()) );
		
		//$this->setSelectRowCallback("seleccionarProducto");
		
		//agregamos las propiedades a popular en el submit.
		
		$this->addProperty("nombre");
		$this->addProperty("tipoProducto");
		$this->addProperty("marcaProducto");
		$this->addProperty("filtroPredefinido");
	}
	
	protected function parseXTemplate(XTemplate $xtpl){

		//rellenamos el nombre con el texto inicial
		/*$this->fillInput("nombre", $this->getInitialText() );
		$this->fillInput("tipoProducto", $this->getInitialText() );
		$this->fillInput("marcaProducto", $this->getInitialText() );*/
		
		parent::parseXTemplate($xtpl);
		
		
		$xtpl->assign("lbl_nombre",  $this->localize("producto.nombre") );
		$xtpl->assign("lbl_tipoProducto",  $this->localize("producto.tipoProducto") );
		$xtpl->assign("lbl_marcaProducto",  $this->localize("producto.marcaProducto") );
		$xtpl->assign("lbl_predefinidos",  $this->localize("criteria.predefinidos") );
		//$xtpl->assign("linkSeleccionar",  LinkBuilder::getPageUrl( "HistoriaClinica") );
		$xtpl->assign("linkSeleccionar",  LinkBuilder::getPageUrl( "ProductoModificar") );
		
		
	}
	
	public function getFiltrosPredefinidos(){
		
		$items = array();
		
		//$items[ UIProductoCriteria::POR_VENCER ] = $this->localize("producto.filter.porVencer");
		$items[ UIProductoCriteria::STOCK_MINIMO ] = $this->localize("producto.filter.debajoStockMinimo");
		
		
		
		return $items;
		
	}
}
?>
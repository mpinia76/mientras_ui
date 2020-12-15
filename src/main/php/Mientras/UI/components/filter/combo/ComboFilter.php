<?php

namespace Mientras\UI\components\filter\combo;

use Mientras\UI\service\UIServiceFactory;


use Mientras\UI\components\filter\model\UIComboCriteria;

use Mientras\UI\components\grid\model\ComboGridModel;

use Rasty\Grid\filter\Filter;
use Rasty\utils\XTemplate;
use Rasty\utils\LinkBuilder;
use Rasty\utils\RastyUtils;

/**
 * Filtro para buscar combos
 * 
 * @author Marcos
 * @since 28/08/2019
 */
class ComboFilter extends Filter{
		
	private $producto;
	
	
	public function getType(){
		
		return "ComboFilter";
	}
	

	public function __construct(){
		
		parent::__construct();
		
		$this->setGridModelClazz( get_class( new ComboGridModel() ));
		
		$this->setUicriteriaClazz( get_class( new UIComboCriteria()) );
		
		//$this->setSelectRowCallback("seleccionarCombo");
		
		//agregamos las propiedades a popular en el submit.
		
		$this->addProperty("nombre");
		
		
	}
	
	protected function parseXTemplate(XTemplate $xtpl){

		//rellenamos el nombre con el texto inicial
		/*$this->fillInput("nombre", $this->getInitialText() );
		$this->fillInput("tipoCombo", $this->getInitialText() );
		$this->fillInput("marcaCombo", $this->getInitialText() );*/
		
		parent::parseXTemplate($xtpl);
		
		
		$xtpl->assign("lbl_nombre",  $this->localize("combo.nombre") );
		
		
		
		
		
		//$xtpl->assign("linkSeleccionar",  LinkBuilder::getPageUrl( "HistoriaClinica") );
		$xtpl->assign("linkSeleccionar",  LinkBuilder::getPageUrl( "ComboModificar") );
		
		
	}
	
	public function fillEntity($entity){
		
		parent::fillEntity($entity);
		
		
		
	}
	
	public function getCombo(){
		
	}
	

	

	
}
?>
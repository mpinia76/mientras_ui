<?php

namespace Mientras\UI\components\filter\proveedor;

use Mientras\UI\components\filter\model\UIProveedorCriteria;

use Mientras\UI\components\grid\model\ProveedorGridModel;

use Rasty\Grid\filter\Filter;
use Rasty\utils\XTemplate;
use Rasty\utils\LinkBuilder;
use Rasty\utils\RastyUtils;

/**
 * Filtro para buscar proveedors
 * 
 * @author Marcos
 * @since 10/07/2020
 */
class ProveedorFilter extends Filter{
		
	public function getType(){
		
		return "ProveedorFilter";
	}
	

	public function __construct(){
		
		parent::__construct();
		
		$this->setGridModelClazz( get_class( new ProveedorGridModel() ));
		
		$this->setUicriteriaClazz( get_class( new UIProveedorCriteria()) );
		
		//$this->setSelectRowCallback("seleccionarProveedor");
		
		//agregamos las propiedades a popular en el submit.
		$this->addProperty("nombre");
		$this->addProperty("razonSocial");
		//print_r(RastyUtils::getParamGET("tieneCtaCte"));
		
	}
	
	protected function parseXTemplate(XTemplate $xtpl){

		//rellenamos el nombre con el texto inicial
		/*$this->fillInput("nombre", $this->getInitialText() );
		$this->fillInput("razonSocial", $this->getInitialText() );*/
		
		parent::parseXTemplate($xtpl);
		
		$xtpl->assign("lbl_nombre",  $this->localize("proveedor.nombre") );
		$xtpl->assign("lbl_razonSocial",  $this->localize("proveedor.razonSocial") );
		
		
		
		
	}
	
	
	
}
?>
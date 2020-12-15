<?php

namespace Mientras\UI\components\filter\presupuesto;

use Mientras\UI\components\filter\model\UIPresupuestoCriteria;

use Mientras\UI\components\grid\model\PresupuestoGridModel;

use Rasty\Grid\filter\Filter;
use Rasty\utils\XTemplate;
use Rasty\utils\LinkBuilder;

/**
 * Filtro para buscar presupuestos
 * 
 * @author Marcos
 * @since 29-03-2019
 */
class PresupuestoFilter extends Filter{
		
	public function getType(){
		
		return "PresupuestoFilter";
	}
	

	public function __construct(){
		
		parent::__construct();
		
		$this->setGridModelClazz( get_class( new PresupuestoGridModel() ));
		
		$this->setUicriteriaClazz( get_class( new UIPresupuestoCriteria()) );
		
		//$this->setSelectRowCallback("seleccionarPresupuesto");
		
		//agregamos las propiedades a popular en el submit.
		$this->addProperty("fechaDesde");
		$this->addProperty("fechaHasta");
		$this->addProperty("filtroPredefinido");
	}
	
	
/*
	public function fill($defaultOrder="", $defaultOrderType=""){

		///si se eligió un filtro predefinido, seteamos al filtro de acuerdo a eso.
		
		//hacemos el fill del criteria.
		$this->fillEntity( $this->getCriteria() );
		
		//le agregramos el order y la paginación.
		$orderBy = RastyUtils::getParamPOST("orderBy", $defaultOrder);
		$orderByType = RastyUtils::getParamPOST("orderByType", $defaultOrderType);
		if(!empty($orderBy))
			$this->getCriteria()->addOrder($orderBy, $orderByType);
		
		$page = RastyUtils::getParamPOST("page");
		$this->getCriteria()->setPage($page);
		
	}
	
	*/
	
	protected function parseXTemplate(XTemplate $xtpl){

		//TODO rellenamos los campos del filtro predefinido
		//$this->fillInput("nombre", $this->getInitialText() );
		
		parent::parseXTemplate($xtpl);
		
		$xtpl->assign("lbl_fechaDesde",  $this->localize("criteria.fechaDesde") );
		$xtpl->assign("lbl_fechaHasta",  $this->localize("criteria.fechaHasta") );
		
		$xtpl->assign("lbl_predefinidos",  $this->localize("criteria.predefinidos") );
		
		//$xtpl->assign("linkSeleccionar",  LinkBuilder::getPageUrl( "HistoriaClinica") );
		$xtpl->assign("linkSeleccionar",  LinkBuilder::getPageUrl( "PresupuestoModificar") );
		
		
	}
	
	public function getFiltrosPredefinidos(){
		
		$items = array();
		
		$items[ UIPresupuestoCriteria::HOY ] = $this->localize("presupuesto.filter.hoy");
		$items[ UIPresupuestoCriteria::SEMANA_ACTUAL ] = $this->localize("presupuesto.filter.semanaActual");
		$items[ UIPresupuestoCriteria::MES_ACTUAL ] = $this->localize("presupuesto.filter.mesActual");
		$items[ UIPresupuestoCriteria::ANIO_ACTUAL ] = $this->localize("presupuesto.filter.anioActual");
		$items[ UIPresupuestoCriteria::PENDIENTES ] = $this->localize("presupuesto.filter.pendientes");
		$items[ UIPresupuestoCriteria::ANULADOS ] = $this->localize("presupuesto.filter.anulados");
		
		return $items;
		
	}
	
}
?>
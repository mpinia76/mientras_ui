<?php

namespace Mientras\UI\components\filter\venta;

use Mientras\UI\components\filter\model\UIVentaCriteria;

use Mientras\UI\components\grid\model\VentaGridModel;

use Rasty\Grid\filter\Filter;
use Rasty\utils\XTemplate;
use Rasty\utils\LinkBuilder;

/**
 * Filtro para buscar ventas
 * 
 * @author Marcos
 * @since 13-03-2018
 */
class VentaFilter extends Filter{
		
	public function getType(){
		
		return "VentaFilter";
	}
	

	public function __construct(){
		
		parent::__construct();
		
		$this->setGridModelClazz( get_class( new VentaGridModel() ));
		
		$this->setUicriteriaClazz( get_class( new UIVentaCriteria()) );
		
		//$this->setSelectRowCallback("seleccionarVenta");
		
		//agregamos las propiedades a popular en el submit.
		$this->addProperty("fechaDesde");
		$this->addProperty("fechaHasta");
		$this->addProperty("cliente");
		$this->addProperty("observaciones");
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
		
		
		$xtpl->assign("lbl_cliente",  $this->localize("venta.cliente") );
		$xtpl->assign("lbl_observaciones",  $this->localize("venta.observaciones") );
		
		$xtpl->assign("lbl_predefinidos",  $this->localize("criteria.predefinidos") );
		
		//$xtpl->assign("linkSeleccionar",  LinkBuilder::getPageUrl( "HistoriaClinica") );
		$xtpl->assign("linkSeleccionar",  LinkBuilder::getPageUrl( "VentaModificar") );
		
		
	}
	
	public function getFiltrosPredefinidos(){
		
		$items = array();
		
		$items[ UIVentaCriteria::HOY ] = $this->localize("venta.filter.hoy");
		$items[ UIVentaCriteria::SEMANA_ACTUAL ] = $this->localize("venta.filter.semanaActual");
		$items[ UIVentaCriteria::MES_ACTUAL ] = $this->localize("venta.filter.mesActual");
		$items[ UIVentaCriteria::ANIO_ACTUAL ] = $this->localize("venta.filter.anioActual");
		$items[ UIVentaCriteria::IMPAGAS ] = $this->localize("venta.filter.impagas");
		$items[ UIVentaCriteria::ANULADAS ] = $this->localize("venta.filter.anuladas");
		
		return $items;
		
	}
	
}
?>
<?php

namespace Mientras\UI\components\filter\pedido;

use Mientras\UI\utils\MientrasUIUtils;

use Mientras\UI\components\filter\model\UIPedidoCriteria;

use Mientras\UI\components\grid\model\PedidoGridModel;

use Rasty\Grid\filter\Filter;
use Rasty\utils\XTemplate;
use Rasty\utils\LinkBuilder;

/**
 * Filtro para buscar pedidos
 * 
 * @author Marcos
 * @since 10-07-2020
 */
class PedidoFilter extends Filter{

	private $recibido;
	
	public function getType(){
		
		return "PedidoFilter";
	}
	
	

	public function __construct(){
		
		parent::__construct();
		
		$this->setGridModelClazz( get_class( new PedidoGridModel() ));
		
		$this->setUicriteriaClazz( get_class( new UIPedidoCriteria()) );
		
		//$this->setSelectRowCallback("seleccionarPedido");
		
		//agregamos las propiedades a popular en el submit.
		$this->addProperty("fechaDesde");
		$this->addProperty("fechaHasta");
//		$this->addProperty("recibido");
//		$this->addProperty("anulado");
		$this->addProperty("filtroPredefinido");
	}
	
	protected function parseXTemplate(XTemplate $xtpl){

		//rellenamos para ver pendientes o todos.
		//$this->fillInput("recibido", ($this->getRecibido())?1:2 );	
		
		parent::parseXTemplate($xtpl);
		
		$xtpl->assign("lbl_fechaDesde",  $this->localize("criteria.fechaDesde") );
		$xtpl->assign("lbl_fechaHasta",  $this->localize("criteria.fechaHasta") );
		$xtpl->assign("lbl_recibido",  $this->localize("pedido.criteria_recibido") );
		$xtpl->assign("lbl_anulado",  $this->localize("pedido.anulado.label") );
		
		$xtpl->assign("lbl_predefinidos",  $this->localize("criteria.predefinidos") );
		
	}
	
	public function getOpcionesBooleanas(){
		
		return MientrasUIUtils::getOpcionesBooleanas();
		
	}
	
	public function getOpcionesBooleanasEmpty(){
		
		return MientrasUIUtils::getOpcionesBooleanasEmpty();
		
	}

    public function getRecibido()
    {
        return $this->recibido;
    }

    public function setRecibido($recibido)
    {
        $this->recibido = $recibido;
    }
    

    public function getFiltrosPredefinidos(){
		
		$items = array();
		
		$items[ UIPedidoCriteria::SIN_RECIBIR ] = $this->localize("pedido.filter.sinRecibir");
		$items[ UIPedidoCriteria::HOY ] = $this->localize("pedido.filter.hoy");
		$items[ UIPedidoCriteria::SEMANA_ACTUAL ] = $this->localize("pedido.filter.semanaActual");
		$items[ UIPedidoCriteria::MES_ACTUAL ] = $this->localize("pedido.filter.mesActual");
		$items[ UIPedidoCriteria::ANIO_ACTUAL ] = $this->localize("pedido.filter.anioActual");
		$items[ UIPedidoCriteria::IMPAGOS ] = $this->localize("pedido.filter.impagos");
		$items[ UIPedidoCriteria::ANULADOS ] = $this->localize("pedido.filter.anulados");
		
		return $items;
		
	}
}
?>
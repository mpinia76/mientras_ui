<?php

namespace Mientras\UI\components\filter\balance;

use Mientras\UI\components\filter\model\UIProductoCriteria;



use Rasty\Grid\filter\Filter;
use Rasty\utils\XTemplate;
use Rasty\utils\LinkBuilder;
use Rasty\utils\RastyUtils;

/**
 * Filtro para buscar balances
 * 
 * @author Marcos
 * @since 09/10/2019
 */
class BalanceAnioFilter extends Filter{
		
	
	
	public function getType(){
		
		return "BalanceAnioFilter";
	}
	

	public function __construct(){
		
		parent::__construct();
		
		
		$this->setUicriteriaClazz( get_class( new UIProductoCriteria()) );
		
		
		
		$this->addProperty("fecha");
		$this->addProperty("nombre");
		$this->addProperty("tipoProducto");
		$this->addProperty("marcaProducto");
		$this->addProperty("cliente");
		
	}
	
	protected function parseXTemplate(XTemplate $xtpl){

		
		
		parent::parseXTemplate($xtpl);
		
	
		
		
		$xtpl->assign("lbl_fecha",  $this->localize("gasto.fecha") );
		$xtpl->assign("lbl_nombre",  $this->localize("producto.nombre") );
		$xtpl->assign("lbl_tipoProducto",  $this->localize("producto.tipoProducto") );
		$xtpl->assign("lbl_marcaProducto",  $this->localize("producto.marcaProducto") );
		$xtpl->assign("lbl_cliente",  $this->localize("venta.cliente") );
		
		
		
		
		
		
	}
}
?>
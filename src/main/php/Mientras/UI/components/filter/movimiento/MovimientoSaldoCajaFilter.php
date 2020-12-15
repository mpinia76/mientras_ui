<?php

namespace Mientras\UI\components\filter\movimiento;

use Mientras\UI\service\finder\UserFinder;

use Mientras\UI\service\UIServiceFactory;

use Mientras\UI\utils\MientrasUIUtils;

use Mientras\UI\components\grid\model\MovimientoCajaGridModel;

use Mientras\UI\components\filter\model\UIMovimientoCajaCriteria;


use Rasty\Grid\filter\Filter;
use Rasty\utils\XTemplate;
use Rasty\utils\LinkBuilder;

/**
 * Filtro para buscar movimientos de Caja
 * 
 * @author Marcos
 * @since 14-03-2018
 */
class MovimientoSaldoCajaFilter extends MovimientoFilter{
		
	
	
	public function getType(){
		
		return "MovimientoSaldoCajaFilter";
	}
	
	public function __construct(){
		
		parent::__construct();
		
		$this->setGridModelClazz( get_class( new MovimientoCajaGridModel() ));
		
		$this->setUicriteriaClazz( get_class( new UIMovimientoCajaCriteria()) );
		
		
		$this->addProperty("fechaDesde");
		$this->addProperty("fechaHasta");
		$this->addProperty("user");
	}
	
	protected function parseXTemplate(XTemplate $xtpl){

		//rellenamos el banco con bapro
		//$this->fillInput("cuenta", UIServiceFactory::getUIBancoService()->getCajaBAPRO() );
		
		parent::parseXTemplate($xtpl);

		$xtpl->assign("lbl_fechaDesde",  $this->localize( "criteria.fechaDesde" ) );
		$xtpl->assign("lbl_fechaHasta",  $this->localize( "criteria.fechaHasta" ) );
		
		$xtpl->assign("lbl_usuario",  $this->localize( "login.username" ) );
	}
	
	public function getUserFinderClazz(){
		
		return get_class( new UserFinder() );
		
	}
	
	public function getUsers(){
		
		$users = UIServiceFactory::getUIUserService()->getUsers();
		//$users = array();
		return $users;
		
	}
	
}
?>
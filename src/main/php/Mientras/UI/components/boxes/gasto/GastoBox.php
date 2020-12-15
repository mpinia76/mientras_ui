<?php

namespace Mientras\UI\components\boxes\gasto;

use Mientras\UI\utils\MientrasUIUtils;

use Mientras\UI\service\UIServiceFactory;

use Rasty\components\RastyComponent;
use Rasty\utils\RastyUtils;

use Rasty\utils\XTemplate;

use Mientras\Core\model\Gasto;

use Rasty\utils\LinkBuilder;

/**
 * gasto.
 * 
 * @author Marcos
 * @since 12-03-2018
 */
class GastoBox extends RastyComponent{
		
	private $gasto;
	
	public function getType(){
		
		return "GastoBox";
		
	}

	public function __construct(){
		
		
	}

	protected function parseLabels(XTemplate $xtpl){
		
		$xtpl->assign("lbl_fecha",  $this->localize( "gasto.fecha" ) );
		$xtpl->assign("lbl_fechaVencimiento",  $this->localize( "gasto.fechaVencimiento" ) );
		$xtpl->assign("lbl_concepto",  $this->localize( "gasto.concepto" ) );
		$xtpl->assign("lbl_observaciones",  $this->localize( "gasto.observaciones" ) );
		$xtpl->assign("lbl_monto",  $this->localize( "gasto.monto" ) );
		
	}
	
	protected function parseXTemplate(XTemplate $xtpl){
		
		/*labels*/
		$this->parseLabels($xtpl);
		
		$gasto = $this->getGasto();
		
			
		$xtpl->assign( "concepto", $this->getGasto()->getConcepto() );
		$xtpl->assign( "monto", MientrasUIUtils::formatMontoToView( $this->getGasto()->getMonto() ) );
		$xtpl->assign( "observaciones", $this->getGasto()->getObservaciones() );
		$xtpl->assign( "fecha", MientrasUIUtils::formatDateTimeToView($this->getGasto()->getFecha()) );
		$xtpl->assign( "fechaVencimiento", MientrasUIUtils::formatDateTimeToView($this->getGasto()->getFechaVencimiento()) );
		
	}
	
	
	protected function initObserverEventType(){
		$this->addEventType( "Gasto" );
	}
	
	public function setGastoOid($oid){
		if( !empty($oid) ){
			$gasto = UIServiceFactory::getUIGastoService()->get($oid);
			$this->setGasto($gasto);
		}
	}   
    

	public function getGasto()
	{
	    return $this->gasto;
	}

	public function setGasto($gasto)
	{
	    $this->gasto = $gasto;
	}
}
?>
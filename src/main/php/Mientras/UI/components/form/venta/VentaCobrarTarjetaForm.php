<?php

namespace Mientras\UI\components\form\venta;

use Mientras\UI\components\filter\model\UITarjetaCriteria;



use Mientras\UI\service\finder\TarjetaFinder;



use Mientras\UI\utils\MientrasUIUtils;

use Mientras\UI\service\UIServiceFactory;


use Rasty\Forms\form\Form;

use Rasty\components\RastyComponent;
use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;



use Rasty\utils\LinkBuilder;

/**
 * Formulario para cobrar venta con tarjeta

 * @author Marcos
 * @since 27/03/2018
 */
class VentaCobrarTarjetaForm extends Form{
		
	

	/**
	 * label para el cancel
	 * @var string
	 */
	private $labelCancel;
	

	/**
	 * 
	 * @var Tarjeta
	 */
	private $tarjeta;
	

	
	public function __construct(){

		parent::__construct();
		$this->setLabelCancel("form.cancelar");
		
		$this->addProperty("nro");
		$this->addProperty("marca");
		$this->addProperty("titular");
		
		$this->setBackToOnSuccess("Ventas");
		$this->setBackToOnCancel("VentaCobrar");
		
		
	}
	
	public function getOid(){
		
		return $this->getComponentById("oid")->getPopulatedValue( $this->getMethod() );
	}
	
	
	public function getType(){
		return "VentaCobrarTarjetaForm";
		
	}
	
	public function fillEntity($entity){
		
		parent::fillEntity($entity);
		
		
		
		
	}

	protected function parseXTemplate(XTemplate $xtpl){
		
		$monto = RastyUtils::getParamGET("monto");
		$montoActualizado = RastyUtils::getParamGET("montoActualizado");
		$this->fillInput("monto", $monto );
		$this->fillInput("montoActualizado", $montoActualizado );

		parent::parseXTemplate($xtpl);
		
		$ventaOid = RastyUtils::getParamGET("ventaOid");
		$xtpl->assign("ventaOid", $ventaOid );
		
		$venta = UIServiceFactory::getUIVentaService()->get( $ventaOid );
		if ($venta) {
			$xtpl->assign("clienteOid", $venta->getCliente()->getOid() );
		}
		
		
		
		$xtpl->assign("cancel", $this->getLinkCancel() );
		$xtpl->assign("lbl_cancel", $this->localize( $this->getLabelCancel() ) );
		
		$xtpl->assign("lbl_tarjeta", $this->localize("tarjeta.tarjetas") );
		$xtpl->assign("lbl_titular", $this->localize("tarjeta.titular") );
		$xtpl->assign("lbl_marca", $this->localize("tarjeta.marca") );
		$xtpl->assign("lbl_nro", $this->localize("tarjeta.nro") );
		$xtpl->assign("lbl_monto", $this->localize("tarjeta.monto") );
		$xtpl->assign("lbl_montoActualizado", $this->localize("tarjeta.montoActualizado") );
		
		$xtpl->assign("linkSeleccionarTarjeta", $this->getLinkActionSeleccionarTarjeta() );
		
	}

	
	public function getLinkActionSeleccionarTarjeta(){
		
		return LinkBuilder::getActionAjaxUrl( "SeleccionarTarjetaJson") ;
		
	}

	public function getLabelCancel()
	{
	    return $this->labelCancel;
	}

	public function setLabelCancel($labelCancel)
	{
	    $this->labelCancel = $labelCancel;
	}


	
	
	
	public function getLinkCancel(){
		//$params = array();
		$ventaOid = RastyUtils::getParamGET("ventaOid");
		return LinkBuilder::getPageUrl( $this->getBackToOnCancel() , array("ventaOid"=>$ventaOid)) ;
	}

	
	
	

	public function getTarjeta()
	{
	    return $this->tarjeta;
	}

	public function setTarjeta($tarjeta)
	{
	    $this->tarjeta = $tarjeta;
	}
	
	public function getTarjetaFinderClazz(){
		
		return get_class( new TarjetaFinder() );
		
	}
	
	public function getTarjetas(){
		$ventaOid = RastyUtils::getParamGET("ventaOid");
		if (!$ventaOid) {
			$ventaOid = RastyUtils::getParamPOST("ventaOid");
		}
		
		
		$venta = UIServiceFactory::getUIVentaService()->get( $ventaOid );
		$criteria = new UITarjetaCriteria();
		if ($venta) {
			$criteria->setCliente($venta->getCliente());
		}
		
		$tarjetas = UIServiceFactory::getUITarjetaService()->getList( $criteria );
		
		return $tarjetas;
	}

}
?>
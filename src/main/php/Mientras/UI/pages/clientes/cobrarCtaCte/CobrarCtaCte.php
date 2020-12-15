<?php
namespace Mientras\UI\pages\clientes\cobrarCtaCte;


use Mientras\UI\service\finder\ClienteFinder;

use Mientras\UI\service\finder\CuentaFinder;

use Mientras\UI\pages\MientrasPage;

use Mientras\UI\service\UIServiceFactory;

use Mientras\UI\utils\MientrasUIUtils;

use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;
use Rasty\i18n\Locale;
use Rasty\utils\LinkBuilder;

use Rasty\Grid\filter\model\UICriteria;

use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;



class CobrarCtaCte extends MientrasPage{

	private $cliente;
	private $destino;
	private $monto;
	private $observaciones;

	private $error;
	
	public function __construct(){
		
		/*if( MientrasUIUtils::isCajaSelected() )
			$this->destino = MientrasUIUtils::getCaja();*/
		
		$cliente = UIServiceFactory::getUIClienteService()->get( RastyUtils::getParamGET("clienteOid") );
		
		if( !empty( $cliente)  ){
			$this->setCliente($cliente);
		}
	}

	protected function parseLabels(XTemplate $xtpl){
		
		$xtpl->assign("legend",  $this->localize( "cuentaCorriente.cobrar.legend" ) );

		
		$xtpl->assign("lbl_monto",  $this->localize( "cobrarCtaCte.monto" ) );
		$xtpl->assign("lbl_observaciones",  $this->localize( "cobrarCtaCte.observaciones" ) );
		$xtpl->assign("lbl_cliente",  $this->localize( "cobrarCtaCte.cliente" ) );
		//$xtpl->assign("lbl_destino",  $this->localize( "cobrarCtaCte.destino" ) );
		
		$xtpl->assign("ctacte_legend",  $this->localize( "cobrarCtaCte.ctacte_legend" ) );
		
		
		
		
		$xtpl->assign("lbl_submit",  $this->localize( "form.aceptar" ) );
		$xtpl->assign("lbl_cancel",  $this->localize( "form.cancelar" ) );
		
	}

	protected function parseXTemplate(XTemplate $xtpl){
		
		/*labels*/
		$this->parseLabels($xtpl);
		
		$xtpl->assign("action", $this->getLinkActionCobrarCuentaCorriente() );
		$xtpl->assign("cancel",  $this->getLinkClientesCtaCte() );
			
		$msg = $this->getError();
		
		if( !empty($msg) ){
			
			$xtpl->assign("msg", $msg);
			//$xtpl->assign("msg",  );
			$xtpl->parse("main.msg_error" );
		}
	}
	
	public function getTitle(){
		return $this->localize("cobrarCtaCte.title") ;
	}

	public function getType(){
		
		return "CobrarCtaCte";
		
	}	


	public function getCliente()
	{
	    return $this->cliente;
	}

	public function setCliente($cliente)
	{
	    $this->cliente = $cliente;
	}

	public function getMonto()
	{
	    return $this->monto;
	}

	public function setMonto($monto)
	{
	    $this->monto = $monto;
	}

	public function getObservaciones()
	{
	    return $this->observaciones;
	}

	public function setObservaciones($observaciones)
	{
	    $this->observaciones = $observaciones;
	}

	public function getError()
	{
	    return $this->error;
	}

	public function setError($error)
	{
	    $this->error = $error;
	}
	
	
	
	public function getCuentaFinderClazz(){
		
		return get_class( new CuentaFinder() );
		
	}
	
	
	public function getClienteFinderClazz(){
		
		return get_class( new ClienteFinder() );
		
	}



	public function getDestino()
	{
	    return $this->destino;
	}

	public function setDestino($destino)
	{
	    $this->destino = $destino;
	}
}
?>
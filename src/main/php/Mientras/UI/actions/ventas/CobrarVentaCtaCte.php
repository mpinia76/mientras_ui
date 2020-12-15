<?php
namespace Mientras\UI\actions\ventas;

use Mientras\UI\utils\MientrasUIUtils;
use Mientras\Core\utils\MientrasUtils;

use Mientras\UI\service\UIServiceFactory;
use Mientras\Core\model\Venta;

use Rasty\actions\Action;
use Rasty\actions\Forward;
use Rasty\utils\RastyUtils;
use Rasty\exception\RastyException;

use Rasty\security\RastySecurityContext;

use Rasty\i18n\Locale;
use Rasty\factory\PageFactory;
use Rasty\exception\RastyDuplicatedException;


/**
 * se cobra una venta con la cuenta corriente del cliente
 * 
 * @author Marcos
 * @since 13-03-2018
 */
class CobrarVentaCtaCte extends Action{

	
	public function execute(){

		$forward = new Forward();
		
		
		//tomamos la venta
		$ventaOid = RastyUtils::getParamGET("ventaOid");
		$forward->addParam( "ventaOid", $ventaOid );
		try {

			
			//recuperamos la venta.
			$venta = UIServiceFactory::getUIVentaService()->get( $ventaOid );
			$monto = $value = str_replace(',', '.', RastyUtils::getParamGET("monto"));
			$montoActualizado = $value = str_replace(',', '.', RastyUtils::getParamGET("montoActualizado"));
			//tomamos la caja del contexto, para saber que la venta se hizo desde esta caja.
			//$caja = MientrasUtils::getCajaDeafault();
				
			//el usuario
			$user = RastySecurityContext::getUser();
			$user = MientrasUtils::getUserByUsername($user->getUsername());
			
			//cobramos en cuenta corriente.
			UIServiceFactory::getUIVentaService()->cobrarCtaCte($venta, $user, $monto, $montoActualizado);			
			
			$forward->setPageName( "Ventas" );
		
			
		} catch (RastyException $e) {
		
			$forward->setPageName( "VentaCobrar" );
			$forward->addError( Locale::localize($e->getMessage())  );
			
		}
		
		return $forward;
		
	}

}
?>
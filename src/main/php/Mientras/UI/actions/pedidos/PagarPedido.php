<?php
namespace Mientras\UI\actions\pedidos;

use Mientras\UI\utils\MientrasUIUtils;
use Mientras\Core\utils\MientrasUtils;


use Mientras\UI\service\UIServiceFactory;
use Mientras\Core\model\Pedido;

use Rasty\actions\Action;
use Rasty\actions\Forward;
use Rasty\utils\RastyUtils;
use Rasty\exception\RastyException;

use Rasty\security\RastySecurityContext;

use Rasty\i18n\Locale;
use Rasty\factory\PageFactory;
use Rasty\exception\RastyDuplicatedException;


/**
 * se paga un pedido
 * 
 * @author Marcos
 * @since 10-07-2020
 */
class PagarPedido extends Action{

	
	public function execute(){

		$forward = new Forward();
		
		//tomamos la pedido y la cuenta con la cuenta se paga
		$pedidoOid = RastyUtils::getParamGET("pedidoOid");
		$cuentaOid = RastyUtils::getParamGET("cuentaOid");
		
		$backTo = "Pedidos";
		
		$forward->addParam( "pedidoOid", $pedidoOid );
		try {

			
			//recuperamos el pedido.
			$pedido = UIServiceFactory::getUIPedidoService()->get( $pedidoOid );
			
			//recuperamos la cuenta
			$cuenta = UIServiceFactory::getUICuentaService()->get( $cuentaOid );

			$user = RastySecurityContext::getUser();
			$user = MientrasUtils::getUserByUsername($user->getUsername());
			
			UIServiceFactory::getUIPedidoService()->pagar($pedido, $cuenta, $user);			
			
			$forward->setPageName( $backTo );
		
			
		} catch (RastyException $e) {
		
			$forward->setPageName( "PedidoPagar" );
			$forward->addError( Locale::localize($e->getMessage())  );
			
		}
		
		return $forward;
		
	}

}
?>
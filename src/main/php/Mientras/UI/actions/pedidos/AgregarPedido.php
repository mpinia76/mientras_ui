<?php
namespace Mientras\UI\actions\pedidos;


use Mientras\UI\components\form\pedido\PedidoForm;

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
 * se realiza el alta de una Pedido.
 * 
 * @author Marcos
 * @since 10-07-2020
 */
class AgregarPedido extends Action{

	
	public function execute(){

		$forward = new Forward();

		$page = PageFactory::build("PedidoAgregar");
		
		$pedidoForm = $page->getComponentById("pedidoForm");
		
		try {

			//creamos un nuevo pedido.
			$pedido = new Pedido();
			
			//completados con los datos del formulario.
			$pedidoForm->fillEntity($pedido);
			
			//agregamos la pedido.
			UIServiceFactory::getUIPedidoService()->add( $pedido );
			
			$forward->setPageName( $pedidoForm->getBackToOnSuccess() );
			$forward->addParam( "pedidoOid", $pedido->getOid() );			
		
			$pedidoForm->cleanSavedProperties();
			
		
		} catch (RastyException $e) {
		
			$forward->setPageName( "PedidoAgregar" );
			$forward->addError( Locale::localize($e->getMessage())  );
			
			//guardamos lo ingresado en el form.
			$pedidoForm->save();
		}
		
		return $forward;
		
	}

}
?>
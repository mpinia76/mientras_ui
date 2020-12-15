<?php
namespace Mientras\UI\actions\clientes;

use Mientras\UI\utils\MientrasUIUtils;

use Mientras\UI\components\form\cliente\ClienteForm;

use Mientras\UI\service\UIServiceFactory;
use Mientras\Core\model\Cliente;

use Rasty\actions\Action;
use Rasty\actions\Forward;
use Rasty\utils\RastyUtils;
use Rasty\exception\RastyException;

use Rasty\security\RastySecurityContext;

use Rasty\i18n\Locale;
use Rasty\factory\PageFactory;
use Rasty\exception\RastyDuplicatedException;


/**
 * se realiza el alta de un cliente.
 * 
 * @author Marcos
 * @since 02/03/2018
 */
class AgregarCliente extends Action{

	
	public function execute(){

		$forward = new Forward();

		$page = PageFactory::build("ClienteAgregar");
		
		$clienteForm = $page->getComponentById("clienteForm");
		
		try {

			//creamos un nuevo cliente.
			$cliente = new Cliente();
			
			//completados con los datos del formulario.
			$clienteForm->fillEntity($cliente);
			
			//agregamos el cliente.
			UIServiceFactory::getUIClienteService()->add( $cliente );
			
			$forward->setPageName( $clienteForm->getBackToOnSuccess() );
			$forward->addParam( "clienteOid", $cliente->getOid() );			
		
			$clienteForm->cleanSavedProperties();
			
		} catch (RastyDuplicatedException $e) {
		
			$forward->setPageName( "ClienteAgregar" );
			$forward->addError( Locale::localize($e->getMessage())  );
						
			//guardamos lo ingresado en el form.
			$clienteForm->save();
		
		} catch (RastyException $e) {
		
			$forward->setPageName( "ClienteAgregar" );
			$forward->addError( Locale::localize($e->getMessage())  );
						
			//guardamos lo ingresado en el form.
			$clienteForm->save();
		}
		
		return $forward;
		
	}

}
?>
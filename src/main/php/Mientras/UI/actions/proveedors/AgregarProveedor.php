<?php
namespace Mientras\UI\actions\proveedors;

use Mientras\UI\utils\MientrasUIUtils;

use Mientras\UI\components\form\proveedor\ProveedorForm;

use Mientras\UI\service\UIServiceFactory;
use Mientras\Core\model\Proveedor;

use Rasty\actions\Action;
use Rasty\actions\Forward;
use Rasty\utils\RastyUtils;
use Rasty\exception\RastyException;

use Rasty\security\RastySecurityContext;

use Rasty\i18n\Locale;
use Rasty\factory\PageFactory;
use Rasty\exception\RastyDuplicatedException;


/**
 * se realiza el alta de un proveedor.
 * 
 * @author Marcos
 * @since 10/07/2020
 */
class AgregarProveedor extends Action{

	
	public function execute(){

		$forward = new Forward();

		$page = PageFactory::build("ProveedorAgregar");
		
		$proveedorForm = $page->getComponentById("proveedorForm");
		
		try {

			//creamos un nuevo proveedor.
			$proveedor = new Proveedor();
			
			//completados con los datos del formulario.
			$proveedorForm->fillEntity($proveedor);
			
			//agregamos el proveedor.
			UIServiceFactory::getUIProveedorService()->add( $proveedor );
			
			$forward->setPageName( $proveedorForm->getBackToOnSuccess() );
			$forward->addParam( "proveedorOid", $proveedor->getOid() );			
		
			$proveedorForm->cleanSavedProperties();
			
		} catch (RastyDuplicatedException $e) {
		
			$forward->setPageName( "ProveedorAgregar" );
			$forward->addError( Locale::localize($e->getMessage())  );
						
			//guardamos lo ingresado en el form.
			$proveedorForm->save();
		
		} catch (RastyException $e) {
		
			$forward->setPageName( "ProveedorAgregar" );
			$forward->addError( Locale::localize($e->getMessage())  );
						
			//guardamos lo ingresado en el form.
			$proveedorForm->save();
		}
		
		return $forward;
		
	}

}
?>
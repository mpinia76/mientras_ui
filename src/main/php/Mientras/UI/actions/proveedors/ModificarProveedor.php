<?php
namespace Mientras\UI\actions\proveedors;

use Mientras\UI\components\form\proveedor\ProveedorForm;

use Mientras\UI\service\UIServiceFactory;
use Mientras\UI\utils\MientrasUtils;

use Rasty\actions\Action;
use Rasty\actions\Forward;
use Rasty\utils\RastyUtils;
use Rasty\exception\RastyException;

use Rasty\security\RastySecurityContext;

use Rasty\factory\ComponentConfig;
use Rasty\factory\ComponentFactory;

use Rasty\i18n\Locale;

use Rasty\factory\PageFactory;

/**
 * se realiza la actualización de un proveedor.
 * 
 * @author Marcos
 * @since 10/07/2020
 */
class ModificarProveedor extends Action{

	
	public function execute(){

		$forward = new Forward();
		
		$page = PageFactory::build("ProveedorModificar");
		
		$proveedorForm = $page->getComponentById("proveedorForm");
			
		$oid = $proveedorForm->getOid();
						
		try {

			//obtenemos el proveedor.
			$proveedor = UIServiceFactory::getUIProveedorService()->get($oid );
		
			//lo editamos con los datos del formulario.
			$proveedorForm->fillEntity($proveedor);
			
			//guardamos los cambios.
			UIServiceFactory::getUIProveedorService()->update( $proveedor );
			
			$forward->setPageName( $proveedorForm->getBackToOnSuccess() );
			$forward->addParam( "proveedorOid", $proveedor->getOid() );
			
			$proveedorForm->cleanSavedProperties();
			
		} catch (RastyException $e) {
		
			$forward->setPageName( "ProveedorModificar" );
			$forward->addError( Locale::localize($e->getMessage())  );
			$forward->addParam("oid", $oid );
			
			//guardamos lo ingresado en el form.
			$proveedorForm->save();
			
		}
		return $forward;
		
	}

}
?>
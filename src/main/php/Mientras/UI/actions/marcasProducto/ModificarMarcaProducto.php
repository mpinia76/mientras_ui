<?php
namespace Mientras\UI\actions\marcasProducto;

use Mientras\UI\components\form\marcaProducto\MarcaProductoForm;

use Mientras\UI\service\UIServiceFactory;

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
 * se realiza la actualización de una marcaProducto.
 * 
 * @author Marcos
 * @since 05/03/2018
 */
class ModificarMarcaProducto extends Action{

	
	public function execute(){

		$forward = new Forward();
		
		$page = PageFactory::build("MarcaProductoModificar");
		
		$marcaProductoForm = $page->getComponentById("marcaProductoForm");
			
		$oid = $marcaProductoForm->getOid();
						
		try {

			//obtenemos la marcaProducto.
			$marcaProducto = UIServiceFactory::getUIMarcaProductoService()->get($oid );
		
			//lo editamos con los datos del formulario.
			$marcaProductoForm->fillEntity($marcaProducto);
			
			//guardamos los cambios.
			UIServiceFactory::getUIMarcaProductoService()->update( $marcaProducto );
			
			$forward->setPageName( $marcaProductoForm->getBackToOnSuccess() );
			$forward->addParam( "marcaProductoOid", $marcaProducto->getOid() );
			
			$marcaProductoForm->cleanSavedProperties();
			
		} catch (RastyException $e) {
		
			$forward->setPageName( "MarcaProductoModificar" );
			$forward->addError( Locale::localize($e->getMessage())  );
			$forward->addParam("oid", $oid );
			
			//guardamos lo ingresado en el form.
			$marcaProductoForm->save();
			
		}
		return $forward;
		
	}

}
?>
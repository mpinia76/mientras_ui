<?php
namespace Mientras\UI\actions\tiposProducto;

use Mientras\UI\components\form\tipoProducto\TipoProductoForm;

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
 * se realiza la actualización de una tipoProducto.
 * 
 * @author Marcos
 * @since 05/03/2018
 */
class ModificarTipoProducto extends Action{

	
	public function execute(){

		$forward = new Forward();
		
		$page = PageFactory::build("TipoProductoModificar");
		
		$tipoProductoForm = $page->getComponentById("tipoProductoForm");
			
		$oid = $tipoProductoForm->getOid();
						
		try {

			//obtenemos la tipoProducto.
			$tipoProducto = UIServiceFactory::getUITipoProductoService()->get($oid );
		
			//lo editamos con los datos del formulario.
			$tipoProductoForm->fillEntity($tipoProducto);
			
			//guardamos los cambios.
			UIServiceFactory::getUITipoProductoService()->update( $tipoProducto );
			
			$forward->setPageName( $tipoProductoForm->getBackToOnSuccess() );
			$forward->addParam( "tipoProductoOid", $tipoProducto->getOid() );
			
			$tipoProductoForm->cleanSavedProperties();
			
		} catch (RastyException $e) {
		
			$forward->setPageName( "TipoProductoModificar" );
			$forward->addError( Locale::localize($e->getMessage())  );
			$forward->addParam("oid", $oid );
			
			//guardamos lo ingresado en el form.
			$tipoProductoForm->save();
			
		}
		return $forward;
		
	}

}
?>
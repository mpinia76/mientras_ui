<?php
namespace Mientras\UI\actions\ivas;

use Mientras\UI\components\form\iva\IvaForm;

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
 * se realiza la actualización de una iva.
 * 
 * @author Marcos
 * @since 05/03/2018
 */
class ModificarIva extends Action{

	
	public function execute(){

		$forward = new Forward();
		
		$page = PageFactory::build("IvaModificar");
		
		$ivaForm = $page->getComponentById("ivaForm");
			
		$oid = $ivaForm->getOid();
						
		try {

			//obtenemos la iva.
			$iva = UIServiceFactory::getUIIvaService()->get($oid );
		
			//lo editamos con los datos del formulario.
			$ivaForm->fillEntity($iva);
			
			//guardamos los cambios.
			UIServiceFactory::getUIIvaService()->update( $iva );
			
			$forward->setPageName( $ivaForm->getBackToOnSuccess() );
			$forward->addParam( "ivaOid", $iva->getOid() );
			
			$ivaForm->cleanSavedProperties();
			
		} catch (RastyException $e) {
		
			$forward->setPageName( "IvaModificar" );
			$forward->addError( Locale::localize($e->getMessage())  );
			$forward->addParam("oid", $oid );
			
			//guardamos lo ingresado en el form.
			$ivaForm->save();
			
		}
		return $forward;
		
	}

}
?>
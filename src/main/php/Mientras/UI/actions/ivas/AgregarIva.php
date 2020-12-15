<?php
namespace Mientras\UI\actions\ivas;


use Mientras\UI\components\form\iva\IvaForm;

use Mientras\UI\service\UIServiceFactory;
use Mientras\Core\model\Iva;

use Rasty\actions\Action;
use Rasty\actions\Forward;
use Rasty\utils\RastyUtils;
use Rasty\exception\RastyException;

use Rasty\security\RastySecurityContext;

use Rasty\i18n\Locale;
use Rasty\factory\PageFactory;
use Rasty\exception\RastyDuplicatedException;


/**
 * se realiza el alta de una Iva.
 * 
 * @author Marcos
 * @since 05/03/2018
 */
class AgregarIva extends Action{

	
	public function execute(){

		$forward = new Forward();

		$page = PageFactory::build("IvaAgregar");
		
		$ivaForm = $page->getComponentById("ivaForm");
		
		try {

			//creamos una nueva iva.
			$iva = new Iva();
			
			//completados con los datos del formulario.
			$ivaForm->fillEntity($iva);
			
			//agregamos el iva.
			UIServiceFactory::getUIIvaService()->add( $iva );
			
			$forward->setPageName( $ivaForm->getBackToOnSuccess() );
			$forward->addParam( "ivaOid", $iva->getOid() );			
		
			$ivaForm->cleanSavedProperties();
			
		
		} catch (RastyException $e) {
		
			$forward->setPageName( "IvaAgregar" );
			$forward->addError( Locale::localize($e->getMessage())  );
			
			//guardamos lo ingresado en el form.
			$ivaForm->save();
		}
		
		return $forward;
		
	}

}
?>
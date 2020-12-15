<?php
namespace Mientras\UI\actions\conceptoGastos;

use Mientras\UI\components\form\conceptoGasto\ConceptoGastoForm;

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
 * se realiza la actualización de una conceptoGasto.
 * 
 * @author Marcos
 * @since 05/03/2018
 */
class ModificarConceptoGasto extends Action{

	
	public function execute(){

		$forward = new Forward();
		
		$page = PageFactory::build("ConceptoGastoModificar");
		
		$conceptoGastoForm = $page->getComponentById("conceptoGastoForm");
			
		$oid = $conceptoGastoForm->getOid();
						
		try {

			//obtenemos la conceptoGasto.
			$conceptoGasto = UIServiceFactory::getUIConceptoGastoService()->get($oid );
		
			//lo editamos con los datos del formulario.
			$conceptoGastoForm->fillEntity($conceptoGasto);
			
			//guardamos los cambios.
			UIServiceFactory::getUIConceptoGastoService()->update( $conceptoGasto );
			
			$forward->setPageName( $conceptoGastoForm->getBackToOnSuccess() );
			$forward->addParam( "conceptoGastoOid", $conceptoGasto->getOid() );
			
			$conceptoGastoForm->cleanSavedProperties();
			
		} catch (RastyException $e) {
		
			$forward->setPageName( "ConceptoGastoModificar" );
			$forward->addError( Locale::localize($e->getMessage())  );
			$forward->addParam("oid", $oid );
			
			//guardamos lo ingresado en el form.
			$conceptoGastoForm->save();
			
		}
		return $forward;
		
	}

}
?>
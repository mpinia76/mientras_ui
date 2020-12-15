<?php
namespace Mientras\UI\actions\conceptoGastos;


use Mientras\UI\components\form\conceptoGasto\ConceptoGastoForm;

use Mientras\UI\service\UIServiceFactory;
use Mientras\Core\model\ConceptoGasto;

use Rasty\actions\Action;
use Rasty\actions\Forward;
use Rasty\utils\RastyUtils;
use Rasty\exception\RastyException;

use Rasty\security\RastySecurityContext;

use Rasty\i18n\Locale;
use Rasty\factory\PageFactory;
use Rasty\exception\RastyDuplicatedException;


/**
 * se realiza el alta de una ConceptoGasto.
 * 
 * @author Marcos
 * @since 09/03/2018
 */
class AgregarConceptoGasto extends Action{

	
	public function execute(){

		$forward = new Forward();

		$page = PageFactory::build("ConceptoGastoAgregar");
		
		$conceptoGastoForm = $page->getComponentById("conceptoGastoForm");
		
		try {

			//creamos una nueva conceptoGasto.
			$conceptoGasto = new ConceptoGasto();
			
			//completados con los datos del formulario.
			$conceptoGastoForm->fillEntity($conceptoGasto);
			
			//agregamos el conceptoGasto.
			UIServiceFactory::getUIConceptoGastoService()->add( $conceptoGasto );
			
			$forward->setPageName( $conceptoGastoForm->getBackToOnSuccess() );
			$forward->addParam( "conceptoGastoOid", $conceptoGasto->getOid() );			
		
			$conceptoGastoForm->cleanSavedProperties();
			
		
		} catch (RastyException $e) {
		
			$forward->setPageName( "ConceptoGastoAgregar" );
			$forward->addError( Locale::localize($e->getMessage())  );
			
			//guardamos lo ingresado en el form.
			$conceptoGastoForm->save();
		}
		
		return $forward;
		
	}

}
?>
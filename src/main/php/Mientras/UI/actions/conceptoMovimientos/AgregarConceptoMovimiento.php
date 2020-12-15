<?php
namespace Mientras\UI\actions\conceptoMovimientos;


use Mientras\UI\components\form\conceptoMovimiento\ConceptoMovimientoForm;

use Mientras\UI\service\UIServiceFactory;
use Mientras\Core\model\ConceptoMovimiento;

use Rasty\actions\Action;
use Rasty\actions\Forward;
use Rasty\utils\RastyUtils;
use Rasty\exception\RastyException;

use Rasty\security\RastySecurityContext;

use Rasty\i18n\Locale;
use Rasty\factory\PageFactory;
use Rasty\exception\RastyDuplicatedException;


/**
 * se realiza el alta de una ConceptoMovimiento.
 * 
 * @author Marcos
 * @since 12/03/2018
 */
class AgregarConceptoMovimiento extends Action{

	
	public function execute(){

		$forward = new Forward();

		$page = PageFactory::build("ConceptoMovimientoAgregar");
		
		$conceptoMovimientoForm = $page->getComponentById("conceptoMovimientoForm");
		
		try {

			//creamos una nueva conceptoMovimiento.
			$conceptoMovimiento = new ConceptoMovimiento();
			
			//completados con los datos del formulario.
			$conceptoMovimientoForm->fillEntity($conceptoMovimiento);
			
			//agregamos el conceptoMovimiento.
			UIServiceFactory::getUIConceptoMovimientoService()->add( $conceptoMovimiento );
			
			$forward->setPageName( $conceptoMovimientoForm->getBackToOnSuccess() );
			$forward->addParam( "conceptoMovimientoOid", $conceptoMovimiento->getOid() );			
		
			$conceptoMovimientoForm->cleanSavedProperties();
			
		
		} catch (RastyException $e) {
		
			$forward->setPageName( "ConceptoMovimientoAgregar" );
			$forward->addError( Locale::localize($e->getMessage())  );
			
			//guardamos lo ingresado en el form.
			$conceptoMovimientoForm->save();
		}
		
		return $forward;
		
	}

}
?>
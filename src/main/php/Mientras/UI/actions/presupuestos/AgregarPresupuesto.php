<?php
namespace Mientras\UI\actions\presupuestos;


use Mientras\UI\components\form\presupuesto\PresupuestoForm;

use Mientras\UI\service\UIServiceFactory;
use Mientras\Core\model\Presupuesto;

use Rasty\actions\Action;
use Rasty\actions\Forward;
use Rasty\utils\RastyUtils;
use Rasty\exception\RastyException;

use Rasty\security\RastySecurityContext;

use Rasty\i18n\Locale;
use Rasty\factory\PageFactory;
use Rasty\exception\RastyDuplicatedException;


/**
 * se realiza el alta de una Presupuesto.
 * 
 * @author Marcos
 * @since 29/03/2019
 */
class AgregarPresupuesto extends Action{

	
	public function execute(){

		$forward = new Forward();

		$page = PageFactory::build("PresupuestoAgregar");
		
		$presupuestoForm = $page->getComponentById("presupuestoForm");
		
		try {

			//creamos un nuevo presupuesto.
			$presupuesto = new Presupuesto();
			
			//completados con los datos del formulario.
			$presupuestoForm->fillEntity($presupuesto);
			
			//agregamos la presupuesto.
			UIServiceFactory::getUIPresupuestoService()->add( $presupuesto );
			
			$forward->setPageName( $presupuestoForm->getBackToOnSuccess() );
			$forward->addParam( "presupuestoOid", $presupuesto->getOid() );			
		
			$presupuestoForm->cleanSavedProperties();
			
		
		} catch (RastyException $e) {
		
			$forward->setPageName( "PresupuestoAgregar" );
			$forward->addError( Locale::localize($e->getMessage())  );
			
			//guardamos lo ingresado en el form.
			$presupuestoForm->save();
		}
		
		return $forward;
		
	}

}
?>
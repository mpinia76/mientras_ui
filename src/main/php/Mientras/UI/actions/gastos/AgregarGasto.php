<?php
namespace Mientras\UI\actions\gastos;


use Mientras\UI\components\form\gasto\GastoForm;

use Mientras\UI\service\UIServiceFactory;
use Mientras\Core\model\Gasto;

use Rasty\actions\Action;
use Rasty\actions\Forward;
use Rasty\utils\RastyUtils;
use Rasty\exception\RastyException;

use Rasty\security\RastySecurityContext;

use Rasty\i18n\Locale;
use Rasty\factory\PageFactory;
use Rasty\exception\RastyDuplicatedException;


/**
 * se realiza el alta de una Gasto.
 * 
 * @author Marcos
 * @since 09/03/2018
 */
class AgregarGasto extends Action{

	
	public function execute(){

		$forward = new Forward();

		$page = PageFactory::build("GastoAgregar");
		
		$gastoForm = $page->getComponentById("gastoForm");
		
		try {

			//creamos un nuevo gasto.
			$gasto = new Gasto();
			
			//completados con los datos del formulario.
			$gastoForm->fillEntity($gasto);
			
			//agregamos el gasto.
			UIServiceFactory::getUIGastoService()->add( $gasto );
			
			$forward->setPageName( $gastoForm->getBackToOnSuccess() );
			$forward->addParam( "gastoOid", $gasto->getOid() );			
		
			$gastoForm->cleanSavedProperties();
			
		
		} catch (RastyException $e) {
		
			$forward->setPageName( "GastoAgregar" );
			$forward->addError( Locale::localize($e->getMessage())  );
			
			//guardamos lo ingresado en el form.
			$gastoForm->save();
		}
		
		return $forward;
		
	}

}
?>
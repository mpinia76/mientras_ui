<?php
namespace Mientras\UI\actions\combos;


use Mientras\UI\components\form\combo\ComboForm;

use Mientras\UI\service\UIServiceFactory;
use Mientras\Core\model\Combo;

use Rasty\actions\Action;
use Rasty\actions\Forward;
use Rasty\utils\RastyUtils;
use Rasty\exception\RastyException;

use Rasty\security\RastySecurityContext;

use Rasty\i18n\Locale;
use Rasty\factory\PageFactory;
use Rasty\exception\RastyDuplicatedException;


/**
 * se realiza el alta de una Combo.
 * 
 * @author Marcos
 * @since 29/08/2019
 */
class AgregarCombo extends Action{

	
	public function execute(){

		$forward = new Forward();

		$page = PageFactory::build("ComboAgregar");
		
		$comboForm = $page->getComponentById("comboForm");
		
		try {

			//creamos un nuevo combo.
			$combo = new Combo();
			
			//completados con los datos del formulario.
			$comboForm->fillEntity($combo);
			
			//print_r($combo->getDetalles());
			//agregamos la combo.
			UIServiceFactory::getUIComboService()->add( $combo );
			
			$forward->setPageName( $comboForm->getBackToOnSuccess() );
			$forward->addParam( "comboOid", $combo->getOid() );			
		
			$comboForm->cleanSavedProperties();
			
		
		} catch (RastyException $e) {
		
			$forward->setPageName( "ComboAgregar" );
			$forward->addError( Locale::localize($e->getMessage())  );
			
			//guardamos lo ingresado en el form.
			$comboForm->save();
		}
		
		return $forward;
		
	}

}
?>
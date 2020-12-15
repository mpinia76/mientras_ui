<?php
namespace Mientras\UI\actions\combos;

use Mientras\UI\components\form\combo\ComboForm;

use Mientras\UI\service\UIServiceFactory;
use Mientras\UI\utils\MientrasUtils;

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
 * se realiza la actualización de un combo.
 * 
 * @author Marcos
 * @since 29/08/2019
 */
class ModificarCombo extends Action{

	
	public function execute(){

		$forward = new Forward();
		
		$page = PageFactory::build("ComboModificar");
		
		$comboForm = $page->getComponentById("comboForm");
			
		$oid = $comboForm->getOid();
						
		try {

			//obtenemos el combo.
			$combo = UIServiceFactory::getUIComboService()->get($oid );
		
			//lo editamos con los datos del formulario.
			$comboForm->fillEntity($combo);
			
			//guardamos los cambios.
			UIServiceFactory::getUIComboService()->update( $combo );
			
			$forward->setPageName( $comboForm->getBackToOnSuccess() );
			
			
			$comboForm->cleanSavedProperties();
			
		} catch (RastyException $e) {
		
			$forward->setPageName( "ComboModificar" );
			$forward->addError( Locale::localize($e->getMessage())  );
			$forward->addParam("oid", $oid );
			
			//guardamos lo ingresado en el form.
			$comboForm->save();
			
		}
		return $forward;
		
	}

}
?>
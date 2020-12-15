<?php
namespace Mientras\UI\actions\parametros;

use Mientras\UI\components\form\parametro\ParametroForm;

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
 * se realiza la actualización de una parametro.
 * 
 * @author Marcos
 * @since 16/07/2018
 */
class ModificarParametro extends Action{

	
	public function execute(){

		$forward = new Forward();
		
		$page = PageFactory::build("ParametroModificar");
		
		$parametroForm = $page->getComponentById("parametroForm");
			
		$oid = $parametroForm->getOid();
						
		try {

			//obtenemos la parametro.
			$parametro = UIServiceFactory::getUIParametroService()->get($oid );
		
			//lo editamos con los datos del formulario.
			$parametroForm->fillEntity($parametro);
			
			//guardamos los cambios.
			UIServiceFactory::getUIParametroService()->update( $parametro );
			
			$forward->setPageName( $parametroForm->getBackToOnSuccess() );
			$forward->addParam( "parametroOid", $parametro->getOid() );
			
			$parametroForm->cleanSavedProperties();
			
		} catch (RastyException $e) {
		
			$forward->setPageName( "ParametroModificar" );
			$forward->addError( Locale::localize($e->getMessage())  );
			$forward->addParam("oid", $oid );
			
			//guardamos lo ingresado en el form.
			$parametroForm->save();
			
		}
		return $forward;
		
	}

}
?>
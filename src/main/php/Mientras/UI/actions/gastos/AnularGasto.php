<?php
namespace Mientras\UI\actions\gastos;

use Mientras\UI\utils\MientrasUIUtils;

use Mientras\UI\service\UIServiceFactory;
use Mientras\Core\model\Gasto;
use Mientras\Core\utils\MientrasUtils;

use Rasty\actions\Action;
use Rasty\actions\Forward;
use Rasty\utils\RastyUtils;
use Rasty\exception\RastyException;

use Rasty\security\RastySecurityContext;

use Rasty\i18n\Locale;
use Rasty\factory\PageFactory;
use Rasty\exception\RastyDuplicatedException;


/**
 * se anula un Gasto
 * 
 * @author Marcos
 * @since 09/03/2018
 */
class AnularGasto extends Action{

	
	public function execute(){

		$forward = new Forward();
		
		
		//tomamos la gasto
		$gastoOid = RastyUtils::getParamPOST("gastoOid");
		$forward->addParam( "gastoOid", $gastoOid );
		try {

			//la recuperamos la gasto.
			$gasto = UIServiceFactory::getUIGastoService()->get( $gastoOid );
			
			$user = RastySecurityContext::getUser();
			$user = MientrasUtils::getUserByUsername($user->getUsername());
			
			UIServiceFactory::getUIGastoService()->anular($gasto, $user);			
			
			$forward->setPageName( "AdminHome" );
		
			
		} catch (RastyException $e) {
		
			$forward->setPageName( "GastoAnular" );
			$forward->addError( Locale::localize($e->getMessage())  );
			
		}
		
		return $forward;
		
	}

}
?>
<?php
namespace Mientras\UI\actions\presupuestos;

use Mientras\UI\utils\MientrasUIUtils;

use Mientras\UI\service\UIServiceFactory;
use Mientras\Core\model\Presupuesto;
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
 * se anula una presupuesto
 * 
 * @author Marcos
 * @since 29/03/2019
 */
class AnularPresupuesto extends Action{

	
	public function execute(){

		$forward = new Forward();
		
		
		//tomamos la presupuesto
		$presupuestoOid = RastyUtils::getParamPOST("presupuestoOid");
		$forward->addParam( "presupuestoOid", $presupuestoOid );
		try {

			//la recuperamos la presupuesto.
			$presupuesto = UIServiceFactory::getUIPresupuestoService()->get( $presupuestoOid );
			
			$user = RastySecurityContext::getUser();
			$user = MientrasUtils::getUserByUsername($user->getUsername());
			
			UIServiceFactory::getUIPresupuestoService()->anular($presupuesto, $user);			
			
			$forward->setPageName( "Presupuestos" );
		
			
		} catch (RastyException $e) {
		
			$forward->setPageName( "PresupuestoAnular" );
			$forward->addError( Locale::localize($e->getMessage())  );
			
		}
		
		return $forward;
		
	}

}
?>
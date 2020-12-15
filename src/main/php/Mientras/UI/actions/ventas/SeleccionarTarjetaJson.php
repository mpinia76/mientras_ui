<?php
namespace Mientras\UI\actions\ventas;

use Mientras\UI\utils\MientrasUIUtils;

use Mientras\UI\service\UITarjetaService;

use Mientras\UI\service\UIServiceFactory;



use Rasty\actions\JsonAction;
use Rasty\utils\RastyUtils;
use Rasty\exception\RastyException;

use Rasty\security\RastySecurityContext;

use Rasty\i18n\Locale;
use Rasty\factory\PageFactory;

use Rasty\app\RastyMapHelper;
use Rasty\factory\ComponentFactory;
use Rasty\factory\ComponentConfig;

use Rasty\utils\Logger;

/**
 * 
 * 
 * @author Marcos
 * @since 02/04/2018
 */
class SeleccionarTarjetaJson extends JsonAction{

	
	public function execute(){

		$rasty= RastyMapHelper::getInstance();
		
		try {

			

			$tarjetaCodigo = RastyUtils::getParamPOST("tarjeta");
			$tarjeta = UIServiceFactory::getUITarjetaService()->get($tarjetaCodigo);
			
			
			
			$result["titular"] = $tarjeta->getTitular();
			$result["marca"] = $tarjeta->getMarca();
			$result["nro"] = $tarjeta->getNro();
			
						
		} catch (RastyException $e) {
		
			$result["error"] = $e->getMessage();
		}
		
		return $result;
		
	}

}
?>
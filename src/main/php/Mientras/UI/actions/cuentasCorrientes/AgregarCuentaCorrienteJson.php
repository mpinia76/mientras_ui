<?php
namespace Mientras\UI\actions\cuentasCorrientes;

use Mientras\UI\utils\MientrasUIUtils;

use Mientras\UI\service\UIServiceFactory;

use Mientras\Core\model\CuentaCorriente;

use Rasty\actions\JsonAction;
use Rasty\utils\RastyUtils;
use Rasty\exception\RastyException;

use Rasty\security\RastySecurityContext;

use Rasty\i18n\Locale;
use Rasty\factory\PageFactory;

use Rasty\app\RastyMapHelper;
use Rasty\factory\ComponentFactory;
use Rasty\factory\ComponentConfig;

/**
 * se agrega la cuenta corriente de un cliente.
 * 
 * @author Marcos
 * @since 23-03-2018
 */
class AgregarCuentaCorrienteJson extends JsonAction{

	
	public function execute(){

		$rasty= RastyMapHelper::getInstance();
		
		try {

			$clienteOid = RastyUtils::getParamGET("clienteOid");

			$cliente = UIServiceFactory::getUIClienteService()->get($clienteOid);
			
			$ctacte = new CuentaCorriente();
			$ctacte->setFecha( new \Datetime() );
			$ctacte->setNumero( $clienteOid );
			$ctacte->setCliente( $cliente );
			$ctacte->setSaldoInicial( 0 );
			
			UIServiceFactory::getUICuentaCorrienteService()->add($ctacte);
			
			$result["clienteOid"] = $clienteOid;
			$result["cuentoCorrienteOid"] = $ctacte->getOid();
			
						
		} catch (RastyException $e) {
		
			$result["error"] = $e->getMessage();
		}
		
		return $result;
		
	}

}
?>
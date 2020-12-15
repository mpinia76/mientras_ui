<?php

//session_set_cookie_params(0, "cuentas_ui" );
session_start ();

use Mientras\UI\conf\MientrasUISetup;

use Rasty\utils\RastyUtils;
use Rasty\factory\ApplicationFactory;
use Rasty\utils\Logger;
use Rasty\security\RastySecurityContext;

include_once   'vendor/autoload.php';

//set_error_handler('myErrorHandler');
register_shutdown_function('fatalErrorShutdownHandler');

function myErrorHandler($errno, $errstr, $errfile, $errline){
	
   if (!(error_reporting() & $errno)) {
        // Este código de error no está incluido en error_reporting
        return;
    }

    switch ($errno) {
    case E_USER_ERROR:
        echo "<b>Mi ERROR</b> [$errno] $errstr<br />\n";
        echo "  Error fatal en la línea $errline en el archivo $errfile";
        echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
        echo "Abortando...<br />\n";
        exit(1);
        break;

    case E_USER_WARNING:
        echo "<b>Mi WARNING</b> [$errno] $errstr<br />\n";
        break;

    case E_USER_NOTICE:
        echo "<b>Mi NOTICE</b> [$errno] $errstr<br />\n";
        break;

    default:
        echo "Tipo de error desconocido: [$errno] $errstr<br />\n";
        break;
    }

   	//header("Location: http://localhost/turnos_ui");
    
    /* No ejecutar el gestor de errores interno de PHP */
    return true;
}

function fatalErrorShutdownHandler()
{
  $last_error = error_get_last();
  if ($last_error['type'] === E_ERROR) {
    // fatal error
    myErrorHandler(E_ERROR, $last_error['message'], $last_error['file'], $last_error['line']);
  }
}


$appname = "mientras_ui";

if (isset($_SESSION[$appname]['LAST_ACTIVITY']) && (time() - $_SESSION[$appname]['LAST_ACTIVITY'] > 7200)) {
	//RastySecurityContext::logout();
}

$_SESSION[$appname]['LAST_ACTIVITY'] = time();

/*
ob_start();
system('java -jar /home/bernardo/workspacejee/cuentas-proxy/bin/cuentas-proxy.jar', $retval);
$factory = trim(ob_get_contents()); 
ob_clean();
*/
MientrasUISetup::initialize($appname);

$type = RastyUtils::getParamGET('type') ; //

/*
try {
	$oClass = new \ReflectionClass($factory);
	$oFactory = $oClass->newInstance();
	$oFactory::build( $type )->execute();
	
} catch (Exception $e) {
	echo $e->getMessage();
}

*/

$oApp = ApplicationFactory::build( $type );

$oApp->execute();

?>
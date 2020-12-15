<?php
namespace Mientras\UI\actions\tiposProducto;


use Mientras\UI\components\form\tipoProducto\TipoProductoForm;

use Mientras\UI\service\UIServiceFactory;
use Mientras\Core\model\TipoProducto;

use Rasty\actions\Action;
use Rasty\actions\Forward;
use Rasty\utils\RastyUtils;
use Rasty\exception\RastyException;

use Rasty\security\RastySecurityContext;

use Rasty\i18n\Locale;
use Rasty\factory\PageFactory;
use Rasty\exception\RastyDuplicatedException;


/**
 * se realiza el alta de una TipoProducto.
 * 
 * @author Marcos
 * @since 05/03/2018
 */
class AgregarTipoProducto extends Action{

	
	public function execute(){

		$forward = new Forward();

		$page = PageFactory::build("TipoProductoAgregar");
		
		$tipoProductoForm = $page->getComponentById("tipoProductoForm");
		
		try {

			//creamos una nueva tipoProducto.
			$tipoProducto = new TipoProducto();
			
			//completados con los datos del formulario.
			$tipoProductoForm->fillEntity($tipoProducto);
			
			//agregamos el tipoProducto.
			UIServiceFactory::getUITipoProductoService()->add( $tipoProducto );
			
			$forward->setPageName( $tipoProductoForm->getBackToOnSuccess() );
			$forward->addParam( "tipoProductoOid", $tipoProducto->getOid() );			
		
			$tipoProductoForm->cleanSavedProperties();
			
		
		} catch (RastyException $e) {
		
			$forward->setPageName( "TipoProductoAgregar" );
			$forward->addError( Locale::localize($e->getMessage())  );
			
			//guardamos lo ingresado en el form.
			$tipoProductoForm->save();
		}
		
		return $forward;
		
	}

}
?>
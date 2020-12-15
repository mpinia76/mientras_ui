<?php
namespace Mientras\UI\actions\marcasProducto;


use Mientras\UI\components\form\marcaProducto\MarcaProductoForm;

use Mientras\UI\service\UIServiceFactory;
use Mientras\Core\model\MarcaProducto;

use Rasty\actions\Action;
use Rasty\actions\Forward;
use Rasty\utils\RastyUtils;
use Rasty\exception\RastyException;

use Rasty\security\RastySecurityContext;

use Rasty\i18n\Locale;
use Rasty\factory\PageFactory;
use Rasty\exception\RastyDuplicatedException;


/**
 * se realiza el alta de una MarcaProducto.
 * 
 * @author Marcos
 * @since 05/03/2018
 */
class AgregarMarcaProducto extends Action{

	
	public function execute(){

		$forward = new Forward();

		$page = PageFactory::build("MarcaProductoAgregar");
		
		$marcaProductoForm = $page->getComponentById("marcaProductoForm");
		
		try {

			//creamos una nueva marcaProducto.
			$marcaProducto = new MarcaProducto();
			
			//completados con los datos del formulario.
			$marcaProductoForm->fillEntity($marcaProducto);
			
			//agregamos el marcaProducto.
			UIServiceFactory::getUIMarcaProductoService()->add( $marcaProducto );
			
			$forward->setPageName( $marcaProductoForm->getBackToOnSuccess() );
			$forward->addParam( "marcaProductoOid", $marcaProducto->getOid() );			
		
			$marcaProductoForm->cleanSavedProperties();
			
		
		} catch (RastyException $e) {
		
			$forward->setPageName( "MarcaProductoAgregar" );
			$forward->addError( Locale::localize($e->getMessage())  );
			
			//guardamos lo ingresado en el form.
			$marcaProductoForm->save();
		}
		
		return $forward;
		
	}

}
?>
<?php
namespace Mientras\UI\actions\productos;

use Mientras\UI\utils\MientrasUIUtils;

use Mientras\UI\components\form\producto\ProductoForm;

use Mientras\UI\service\UIServiceFactory;
use Mientras\Core\model\Producto;

use Rasty\actions\Action;
use Rasty\actions\Forward;
use Rasty\utils\RastyUtils;
use Rasty\exception\RastyException;

use Rasty\security\RastySecurityContext;

use Rasty\i18n\Locale;
use Rasty\factory\PageFactory;
use Rasty\exception\RastyDuplicatedException;


/**
 * se realiza el alta de un producto.
 * 
 * @author Marcos
 * @since 06/03/2018
 */
class AgregarProducto extends Action{

	
	public function execute(){

		$forward = new Forward();

		$page = PageFactory::build("ProductoAgregar");
		
		$productoForm = $page->getComponentById("productoForm");
		
		try {

			//creamos un nuevo producto.
			$producto = new Producto();
			
			//completados con los datos del formulario.
			$productoForm->fillEntity($producto);
			
			//agregamos el producto.
			UIServiceFactory::getUIProductoService()->add( $producto );
			
			$forward->setPageName( $productoForm->getBackToOnSuccess() );
			$forward->addParam( "productoOid", $producto->getOid() );			
		
			$productoForm->cleanSavedProperties();
			
		} catch (RastyDuplicatedException $e) {
		
			$forward->setPageName( "ProductoAgregar" );
			$forward->addError( Locale::localize($e->getMessage())  );
						
			//guardamos lo ingresado en el form.
			$productoForm->save();
		
		} catch (RastyException $e) {
		
			$forward->setPageName( "ProductoAgregar" );
			$forward->addError( Locale::localize($e->getMessage())  );
						
			//guardamos lo ingresado en el form.
			$productoForm->save();
		}
		
		return $forward;
		
	}

}
?>
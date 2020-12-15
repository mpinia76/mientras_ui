<?php
namespace Mientras\UI\actions\combos;

use Mientras\UI\utils\MientrasUIUtils;

use Mientras\UI\service\UIProductoService;

use Mientras\UI\service\UIServiceFactory;

use Mientras\Core\model\ProductoCombo;

use Mientras\UI\components\filter\model\UIProductoCriteria;

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
 * se agregar un producto de combo para la edición
 * en sesión.
 * 
 * @author Marcos
 * @since 29/08/2019
 */
class AgregarProductoComboJson extends JsonAction{

	
	public function execute(){

		$rasty= RastyMapHelper::getInstance();
		
		try {

			//creamos el producto de combo.
			$producto = new ProductoCombo();

			$productoCodigo = RastyUtils::getParamPOST("producto");
			$cantidad = RastyUtils::getParamPOST("cantidad");
			$precio = $value = str_replace(',', '.', RastyUtils::getParamPOST("precio"));
			
			
			/*$uiCriteria = new UIProductoCriteria();
			$uiCriteria->setCodigoExacto( $productoCodigo );
		
			$oProducto = UIServiceFactory::getUIProductoService()->getByCriteria( $uiCriteria );*/
			
			$producto->setProducto(UIServiceFactory::getUIProductoService()->get ($productoCodigo) );
			$producto->setCantidad( $cantidad );
			$producto->setPrecioUnitario( $precio );
			
			
			//tomamos los productos de sesión y agregamos el nuevo.
			MientrasUIUtils::agregarProductoComboSession($producto);			
			
			$productos = MientrasUIUtils::getProductosComboSession();
			$result["productos"] = $productos;
			
			$result["cantidad"] = 0;
			$result["importe"] = 0;
			
			foreach ($productos as $productojson) {
				//print_r($productojson);
				$result["importe"] += $productojson["subtotal"];
				$result["cantidad"] += $productojson["cantidad"];
			}
			
						
		} catch (RastyException $e) {
		
			$result["error"] = $e->getMessage();
		}
		
		return $result;
		
	}

}
?>
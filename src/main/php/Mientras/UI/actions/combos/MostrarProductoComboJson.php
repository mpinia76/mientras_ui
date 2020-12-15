<?php
namespace Mientras\UI\actions\combos;

use Mientras\UI\utils\MientrasUIUtils;



use Mientras\UI\service\UIServiceFactory;

use Mientras\Core\model\ProductoCombo;



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
class MostrarProductoComboJson extends JsonAction{

	
	public function execute(){

		$rasty= RastyMapHelper::getInstance();
		
		try {

			//creamos el producto de combo.
			$producto = new ProductoCombo();

				
			
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
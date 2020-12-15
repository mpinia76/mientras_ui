<?php
namespace Mientras\UI\actions\combos;

use Mientras\UI\utils\MientrasUIUtils;

use Mientras\UI\service\UIProductoService;

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

/**
 * se borra un producto de combo para la edición
 * en sesión.
 * 
 * @author Marcos
 * @since 29/08/2019
 */
class BorrarProductoComboJson extends JsonAction{

	
	public function execute(){

		$rasty= RastyMapHelper::getInstance();
		
		try {

			//indice del producto a eliminar.
			$index = RastyUtils::getParamPOST("index");
			if(empty($index))
				$index = 0;
			//eliminamos el producto dado el índice
			MientrasUIUtils::borrarProductoComboSession($index);			
			
			$productos = MientrasUIUtils::getProductosComboSession();
			$result["productos"] = $productos;
			
			$result["importe"] = 0;
			foreach ($productos as $productojson) {
				$result["importe"] += $productojson["subtotal"];
			}
			
			
						
		} catch (RastyException $e) {
		
			$result["error"] = $e->getMessage();
		}
		
		return $result;
		
	}

}
?>
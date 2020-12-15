<?php
namespace Mientras\UI\actions\ventas;

use Mientras\UI\utils\MientrasUIUtils;

use Mientras\UI\service\UIProductoService;

use Mientras\UI\service\UIServiceFactory;

use Mientras\Core\model\DetalleVenta;

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
 * se agregar un detalle de venta para la edición
 * en sesión.
 * 
 * @author Marcos
 * @since 13/03/2018
 */
class AgregarDetalleVentaJson extends JsonAction{

	
	public function execute(){

		$rasty= RastyMapHelper::getInstance();
		
		try {

			//creamos el detalle de venta.
			$detalle = new DetalleVenta();

			$productoCodigo = RastyUtils::getParamPOST("producto");
			$cantidad = RastyUtils::getParamPOST("cantidad");
			$precio = $value = str_replace(',', '.', RastyUtils::getParamPOST("precio"));
			$costo = $value = str_replace(',', '.', RastyUtils::getParamPOST("costo"));
			
			/*$uiCriteria = new UIProductoCriteria();
			$uiCriteria->setCodigoExacto( $productoCodigo );
		
			$oProducto = UIServiceFactory::getUIProductoService()->getByCriteria( $uiCriteria );*/
			
			$detalle->setProducto(UIServiceFactory::getUIProductoService()->get ($productoCodigo) );
			$detalle->setCantidad( $cantidad );
			$detalle->setPrecioUnitario( $precio );
			$detalle->setCosto( $costo );
			$detalle->setStockActualizado(2);
			
			//tomamos los detalles de sesión y agregamos el nuevo.
			MientrasUIUtils::agregarDetalleVentaSession($detalle);			
			
			$detalles = MientrasUIUtils::getDetallesVentaSession();
			$result["detalles"] = $detalles;
			
			$result["cantidad"] = 0;
			$result["importe"] = 0;
			
			foreach ($detalles as $detallejson) {
				//print_r($detallejson);
				$result["importe"] += $detallejson["subtotal"];
				$result["cantidad"] += $detallejson["cantidad"];
			}
			
						
		} catch (RastyException $e) {
		
			$result["error"] = $e->getMessage();
		}
		
		return $result;
		
	}

}
?>
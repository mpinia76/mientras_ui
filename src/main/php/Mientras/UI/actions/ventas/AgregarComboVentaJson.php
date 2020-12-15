<?php
namespace Mientras\UI\actions\ventas;

use Mientras\UI\utils\MientrasUIUtils;

use Mientras\UI\service\UIProductoService;

use Mientras\UI\service\UIComboService;

use Mientras\UI\service\UIServiceFactory;

use Mientras\Core\model\DetalleVenta;

use Mientras\UI\components\filter\model\UIProductoCriteria;

use Mientras\UI\components\filter\model\UIComboCriteria;

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
class AgregarComboVentaJson extends JsonAction{

	
	public function execute(){

		$rasty= RastyMapHelper::getInstance();
		
		try {

			//creamos el detalle de venta.
			$detalle = new DetalleVenta();

			$comboOid = RastyUtils::getParamPOST("combo");
			
			
		
			$oCombo = UIServiceFactory::getUIComboService()->get( $comboOid );
			
			foreach ($oCombo->getProductos() as $producto) {
				
			
				$oProducto = UIServiceFactory::getUIProductoService()->get( $producto->getProducto()->getOid() );
				
				$detalle->setProducto($oProducto  );
				$detalle->setCombo($oCombo  );
				$detalle->setCantidad( $producto->getCantidad() );
				$detalle->setPrecioUnitario( $producto->getPrecioUnitario() );
				$detalle->setCosto( $oProducto->getCosto() );
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
			}
			
			
						
		} catch (RastyException $e) {
		
			$result["error"] = $e->getMessage();
		}
		
		return $result;
		
	}

}
?>
<?php
namespace Mientras\UI\actions\presupuestos;

use Mientras\UI\utils\MientrasUIUtils;

use Mientras\UI\service\UIProductoService;

use Mientras\UI\service\UIServiceFactory;

use Mientras\Core\model\DetallePresupuesto;

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
 * se agregar un detalle de presupuesto para la edición
 * en sesión.
 * 
 * @author Marcos
 * @since 29/03/2019
 */
class AgregarDetallePresupuestoJson extends JsonAction{

	
	public function execute(){

		$rasty= RastyMapHelper::getInstance();
		
		try {

			//creamos el detalle de presupuesto.
			$detalle = new DetallePresupuesto();

			$productoCodigo = RastyUtils::getParamPOST("producto");
			$cantidad = RastyUtils::getParamPOST("cantidad");
			$precio = $value = str_replace(',', '.', RastyUtils::getParamPOST("precio"));
			
			$uiCriteria = new UIProductoCriteria();
			$uiCriteria->setCodigoExacto( $productoCodigo );
		
			$oProducto = UIServiceFactory::getUIProductoService()->getByCriteria( $uiCriteria );
			
			$detalle->setProducto($oProducto  );
			$detalle->setCantidad( $cantidad );
			$detalle->setPrecioUnitario( $precio );
			
			
			
			//tomamos los detalles de sesión y agregamos el nuevo.
			MientrasUIUtils::agregarDetallePresupuestoSession($detalle);			
			
			$detalles = MientrasUIUtils::getDetallesPresupuestoSession();
			$result["detalles"] = $detalles;
			
			$result["cantidad"] = 0;
			$result["importe"] = 0;
			
			foreach ($detalles as $detallejson) {
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
<?php
namespace Mientras\UI\components\filter\producto;

use Mientras\UI\components\filter\model\UIProductoCriteria;

use Rasty\factory\ComponentConfig;
use Rasty\factory\ComponentFactory;

use Rasty\components\RastyComponent;
use Rasty\utils\RastyUtils;
use Rasty\utils\ReflectionUtils;
use Rasty\utils\Logger;
use Rasty\utils\XTemplate;

use Rasty\i18n\Locale;
use Rasty\app\RastyMapHelper;

use Mientras\UI\service\UIServiceFactory;

use Rasty\exception\RastyException;

/**
 * componente para accesos rápidos de productos.
 *
 * @author Marcos Piñero (marcosp@codnet.com.ar)
 * @since 02-08-2020
 *
 */
class AccesosRapidos extends RastyComponent{

	
	
	
	public function getType(){
		return "AccesosRapidos";
	}
	
	
	protected function parseXTemplate(XTemplate $xtpl){

		parent::parseXTemplate($xtpl);
		$criteria = new UIProductoCriteria();
		$criteria->setNombre(RastyUtils::getParamPOST("nombreProducto"));
		$criteria->setMarcaProducto(RastyUtils::getParamPOST("marcaProducto"));
		$criteria->setTipoProducto(RastyUtils::getParamPOST("tipoProducto"));
		$criteria->addOrder("tipoProducto", "ASC");
		
		$productos = UIServiceFactory::getUIProductoService()->getList($criteria);
		foreach ($productos as $producto) {
			$xtpl->assign("oid", $producto->getOid() );
			$xtpl->assign("codigo", $producto->getOid() );
			$xtpl->assign("nombre", $producto );
			//$xtpl->assign("logo", CuentasUIUtils::getImagenProducto($producto));
			$xtpl->parse("main.agregar_producto");
		}
		
	}
	
}
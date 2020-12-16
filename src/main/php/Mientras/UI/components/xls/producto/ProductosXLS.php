<?php

namespace Mientras\UI\components\xls\producto;

use Datetime;
use Mientras\UI\utils\MientrasUIUtils;

use Mientras\UI\service\UIServiceFactory;

use Rasty\components\RastyComponent;
use Rasty\utils\RastyUtils;

use Rasty\utils\XTemplate;

use Mientras\UI\components\filter\model\UIProductoCriteria;

use Mientras\UI\components\filter\model\UITipoProductoCriteria;
use Mientras\UI\components\filter\model\UIComboCriteria;

use Rasty\utils\LinkBuilder;
use Rasty\render\DOMPDFRenderer;
use Rasty\conf\RastyConfig;
use Rasty\factory\PageFactory;

use Rasty\utils\Logger;


/**
 * para renderizar en pdf listado de precios.
 *
 * @author Marcos
 * @since 30-07-2020
 *
 */
class ProductosXLS extends RastyComponent{



	public function getType(){

		return "ProductosXLS";

	}

	public function __construct(){


	}

	public function getFileName(){
		"precios";

	}


	protected function parseXTemplate(XTemplate $xtpl){

		$page = PageFactory::build("Productos");

		$productoCriteria = new UIProductoCriteria();

		$productoFilter = $page->getComponentById("productosFilter");

		$productoFilter->fillFromSaved($productoCriteria);
		$xtpl->assign( "APP_PATH", RastyConfig::getInstance()->getAppPath() );
		$xtpl->assign( "fecha", MientrasUIUtils::formatDateTimeToView(new Datetime()) );



		$xtpl->assign("lbl_detalle_nombre", $this->localize( "venta.detalle.producto" ) );
		$xtpl->assign("lbl_detalle_precio", $this->localize( "venta.detalle.precio" ) );


		$tipoProductoCriteria = new UITipoProductoCriteria();
		$tipoProductoCriteria->setNombre($productoCriteria->getTipoProducto());
		$tipoProductoCriteria->addOrder('nombre','ASC');
		$tipos = UIServiceFactory::getUITipoProductoService()->getList($tipoProductoCriteria);
		$html ='';
		$packs=array();
		$arrTipos=array();
		$arrProductos=array();
		foreach ($tipos as $tipo) {
			$xtpl->assign( "tipoproducto", $tipo );
			$productoCriteria->addOrder('marcaProducto','ASC');
			$productoCriteria->setTipoProducto($tipo);
			$productos = UIServiceFactory::getUIProductoService()->getList($productoCriteria);
			foreach ($productos as $producto) {
				$arrProductos[]=$producto->getOid();
				$xtpl->assign( "producto", $producto->getMarcaProducto().' '.$producto->getNombre() );

				$xtpl->assign( "precio", MientrasUIUtils::formatMontoToView( $producto->getPrecioEfectivo() ) );

				$xtpl->parse( "main.productos.detalle" );


			}
			if ($productos) {
				$xtpl->parse( "main.productos" );
			}

		}
		$html ='';
		//Logger::logObject($arrTipos);
		if (count($packs)>0) {
			$html.='


					<table cellspacing="0" cellpadding="0" border="1">
						<thead><tr><th colspan="3" align="center">'.$this->localize( "menu.productos.packs" ).'</th></tr></thead>';
			foreach ($arrTipos as $arrTipo) {
				$html.='

						<thead><tr><th colspan="3" align="center">'.$arrTipo->getNombre().'</th></tr></thead>
							<thead><tr><th width="450px">'.$this->localize( "venta.detalle.producto" ).'</th><th>'.$this->localize( "venta.detalle.cantidad" ).'</th><th width="100px">'.$this->localize( "venta.detalle.precio" ).'</th></tr></thead>';


				foreach ($packs as $pack) {
					if ($arrTipo->getOid()==$pack->getProducto()->getTipoProducto()->getOid()) {
						$html.='<tr><td>'.$pack->getProducto()->getMarcaProducto().' '.$pack->getProducto()->getNombre().' '.$pack->getNombre().'</td><td style="text-align: right;">'.$pack->getCantidad().'</td><td style="text-align: right;">'.MientrasUIUtils::formatMontoToView($pack->getPrecioEfectivo()).'</td></tr>';
					}


				}
			}

			$html.='</table></table>
					';
		}



			$xtpl->assign( "htmlPacks", $html );


			$html ='';
		//Logger::logObject($arrTipos);
			//if (!$oVendedor->getMayorista()) {
				$uiCriteria = new UIComboCriteria();



				$uiCriteria->addOrder("nombre", "ASC");
				$combos = UIServiceFactory::getUIComboService()->getList($uiCriteria);

				$mostrarCombo=0;
				$arrayCombos=array();
				foreach ($combos as $combo) {
					$contieneProducto=0;
					foreach ($combo->getProductos() as $value) {
						if (in_array($value->getProducto()->getOid(),$arrProductos)){
							//Logger::log('Pone: '.$value->getProducto()->getOid());
							$contieneProducto=1;
							$mostrarCombo=1;

						}

					}
					if ($contieneProducto) {
							$arrayCombos[]=$combo;
						}
				}
			//Logger::logObject($arrayCombos);
			if ($mostrarCombo) {
				$html.='


									<table cellspacing="0" cellpadding="0" border="1">
										<thead><tr><th colspan="2" align="center">'.$this->localize( "menu.combos" ).'</th></tr></thead>';

								$html.='


											<thead><tr><th width="450px">'.$this->localize( "venta.detalle.producto" ).'</th><th width="100px">'.$this->localize( "venta.detalle.precio" ).'</th></tr></thead>';


								foreach ($arrayCombos as $combo) {
									$productos='(';
									foreach ($combo->getProductos() as $value) {
										$productos.= $value->getCantidad(). ' '.$value->getProducto()->getNombre().' '.$value->getProducto()->getMarcaProducto().' '.MientrasUIUtils::formatMontoToView($value->getPrecioUnitario()).'-';
									}
									$productos.=')';
										$html.='<tr><td>'.$combo->getNombre().' '.$productos.'</td><td style="text-align: right;">'.MientrasUIUtils::formatMontoToView( $combo->getPrecio() ).'</td></tr>';



								}


							$html.='</table>
									';
			}

		//}



			$xtpl->assign( "htmlCombos", $html );



	}








}
?>

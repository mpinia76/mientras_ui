<?php
namespace Mientras\UI\pages\productos;

use Mientras\UI\pages\MientrasPage;

use Mientras\UI\components\filter\model\UIProductoCriteria;

use Mientras\UI\components\grid\model\ProductoGridModel;

use Mientras\UI\service\UIProductoService;

use Mientras\UI\utils\MientrasUtils;

use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;
use Rasty\i18n\Locale;

use Mientras\Core\model\Producto;
use Mientras\Core\criteria\ProductoCriteria;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;


/**
 * Página para consultar los productos.
 *
 * @author Marcos
 * @since 06/03/2018
 *
 */
class Productos extends MientrasPage{


	private $productoCriteria;

	public function __construct(){
		$productoCriteria = new ProductoCriteria();


		$this->setProductoCriteria($productoCriteria);
	}

	public function getTitle(){
		return $this->localize( "productos.title" );
	}

	public function getMenuGroups(){

		//TODO construirlo a partir del usuario
		//y utilizando permisos

		$menuGroup = new MenuGroup();

		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "producto.agregar") );
		$menuOption->setPageName("ProductoAgregar");
		$menuOption->setImageSource( $this->getWebPath() . "css/images/add_over_48.png" );
		$menuGroup->addMenuOption( $menuOption );


		return array($menuGroup);
	}

	public function getType(){

		return "Productos";

	}

	public function getModelClazz(){
		return get_class( new ProductoGridModel() );
	}

	public function getUicriteriaClazz(){
		return get_class( new UIProductoCriteria() );
	}

	protected function parseXTemplate(XTemplate $xtpl){

		$xtpl->assign("legend_operaciones", $this->localize("grid.operaciones") );
		$xtpl->assign("legend_resultados", $this->localize("grid.resultados") );

		$xtpl->assign("agregar_label", $this->localize("producto.agregar") );

		$productoFilter = $this->getComponentById("productosFilter");

		$productoFilter->fillFromSaved( $this->getProductoCriteria() );

        $xtpl->assign("lbl_pdf", $this->localize("menu.productos.precios") );
        $xtpl->assign("linkPdf", $this->getLinkProductosPdf() );
        $xtpl->assign("linkXls", $this->getLinkProductosXls() );

        $xtpl->parse("main.opciones.add");
        $xtpl->parse("main.opciones");
	}


	public function getProductoCriteria()
	{
	    return $this->productoCriteria;
	}

	public function setProductoCriteria($productoCriteria)
	{
	    $this->productoCriteria = $productoCriteria;
	}
}
?>

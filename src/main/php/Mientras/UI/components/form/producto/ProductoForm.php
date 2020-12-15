<?php

namespace Mientras\UI\components\form\producto;

use Mientras\UI\components\filter\model\UIProductoCriteria;

use Mientras\UI\service\finder\ProductoFinder;

use Mientras\UI\components\filter\model\UITipoProductoCriteria;

use Mientras\UI\service\finder\TipoProductoFinder;

use Mientras\UI\components\filter\model\UIMarcaProductoCriteria;

use Mientras\UI\service\finder\MarcaProductoFinder;

use Mientras\UI\components\filter\model\UIIvaCriteria;

use Mientras\UI\service\finder\IvaFinder;

use Mientras\UI\utils\MientrasUIUtils;

use Mientras\UI\service\UIServiceFactory;


use Rasty\Forms\form\Form;

use Rasty\components\RastyComponent;
use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;


use Mientras\Core\model\Producto;

use Mientras\Core\model\TipoProducto;
use Mientras\Core\model\MarcaProducto;
use Mientras\Core\model\Iva;

use Rasty\utils\LinkBuilder;

/**
 * Formulario para producto

 * @author Marcos
 * @since 02/03/2018
 */
class ProductoForm extends Form{
		
	

	/**
	 * label para el cancel
	 * @var string
	 */
	private $labelCancel;
	

	/**
	 * 
	 * @var Producto
	 */
	private $producto;
	
	
	public function __construct(){

		parent::__construct();
		$this->setLabelCancel("form.cancelar");
		
		$this->addProperty("nombre");
		
		$this->addProperty("tipoProducto");
		$this->addProperty("marcaProducto");
		$this->addProperty("iva");
		$this->addProperty("stock");
		$this->addProperty("costo");
		$this->addProperty("stockMinimo");
		$this->addProperty("porcentajeGanancia");
		$this->addProperty("precioLista");
		$this->addProperty("precioEfectivo");
		
		$this->addProperty("descripcion");
		
		$this->addProperty("vencimiento");
		
		
		
		$this->setBackToOnSuccess("Productos");
		$this->setBackToOnCancel("Productos");
		
	}
	
	public function getOid(){
		
		return $this->getComponentById("oid")->getPopulatedValue( $this->getMethod() );
	}
	
	
	public function getType(){
		
		return "ProductoForm";
		
	}
	
	public function fillEntity($entity){
		
		parent::fillEntity($entity);
		
		
		$entity->setFecha(new \Datetime() );
		
		
		
	}

	protected function parseXTemplate(XTemplate $xtpl){

		parent::parseXTemplate($xtpl);
		
		
		$xtpl->assign("cancel", $this->getLinkCancel() );
		$xtpl->assign("lbl_cancel", $this->localize( $this->getLabelCancel() ) );
		
		
		$xtpl->assign("lbl_nombre", $this->localize("producto.nombre") );
		$xtpl->assign("lbl_tipoProducto", $this->localize("producto.tipoProducto") );
		$xtpl->assign("lbl_marcaProducto", $this->localize("producto.marcaProducto") );
		$xtpl->assign("lbl_costo", $this->localize("producto.costo") );
		$xtpl->assign("lbl_stock", $this->localize("producto.stock") );
		$xtpl->assign("lbl_stockMinimo", $this->localize("producto.stockMinimo") );
		$xtpl->assign("lbl_porcentajeGanancia", $this->localize("producto.porcentajeGanancia") );
		$xtpl->assign("lbl_precioLista", $this->localize("producto.precioLista") );
		$xtpl->assign("lbl_precioEfectivo", $this->localize("producto.precioEfectivo") );
		
		
		$xtpl->assign("lbl_descripcion", $this->localize("producto.descripcion") );
		
		$xtpl->assign("lbl_iva", $this->localize("producto.iva") );
		$xtpl->assign("lbl_vencimiento", $this->localize("producto.vencimiento") );
	}


	public function getLabelCancel()
	{
	    return $this->labelCancel;
	}

	public function setLabelCancel($labelCancel)
	{
	    $this->labelCancel = $labelCancel;
	}


	
	public function getProducto()
	{
	    return $this->producto;
	}

	public function setProducto($producto)
	{
	    $this->producto = $producto;
	    
	}
	
	public function getLinkCancel(){
		$params = array();
		
		return LinkBuilder::getPageUrl( $this->getBackToOnCancel() , $params) ;
	}


	public function getTipoProductoFinderClazz(){
		
		return get_class( new TipoProductoFinder() );
		
	}	
	
	
	public function getTiposProducto(){
		$criteria = new UITipoProductoCriteria();
		
		$criteria->addOrder("nombre", "ASC");
		$tiposProducto = UIServiceFactory::getUITipoProductoService()->getList( $criteria);
		
		return $tiposProducto;
	}
	
	public function getMarcaProductoFinderClazz(){
		
		return get_class( new MarcaProductoFinder() );
		
	}	
	
	
	public function getMarcasProducto(){
		$criteria = new UIMarcaProductoCriteria();
		
		$criteria->addOrder("nombre", "ASC");
		$marcasProducto = UIServiceFactory::getUIMarcaProductoService()->getList( $criteria);
		
		
		return $marcasProducto;
	}
	
	public function getIvaFinderClazz(){
		
		return get_class( new IvaFinder() );
		
	}	
	
	
	public function getIvas(){
		
		$ivas = UIServiceFactory::getUIIvaService()->getList( new UIIvaCriteria() );
		
		return $ivas;
	}
}
?>
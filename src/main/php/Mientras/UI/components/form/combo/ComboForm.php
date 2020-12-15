<?php

namespace Mientras\UI\components\form\combo;





use Mientras\UI\service\finder\ProductoFinder;


use Mientras\UI\utils\MientrasUIUtils;

use Mientras\UI\service\UIServiceFactory;

use Rasty\Forms\form\Form;

use Rasty\components\RastyComponent;
use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;


use Mientras\Core\model\Combo;
use Mientras\Core\model\ProductoCombo;


use Rasty\utils\LinkBuilder;
use Rasty\security\RastySecurityContext;

/**
 * Formulario para combo

 * @author Marcos
 * @since 29/08/2019
 */
class ComboForm extends Form{
		
	

	/**
	 * label para el cancel
	 * @var string
	 */
	private $labelCancel;
	

	/**
	 * 
	 * @var Combo
	 */
	private $combo;
	
	private $producto;
	
	public function __construct(){

		parent::__construct();
		$this->setLabelCancel("combo.cancelar");
		$this->setLabelSubmit("combo.confirmar");
		
		$this->addProperty("fecha");
		
		$this->addProperty("nombre");
		
		
		$this->setBackToOnSuccess("Combos");
		$this->setBackToOnCancel("Combos");
		
	}
	
	public function getOid(){
		
		return $this->getComponentById("oid")->getPopulatedValue( $this->getMethod() );
	}
	
	
	public function getType(){
		
		return "ComboForm";
		
	}
	
	public function fillEntity($entity){
		
		//le agregamos los productos de sesión.
		$productos = MientrasUIUtils::getProductosComboSession();
		
		
		parent::fillEntity($entity);
		
		
		foreach ($productos as $productojson) {
			$producto = new ProductoCombo();
			
			$producto->setCantidad( $productojson["cantidad"] );
			$producto->setPrecioUnitario( $productojson["precioUnitario"] );
			
			$producto->setProducto( UIServiceFactory::getUIProductoService()->get($productojson["producto_oid"]) );
			
			$entity->addProducto( $producto );
			
		}
		
		
		
		
	}

	protected function parseXTemplate(XTemplate $xtpl){

		parent::parseXTemplate($xtpl);
		
		$xtpl->assign("cancel", $this->getLinkCancel() );
		$xtpl->assign("lbl_cancel", $this->localize( $this->getLabelCancel() ) );
		
		$xtpl->assign("lbl_fecha", $this->localize("combo.fecha") );
		
		$xtpl->assign("lbl_nombre", $this->localize("combo.nombre") );
		
		
		$xtpl->assign("productos_legend", $this->localize("combo.agregar.productos_legend") );
		$xtpl->assign("lbl_producto_nombre", $this->localize( "combo.producto.producto" ) );
		$xtpl->assign("lbl_producto_precio", $this->localize( "combo.producto.precio" ) );
		$xtpl->assign("lbl_producto_cantidad", $this->localize( "combo.producto.cantidad" ) );
		$xtpl->assign("lbl_producto_subtotal", $this->localize( "combo.producto.subtotal" ) );
		
		
		$xtpl->assign("linkConsultarStockProducto", $this->getLinkActionConsultarStockProducto() );
		$xtpl->assign("linkAgregarProducto", $this->getLinkActionAgregarProducto() );
		$xtpl->assign("linkBorrarProducto", $this->getLinkActionBorrarProducto() );
		
		$xtpl->assign("linkMostrarProducto", $this->getLinkActionMostrarProducto() );
	
		
		
	}


	public function getLabelCancel()
	{
	    return $this->labelCancel;
	}

	public function setLabelCancel($labelCancel)
	{
	    $this->labelCancel = $labelCancel;
	}

	public function getLinkCancel(){
		$params = array();
		
		return LinkBuilder::getPageUrl( $this->getBackToOnCancel() , $params) ;
	}
	
	
	
	public function getProductoFinderClazz(){
		
		return get_class( new ProductoFinder() );
		
	}	
	
	public function getCombo()
	{
	    return $this->combo;
	}

	public function setCombo($combo)
	{
	    $this->combo = $combo;
	}

	public function getProducto()
	{
	    return $this->producto;
	}

	public function setProducto($producto)
	{
	    $this->producto = $producto;
	}
	

	public function getLinkActionAgregarProducto(){
		
		return LinkBuilder::getActionAjaxUrl( "AgregarProductoComboJson") ;
		
	}
	
	public function getLinkActionMostrarProducto(){
		
		return LinkBuilder::getActionAjaxUrl( "MostrarProductoComboJson") ;
		
	}
	
	public function getLinkActionConsultarStockProducto(){
		
		return LinkBuilder::getActionAjaxUrl( "ConsultarStockProductoComboJson") ;
		
	}
	
	public function getLinkActionBorrarProducto(){
		
		return LinkBuilder::getActionAjaxUrl( "BorrarProductoComboJson") ;
		
	}
	
	
	
	
	
}
?>
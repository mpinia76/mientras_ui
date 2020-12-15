<?php

namespace Mientras\UI\components\form\pedido;

use Mientras\UI\components\filter\model\UIProveedorCriteria;

use Mientras\UI\service\finder\ProveedorFinder;

use Mientras\UI\service\finder\ClienteFinder;

use Mientras\UI\service\finder\TipoProductoFinder;

use Mientras\UI\service\finder\MarcaProductoFinder;

use Mientras\UI\service\finder\ProductoFinder;



use Mientras\UI\utils\MientrasUIUtils;

use Mientras\UI\service\UIServiceFactory;

use Rasty\Forms\form\Form;

use Rasty\components\RastyComponent;
use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;


use Mientras\Core\model\Pedido;
use Mientras\Core\model\DetallePedido;

use Rasty\utils\LinkBuilder;
use Rasty\security\RastySecurityContext;

/**
 * Formulario para pedido

 * @author Marcos
 * @since 10/07/2020
 */
class PedidoForm extends Form{
		
	

	/**
	 * label para el cancel
	 * @var string
	 */
	private $labelCancel;
	

	/**
	 * 
	 * @var Pedido
	 */
	private $pedido;
	
	private $detalle;
	
	public function __construct(){

		parent::__construct();
		$this->setLabelCancel("pedido.cancelar");
		$this->setLabelSubmit("pedido.confirmar");
		
		$this->addProperty("fechaHora");
		
		$this->addProperty("proveedor");
		$this->addProperty("observaciones");
		
		$this->setBackToOnSuccess("PedidoPagar");
		$this->setBackToOnCancel("Pedidos");
		
	}
	
	public function getOid(){
		
		return $this->getComponentById("oid")->getPopulatedValue( $this->getMethod() );
	}
	
	
	public function getType(){
		
		return "PedidoForm";
		
	}
	
	public function fillEntity($entity){
		
		//le agregamos los detalles de sesión.
		$detalles = MientrasUIUtils::getDetallesPedidoSession();
		
		
		parent::fillEntity($entity);
		
		
		foreach ($detalles as $detallejson) {
			$detalle = new DetallePedido();
			
			$detalle->setCantidad( $detallejson["cantidad"] );
			$detalle->setPrecioUnitario( $detallejson["precioUnitario"] );
			$detalle->setProducto( UIServiceFactory::getUIProductoService()->get($detallejson["producto_oid"]) );
			
			$entity->addDetalle( $detalle );
			
		}
		
		$user = RastySecurityContext::getUser();
		$user = \Cose\Security\service\ServiceFactory::getUserService()->getUserByUsername($user->getUsername());
		$entity->setUser( $user );
		
		
	}

	protected function parseXTemplate(XTemplate $xtpl){

		parent::parseXTemplate($xtpl);
		
		$xtpl->assign("cancel", $this->getLinkCancel() );
		$xtpl->assign("lbl_cancel", $this->localize( $this->getLabelCancel() ) );
		
		$xtpl->assign("lbl_fechaHora", $this->localize("pedido.fechaHora") );
		
		$xtpl->assign("lbl_proveedor", $this->localize("pedido.proveedor") );
		$xtpl->assign("lbl_cliente", $this->localize("pedido.cliente") );
		$xtpl->assign("lbl_observaciones", $this->localize("pedido.observaciones") );
		
		$xtpl->assign("detalles_legend", $this->localize("pedido.agregar.detalles_legend") );
		$xtpl->assign("lbl_detalle_nombre", $this->localize( "pedido.detalle.producto" ) );
		$xtpl->assign("lbl_detalle_precio", $this->localize( "pedido.detalle.precio" ) );
		$xtpl->assign("lbl_detalle_cantidad", $this->localize( "pedido.detalle.cantidad" ) );
		$xtpl->assign("lbl_detalle_subtotal", $this->localize( "pedido.detalle.subtotal" ) );
		
		
		
		$xtpl->assign("linkAgregarDetalle", $this->getLinkActionAgregarDetalle() );
		$xtpl->assign("linkBorrarDetalle", $this->getLinkActionBorrarDetalle() );
		
		
		//agrego los productos más vendidos como accesos rápidos a agregar
		$xtpl->assign("accesos_rapidos_legend", $this->localize( "pedido.agregar.accesos_rapidos.legend" ) );
		
		$xtpl->assign("lbl_nombre",  $this->localize("producto.nombre") );
		$xtpl->assign("lbl_tipoProducto",  $this->localize("producto.tipoProducto") );
		$xtpl->assign("lbl_marcaProducto",  $this->localize("producto.marcaProducto") );
	
		/*$productos = UIServiceFactory::getUIProductoService()->getMasVendidos();
		foreach ($productos as $producto) {
			$xtpl->assign("oid", $producto->getOid() );
			$xtpl->assign("nombre", $producto );
			//$xtpl->assign("logo", MientrasUIUtils::getImagenProducto($producto));
			$xtpl->parse("main.agregar_producto");
		}*/
		
		
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
	
	public function getPedido()
	{
	    return $this->pedido;
	}

	public function setPedido($pedido)
	{
	    $this->pedido = $pedido;
	}

	public function getDetalle()
	{
	    return $this->detalle;
	}

	public function setDetalle($detalle)
	{
	    $this->detalle = $detalle;
	}
	

	public function getLinkActionAgregarDetalle(){
		
		return LinkBuilder::getActionAjaxUrl( "AgregarDetallePedidoJson") ;
		
	}
	
	public function getLinkActionBorrarDetalle(){
		
		return LinkBuilder::getActionAjaxUrl( "BorrarDetallePedidoJson") ;
		
	}
	
	public function getProveedores(){
		
		$proveedores = UIServiceFactory::getUIProveedorService()->getList( new UIProveedorCriteria() );
		
		return $proveedores;
		
	}
	
	public function getProveedorFinderClazz(){
		
		return get_class( new ProveedorFinder() );
		
	}	
	
	public function getTipoProductoFinderClazz(){
		
		return get_class( new TipoProductoFinder() );
		
	}
	
	public function getMarcaProductoFinderClazz(){
		
		return get_class( new MarcaProductoFinder() );
		
	}
	
}
?>
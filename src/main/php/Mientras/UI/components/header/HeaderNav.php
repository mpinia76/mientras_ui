<?php

namespace Mientras\UI\components\header;

use Mientras\UI\utils\MientrasUIUtils;

use Rasty\components\RastyComponent;
use Rasty\utils\RastyUtils;
use Rasty\utils\XTemplate;

use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;
use Rasty\Menu\menu\model\MenuActionOption;
use Rasty\Menu\menu\model\SubmenuOption;

class HeaderNav extends RastyComponent{

	private $title;
	
	private $pageMenuGroups;

	public function __construct(){
		$this->pageMenuGroups = array();
		//$this->setTitle($this->localize("app.title"));
	}
	
	public function getType(){
		
		return "HeaderNav";
		
	}
	
	protected function parseXTemplate(XTemplate $xtpl){

		
		//$xtpl->assign("cuentas_titulo", $this->localize("app.title"));
		$titles = array();
		$titles[] = $this->localize("app.title");
		$titles[] = $this->getTitle();
		
		$xtpl->assign("cuentas_titulo", implode(" / ", $titles));
		
		$xtpl->assign("menu_page", $this->localize("menu.page"));
		$xtpl->assign("menu_main", $this->localize("menu.main"));
		
	}
	
	public function getMainMenuGroups(){
		
		//TODO construirlo a partir del usuario 
		//y utilizando permisos
		
		//$menuGroup = new MenuGroup();
		$menuGroups=array();
		if( MientrasUIUtils::isAdminLogged()) {

			$menuOption = new MenuOption();
			$menuOption->setLabel( $this->localize( "menu.admin_home") );
			$menuOption->setPageName( "AdminHome" );
			//$menuOption->setImageSource( $this->getWebPath() . "css/images/empleado_home_48.png" );
			$menuOption->setIconClass("icon-admin_home");
			
			//$menuGroup->addMenuOption( $menuOption );
//			$menuGroups[] = $menuOption;
			
		}

		
		
		if( MientrasUIUtils::isAdminLogged() ){
			
			$menu = $this->getMenuSeguridad() ;
			if($menu)
				$menuGroups[] =  $menu;
		}		
			//$menuGroup->addMenuOption( $this->getMenuAdmin() );
			$menuGroups[] =  $this->getMenuAdmin() ;
			
		
			
			//$menuGroup->addMenuOption( $this->getMenuCuentas() );
			$menuGroups[] =  $this->getMenuCuentas() ;
			
			
			//$menuGroup->addMenuOption( $this->getMenuProductos() );
			$menuGroups[] =  $this->getMenuProductos();
			
			//$menuGroup->addMenuOption( $this->getMenuAgencia() );
			$menuGroups[] =  $this->getMenuAgencia() ;
			
			//$menuGroup->addMenuOption( $this->getMenuAgencia() );
			//$menuGroups[] =  $this->getMenuInformes();
			
			$menuGroups[] =  $this->getMenuReportes();
			
		

		
		//return array($menuGroup);
		return $menuGroups;
	}
	
	public function getPageMenuGroups(){
		
		return $this->pageMenuGroups;
	}

	public function setPageMenuGroups($pageMenuGroups)
	{
	    $this->pageMenuGroups = $pageMenuGroups;
	}

	public function getTitle()
	{
	    return $this->title;
	}

	public function setTitle($title)
	{
		if(!empty($title))
	    	$this->title = $title;
	}
	
	public function getMenuSeguridad(){
		
		$menuGroup = new MenuGroup();
		$menuGroup->setLabel( $this->localize( "menu.seguridad") );
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.usuarios") );
		$menuOption->setPageName( "Usuarios" );
		//$menuOption->setImageSource( $this->getWebPath() . "css/images/movimientos_32.png" );
		$menuOption->setIconClass("icon-user");
		//$menuGroup->addMenuOption( $menuOption );
		$menuGroup->addMenuOption($menuOption);
		
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.roles") );
		$menuOption->setIconClass("icon-roles");
		$menuOption->setPageName( "Roles");
		//$menuGroup->addMenuOption( $menuOption );
		$menuGroup->addMenuOption($menuOption);
			
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.permisos") );
		$menuOption->setPageName( "Permisos" );
		$menuOption->setIconClass("icon-permisos");
		//$menuGroup->addMenuOption( $menuOption );
		$menuGroup->addMenuOption($menuOption);
		
		

			$submenu = new SubmenuOption($menuGroup);
			$submenu->setIconClass("icon-seguridad");
			return $submenu;
			
		
		
		
	}
	
	public function getMenuPedidos(){

		$menuGroup = new MenuGroup();
		$menuGroup->setLabel( $this->localize( "menu.pedidos") );
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.pedidos.listar") );
		$menuOption->setPageName( "Pedidos" );
		//$menuOption->setImageSource( $this->getWebPath() . "css/images/pedidos_32.png" );
		$menuOption->setIconClass("icon-pedidos");
		$menuGroup->addMenuOption( $menuOption );
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.pedidos.agregar") );
		$menuOption->setPageName( "PedidoAgregar" );
		//$menuOption->setImageSource( $this->getWebPath() . "css/images/add_over_48.png" );
		$menuOption->setIconClass("icon-nuevo-pedido");
		$menuGroup->addMenuOption( $menuOption );
		
		$submenu = new SubmenuOption($menuGroup);
		//$submenu->setImageSource( $this->getWebPath() . "css/images/pedidos_32.png" );
		$submenu->setIconClass("icon-pedidos");
				
		return $submenu;
	}
	
	public function getMenuProveedores(){

		$menuGroup = new MenuGroup();
		$menuGroup->setLabel( $this->localize( "menu.proveedores") );
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.proveedores.listar") );
		$menuOption->setPageName( "Proveedores" );
		//$menuOption->setImageSource( $this->getWebPath() . "css/images/proveedores_32.png" );
		$menuOption->setIconClass("icon-proveedores");
		$menuGroup->addMenuOption( $menuOption );
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.proveedores.agregar") );
		$menuOption->setPageName( "ProveedorAgregar" );
		//$menuOption->setImageSource( $this->getWebPath() . "css/images/add_over_48.png" );
		$menuOption->setIconClass("icon-agregar");
		$menuGroup->addMenuOption( $menuOption );
		
		$submenu = new SubmenuOption($menuGroup);
		//$submenu->setImageSource( $this->getWebPath() . "css/images/proveedores_32.png" );
		$submenu->setIconClass("icon-proveedores");
		
		return $submenu;
	}
	
	

	public function getMenuClientes(){

		$menuGroup = new MenuGroup();
		$menuGroup->setLabel( $this->localize( "menu.clientes") );
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.clientes.listar") );
		$menuOption->setPageName( "Clientes" );
		$menuOption->setIconClass("icon-clientes");
		$menuGroup->addMenuOption( $menuOption );
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.clientes.agregar") );
		$menuOption->setPageName( "ClienteAgregar" );
		$menuOption->setIconClass("icon-agregar");
		$menuGroup->addMenuOption( $menuOption );

		
		$submenu = new SubmenuOption($menuGroup);
		$submenu->setIconClass("icon-clientes");
		return $submenu;
	}

	public function getMenuProductos(){

		$menuGroupProductos = new MenuGroup();
		$menuGroupProductos->setLabel( $this->localize( "menu.productos") );
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "producto.listar") );
		$menuOption->setPageName( "Productos" );
		//$menuOption->setImageSource( $this->getWebPath() . "css/images/producto_48.png" );
		$menuOption->setIconClass("icon-productos");
		$menuGroupProductos->addMenuOption( $menuOption );
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "producto.agregar") );
		$menuOption->setPageName( "ProductoAgregar" );
		//$menuOption->setImageSource( $this->getWebPath() . "css/images/add_over_48.png" );
		$menuOption->setIconClass("icon-agregar");
		$menuGroupProductos->addMenuOption( $menuOption );
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "combo.listar") );
		$menuOption->setPageName( "Combos" );
		//$menuOption->setImageSource( $this->getWebPath() . "css/images/producto_48.png" );
		$menuOption->setIconClass("icon-productos");
		$menuGroupProductos->addMenuOption( $menuOption );
		

		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.pedidos.listar") );
		$menuOption->setPageName( "Pedidos" );
		//$menuOption->setImageSource( $this->getWebPath() . "css/images/pedidos_32.png" );
		$menuOption->setIconClass("icon-pedidos");
		$menuGroupProductos->addMenuOption( $menuOption );
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.pedidos.agregar") );
		$menuOption->setPageName( "PedidoAgregar" );
		//$menuOption->setImageSource( $this->getWebPath() . "css/images/add_over_48.png" );
		$menuOption->setIconClass("icon-nuevo-pedido");
		$menuGroupProductos->addMenuOption( $menuOption );
		
				
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.proveedors.listar") );
		$menuOption->setPageName( "Proveedors" );
		//$menuOption->setImageSource( $this->getWebPath() . "css/images/proveedores_32.png" );
		$menuOption->setIconClass("icon-proveedores");
		$menuGroupProductos->addMenuOption( $menuOption );
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.proveedors.agregar") );
		$menuOption->setPageName( "ProveedorAgregar" );
		//$menuOption->setImageSource( $this->getWebPath() . "css/images/add_over_48.png" );
		$menuOption->setIconClass("icon-agregar");
		$menuGroupProductos->addMenuOption( $menuOption );
		
//		$menuGroupProductos->addMenuOption( $this->getMenuPedidos() );
//		$menuGroupProductos->addMenuOption( $this->getMenuProveedores() );
		
		$submenuProductos = new SubmenuOption($menuGroupProductos);
		//$submenuProductos->setImageSource( $this->getWebPath() . "css/images/producto_48.png" );
		$submenuProductos->setIconClass("icon-productos");
		
		
			
		return $submenuProductos;
		
	}

	public function getMenuAdmin(){
		
		$menuGroup = new MenuGroup();
		$menuGroup->setLabel( $this->localize( "menu.admin") );
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.conceptoGastos") );
		$menuOption->setPageName( "ConceptoGastos" );
		
		
		$menuGroup->addMenuOption( $menuOption );
		
		/*$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.conceptoMovimientos") );
		$menuOption->setPageName( "ConceptoMovimientos" );
		
		
		$menuGroup->addMenuOption( $menuOption );
		
		
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.ivas") );
		$menuOption->setPageName( "Ivas" );
		
		
		$menuGroup->addMenuOption( $menuOption );*/
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.marcas_productos") );
		$menuOption->setPageName( "MarcasProducto" );
		
		$menuGroup->addMenuOption( $menuOption );
		
		/*$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.parametros") );
		$menuOption->setPageName( "Parametros" );
		
		
		
		$menuGroup->addMenuOption( $menuOption );*/
		
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.tipos_productos") );
		$menuOption->setPageName( "TiposProducto" );
		
		
		$menuGroup->addMenuOption( $menuOption );
		
		$submenu = new SubmenuOption($menuGroup);
		
		return $submenu;
	}
	
	public function getMenuCuentas(){
		
		$menuGroup = new MenuGroup();
		$menuGroup->setLabel( $this->localize( "menu.cuentas") );
		
		/*$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.movimientos_banco") );
		$menuOption->setPageName( "MovimientosBanco" );
		//$menuOption->setImageSource( $this->getWebPath() . "css/images/movimientos_32.png" );
		$menuOption->setIconClass("icon-movimientos");
		$menuGroup->addMenuOption( $menuOption );*/
		
			
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.movimientos_caja") );
		$menuOption->setIconClass("icon-movimientos");
		$menuOption->setPageName( "AdminMovimientos");
		$menuGroup->addMenuOption( $menuOption );
			
		/*$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.movimientos_cuentaSocio") );
		$menuOption->setPageName( "MovimientosCuentaSocio" );
		$menuOption->setIconClass("icon-movimientos");
		$menuGroup->addMenuOption( $menuOption );

		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "banco.depositar") );
		$menuOption->setPageName( "DepositarEfectivo" );
		$menuOption->setIconClass("icon-depositar-efectivo");
		//$menuOption->setImageSource( $this->getWebPath() . "css/images/depositar_32.png" );
		$menuGroup->addMenuOption( $menuOption );
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.transferir") );
		$menuOption->setIconClass("icon-movimientos");
		$menuOption->setPageName( "Transferir");
		$menuGroup->addMenuOption( $menuOption );*/
		

		//$menuGroup->addMenuOption( $this->getMenuGastos() );
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.gastos.listar") );
		$menuOption->setPageName( "Gastos" );
		$menuOption->setIconClass("icon-gastos");
		$menuGroup->addMenuOption( $menuOption );
		
		//$menuGroup->addMenuOption( $this->getMenuVentas() );
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.ventas.listar") );
		$menuOption->setPageName( "Ventas" );
		$menuOption->setIconClass("icon-ventas");
		$menuGroup->addMenuOption( $menuOption );
		
		//$menuGroup->addMenuOption( $this->getMenuPremios() );
		/*$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.pagoPremios") );
		//$menuOption->setImageSource( $this->getWebPath() . "css/images/premio_48.png" );
		$menuOption->setIconClass("icon-pagoPremios");
		$menuOption->setPageName( "PagoPremios");
		$menuGroup->addMenuOption( $menuOption );*/
		
		$submenu = new SubmenuOption($menuGroup);
		$submenu->setIconClass("icon-empleados");
		return $submenu;
	}

	public function getMenuTareas(){

		$menuGroup = new MenuGroup();
		$menuGroup->setLabel( $this->localize( "menu.tareas") );
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.tareas.listar") );
		$menuOption->setPageName( "Tareas" );
		$menuOption->setIconClass("icon-tareas");
		$menuGroup->addMenuOption( $menuOption );
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.tareas.agregar") );
		$menuOption->setPageName( "TareaAgregar" );
		$menuOption->setIconClass("icon-agregar");
		$menuGroup->addMenuOption( $menuOption );
		
		$submenu = new SubmenuOption($menuGroup);
		$submenu->setIconClass("icon-tareas");
		return $submenu;
	}
	
	public function getMenuPremios(){

		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.pagoPremios") );
		//$menuOption->setImageSource( $this->getWebPath() . "css/images/premio_48.png" );
		$menuOption->setIconClass("icon-pagoPremios");
		$menuOption->setPageName( "PagoPremios");
		
		
		return $menuOption;
	}
	
	public function getMenuAgencia(){
		
		$menuGroup = new MenuGroup();
		$menuGroup->setLabel( $this->localize( "menu.agencia") );
		
		//$menuGroup->addMenuOption( $this->getMenuClientes() );
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.clientes.listar") );
		$menuOption->setPageName( "Clientes" );
		$menuOption->setIconClass("icon-clientes");
		$menuGroup->addMenuOption( $menuOption );
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.clientes.agregar") );
		$menuOption->setPageName( "ClienteAgregar" );
		$menuOption->setIconClass("icon-agregar");
		$menuGroup->addMenuOption( $menuOption );
		
				
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.cobrarCuentaCorriente") );
		$menuOption->setPageName("CobrarCtaCte");
		
		$menuGroup->addMenuOption( $menuOption );
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.actualizarCuentaCorriente") );
		$menuOption->setPageName("ActualizarCtaCte");
		
		$menuGroup->addMenuOption( $menuOption );
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.clientesCtaCte.listar") );
		$menuOption->setPageName( "ClientesCtaCte" );
		
		$menuOption->setIconClass("icon-clientes");
		$menuGroup->addMenuOption( $menuOption );
		
		//$menuGroup->addMenuOption( $this->getMenuEmpleados() );
		
		
		
		/*$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.presupuestos.listar") );
		$menuOption->setPageName( "Presupuestos" );
		$menuOption->setIconClass("icon-ventas");
		$menuGroup->addMenuOption( $menuOption );*/
		
		
		$submenu = new SubmenuOption($menuGroup);
		
		return $submenu;
	}

	public function getMenuInformes(){

		$menuGroupInformes = new MenuGroup();
		$menuGroupInformes->setLabel( $this->localize( "menu.informes") );
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.informesSemanales.listar") );
		$menuOption->setPageName( "InformesSemanales" );
		$menuOption->setIconClass("icon-informes-semanales");
		$menuGroupInformes->addMenuOption( $menuOption );
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.informesSemanales.agregar") );
		$menuOption->setPageName( "InformeSemanalAgregar" );
		$menuOption->setIconClass("icon-agregar");
		$menuGroupInformes->addMenuOption( $menuOption );
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.informesDiariosDebitoCredito.listar") );
		$menuOption->setPageName( "InformesDiariosDebitoCredito" );
		$menuOption->setIconClass("icon-informes-debito-credito");
		$menuGroupInformes->addMenuOption( $menuOption );
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.informesDiariosDebitoCredito.agregar") );
		$menuOption->setPageName( "InformeDiarioDebitoCreditoAgregar" );
		$menuOption->setIconClass("icon-agregar");
		$menuGroupInformes->addMenuOption( $menuOption );
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.informesDiariosComision.listar") );
		$menuOption->setPageName( "InformesDiariosComision" );
		$menuOption->setIconClass("icon-informes-comision");
		$menuGroupInformes->addMenuOption( $menuOption );
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.informesDiariosComision.agregar") );
		$menuOption->setPageName( "InformeDiarioComisionAgregar" );
		$menuOption->setIconClass("icon-agregar");
		$menuGroupInformes->addMenuOption( $menuOption );
		
		$submenuInformes = new SubmenuOption($menuGroupInformes);
		$submenuInformes->setIconClass("icon-informes");
		
		return $submenuInformes;
		
	}
	
	public function getMenuReportes(){

		$menuGroupStats = new MenuGroup();
		$menuGroupStats->setLabel( $this->localize( "menu.stats") );
		
		/*$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.stats.reportes") );
		$menuOption->setPageName( "Reportes" );
		$menuOption->setIconClass( "icon-stats" );
		$menuGroupStats->addMenuOption( $menuOption );*/
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.balances.dia") );
		$menuOption->setPageName( "BalanceDia" );
		$menuOption->setIconClass( "icon-stats" );
		$menuGroupStats->addMenuOption( $menuOption );
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.balances.mes") );
		$menuOption->setPageName( "BalanceMes" );
		$menuOption->setIconClass( "icon-stats" );
		$menuGroupStats->addMenuOption( $menuOption );
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.balances.anio") );
		$menuOption->setPageName( "BalanceAnio" );
		$menuOption->setIconClass( "icon-stats" );
		$menuGroupStats->addMenuOption( $menuOption );
		
		$submenu = new SubmenuOption($menuGroupStats);
		$submenu->setIconClass("icon-stats");
		
		return $submenu;
	
	}
}
?>
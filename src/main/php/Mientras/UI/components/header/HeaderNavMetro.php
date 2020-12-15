<?php

namespace Mientras\UI\components\header;

use Mientras\UI\utils\MientrasUIUtils;

use Rasty\security\RastySecurityContext;
use Rasty\components\RastyComponent;
use Rasty\utils\RastyUtils;
use Rasty\utils\XTemplate;
use Rasty\utils\LinkBuilder;

use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;
use Rasty\Menu\menu\model\SubmenuOption;
use Rasty\Menu\menu\model\MenuActionOption;

class HeaderNavMetro extends HeaderNav{


	public function __construct(){
		parent::__construct();
	}
	
	public function getType(){
		
		return "HeaderNavMetro";
		
	}
	
	protected function parseXTemplate(XTemplate $xtpl){

		
		//$xtpl->assign("turnos_titulo", $this->localize("app.title"));
		$titles = array();
		$titles[] = $this->localize("app.title");
		$titles[] = $this->getTitle();
		
		//$xtpl->assign("mjpanel_titulo", implode(" / ", $titles));
		
		$xtpl->assign("menu_page", $this->localize("menu.page"));
		$xtpl->assign("menu_main", $this->localize("menu.main"));
		
		$xtpl->assign("reloadLabel", $this->localize("menu.main.reload"));
		
		//if( MientrasUIUtils::isAdminLogged()) {
			$xtpl->assign("homeLabel", $this->localize("menu.main.panel"));
			$xtpl->assign("linkHome", LinkBuilder::getPageUrl( "AdminHome") );
			$xtpl->parse("main.menu_home");				
		/*}else{
			$xtpl->assign("homeLabel", $this->localize("menu.main.panel"));
			$xtpl->assign("linkHome", LinkBuilder::getPageUrl( "CajaHome") );
			$xtpl->parse("main.menu_home");	
		}*/
		
		$user = RastySecurityContext::getUser();
		$xtpl->assign("user", $user->getName() );

		
		
		$this->parseMenuExit( $xtpl );
		$this->parseMenuProfile( $xtpl, $user );
		
		//parseamos las opciones del menú principal.
		$this->parseMenuMain( $xtpl );
		
		//parseamos las opciones del menú de la página.
		$this->parseMenuPage( $xtpl );
		
		
	}
	
	
	public function parseMenu(XTemplate $xtpl, $title, $menuGroups, $blockName){

		foreach ($menuGroups as $menuGroup) {
			
			$size = count( $menuGroup->getMenuOptions() );
			if($size>0){

				$xtpl->assign("menuGroupCss", "has-sub");
				foreach ($menuGroup->getMenuOptions() as $menuOption) {

					$xtpl->assign("liCss", "has-sub" );
					$xtpl->assign("label", $menuOption->getLabel() );
					$xtpl->assign("onclick", $menuOption->getOnclick());
					$img = $menuOption->getImageSource();
					if(!empty($img)){
						$xtpl->assign("src", $img );
						$xtpl->parse("main.$blockName.menuGroup.options.menuOption.image");
					}else{
						$icon =  $menuOption->getIconClass();
						if(!empty($icon)){
							$xtpl->assign("iconClass", $icon);
							$xtpl->parse("main.$blockName.menuGroup.options.menuOption.icon");
						}
					}
					
					$xtpl->parse( "main.$blockName.menuGroup.options.menuOption");
					
				}
				
				$xtpl->parse( "main.$blockName.menuGroup.options");
				
			}else{
				$xtpl->assign("menuGroupCss", "");
				$xtpl->assign("onclick", "");				
			}
			
			
			$xtpl->assign("groupLabel", $menuGroup->getLabel());
			$xtpl->parse("main.$blockName.menuGroup");
		}
		
		//$xtpl->assign("menuLabel", $title );
		//$xtpl->assign("onclick", $this->getOnclick() );
		//$xtpl->assign("id", $this->getId() );
		
		//$xtpl->parse("main.$blockName.menuTitle" );
			
		$xtpl->parse("main.$blockName" );
	}
	
	public function parseMenuPage(XTemplate $xtpl){
		
		if(count($this->getPageMenuGroups())>0)
			$this->parseMenu($xtpl, $this->localize("menu.page"), $this->getPageMenuGroups(), "menu_page");	
	}

	public function parseMenuMain(XTemplate $xtpl){
		$groups = $this->getMainMenuGroups();
		//$group = $groups[0];
		$this->parseMenu($xtpl, $this->localize("menu.main"), $groups, "menu_main");
		//$xtpl->parse("main.menu_main" );	
	}
	
	
	public function parseMenuExit( XTemplate $xtpl){
		
//		$menuOption = new MenuActionOption();
//		$menuOption->setLabel( $this->localize( "menu.logout") );
//		$menuOption->setActionName( "Logout");
//		$menuOption->setImageSource( $this->getWebPath() . "css/images/logout.png" );
//
//		$this->parseMenuOption($xtpl, $menuOption, "main.menuOptionExit");
		
		
		$menuOption = new MenuActionOption();
		$menuOption->setLabel( $this->localize( "menu.logout") );
		$menuOption->setActionName( "Logout");
		//$menuOption->setImageSource( $this->getWebPath() . "css/images/logout.png" );
		$menuOption->setIconClass("icon-exit");

		$this->parseMenuOption($xtpl, $menuOption, "main.menuGroup");
		
	}


	public function parseMenuProfile( XTemplate $xtpl, $user){
		
//		$menuOption = new MenuOption();
//		$menuOption->setLabel( $this->localize( "menu.profile") );
//		$menuOption->setIconClass( "icon-cog" );
//		$menuOption->setPageName( "UserProfile");
//		$menuOption->addParam("oid",$user->getOid());
//		$menuOption->setImageSource( $this->getWebPath() . "css/images/profile.png" );
//		$this->parseMenuOption($xtpl, $menuOption, "main.menuOptionProfile");
		
		
		
	}
	
	public function parseMenuOption( XTemplate $xtpl, MenuOption $menuOption, $blockName){
//		$xtpl->assign("label", $menuOption->getLabel() );
//		$xtpl->assign("onclick", $menuOption->getOnclick());
//		$xtpl->assign("iconClass", $menuOption->getIconClass());
//		$xtpl->parse("$blockName");
//		
 		$xtpl->assign("liCss", $menuOption->getCss() );
		$xtpl->assign("label", $menuOption->getLabel() );
		$xtpl->assign("onclick", $menuOption->getOnclick());
		$img = $menuOption->getImageSource();
		if(!empty($img)){
			$xtpl->assign("src", $img );
			$xtpl->parse("$blockName.image");
		}else{
			$icon =  $menuOption->getIconClass();
			if(!empty($icon)){
				$xtpl->assign("iconClass", $icon);
				$xtpl->parse("$blockName.icon");
			}
						
		}
		
		
		$xtpl->parse("$blockName");
		
	}
	
	public function parseSubmenuOption( XTemplate $xtpl, SubmenuOption $submenuOption, $blockName){

		
		foreach ($submenuOption->getMenuOptions() as $menuOption) {

				$this->parseMenuOption($xtpl, $menuOption, "$blockName.link");
				
		}
		
		$xtpl->assign("liCss", $menuOption->getCss() );
		$xtpl->assign("submenuLabel", $submenuOption->getLabel() );
		$xtpl->assign("onclick", "");
		$img = $submenuOption->getImageSource();
		if(!empty($img)){
			$xtpl->assign("src", $img );
			$xtpl->parse("$blockName.image");
		}else{
			$icon =  $submenuOption->getIconClass();
			if(!empty($icon)){
				$xtpl->assign("iconClass", $icon);
				$xtpl->parse("$blockName.icon");
			}
						
		}
		
		$xtpl->parse("$blockName");
		
	}	
	
	public function parseMenuOptions(XTemplate $xtpl, $title, $menuGroup, $blockName){

			
			$size = count( $menuGroup->getMenuOptions() );
			if($size>0){

				$xtpl->assign("menuGroupCss", "has-sub");
				foreach ($menuGroup->getMenuOptions() as $menuOption) {

				
					$xtpl->assign("liCss", "has-sub" );
					$xtpl->assign("label", $menuOption->getLabel() );
					$xtpl->assign("onclick", $menuOption->getOnclick());
					$img = $menuOption->getImageSource();
					if(!empty($img)){
						$xtpl->assign("src", $img );
						$xtpl->parse("$blockName.image");
					}else{
						$icon =  $menuOption->getIconClass();
						if(!empty($icon)){
							$xtpl->assign("iconClass", $icon);
							$xtpl->parse("$blockName.icon");
						}
					}
					
					$xtpl->parse( "main.$blockName.menuGroup.options.menuOption");
					
				}
				
				$xtpl->parse( "main.$blockName.menuGroup.options");
				
			}else{
				$xtpl->assign("menuGroupCss", "");
			}
			
			$xtpl->assign("onclick", "");
			$xtpl->parse("main.$blockName.menuGroup");
		
		
	}
	
}
?>
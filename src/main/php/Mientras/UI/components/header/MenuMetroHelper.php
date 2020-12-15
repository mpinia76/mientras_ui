<?php

namespace Cuentas\UI\components\header;

class MenuMetroHelper{


	public static function menuHTML($title, $menuGroups){

		$menuHTML = "<a class=\"element1 pull-menu\" href=\"#\"></a>
        <ul class=\"element-menu\">";
		
		foreach ($menuGroups as $menuGroup) {
			
			
			foreach ($menuGroup->getMenuOptions() as $menuOption) {

				if( $menuOption->hasSubmenu() ){
					
					$menuHTML .= self::menuSubmenu($menuOption);
					
				}else{

					$menuHTML .= self::menuLink($menuOption);
				}
				
			}
		}
		
		$menuHTML .= "</ul>";
		
		return $menuHTML;
	}

	public static function menuSubmenu($menuSubmenu){
		
		$label = $menuSubmenu->getLabel();
		$imgSrc = $menuSubmenu->getImageSource();
		$iconClass =  $menuSubmenu->getIconClass();
		
		$link = "<a href=\"#\" class=\"dropdown-toggle\">";
		if( !empty($iconClass) ){
			$icon = "<span class=\"$iconClass\"></span>";
			$link .= $icon;
		}	
		
		if(!empty($imgSrc)){
			$image  = "<img style=\"border:0;margin-right:10px;width:24px;height: 24px;\" src=\"$imgSrc\"/>";
			$link .= $image;
		}
		$link .= " $label </a>";
		
		$menuHTML = "<li>
                        $link
                        <ul class=\"dropdown-menu dark\" data-role=\"dropdown\">";
		
		foreach ($menuSubmenu->getMenuOptions() as $menuOption) {

				if( $menuOption->hasSubmenu() ){
					
					$menuHTML .= self::menuSubmenu($menuOption);
					
				}else{

					$menuHTML .= self::menuLink($menuOption);
				}
				
			}
		$menuHTML .= "</ul></li>";	
		return $menuHTML;
	}
	
	public static function menuLink($menuOption){
		
		$imgSrc = $menuOption->getImageSource();
		$iconClass =  $menuOption->getIconClass();
		$onclick = $menuOption->getOnclick();
					
		$link = "<li><a href=\"#\" onclick=\"$onclick\" >";
		if( !empty($iconClass) ){
			$icon = "<span class=\"$iconClass\"></span>";
			$link .= $icon;
		}	
		
		if(!empty($imgSrc)){
			$image  = "<img style=\"border:0;margin-right:10px;width:24px;height: 24px;\" src=\"$imgSrc\"/>";
			$link .= $image;
		}
		
		$label = $menuOption->getLabel() ;
		
		$link .= " $label</a></li>";
					
		return $link;
	}
}
?>
<?php

namespace Mientras\UI\layouts;

use Rasty\Layout\layout\RastyLayout;

use Rasty\utils\XTemplate;
use Rasty\conf\RastyConfig;

class MientrasHomeMetroLayout extends MientrasMetroLayout{

	
	public function getContent(){
		
		
		//contenido del componente..
				
		$xtpl = $this->getXTemplate( dirname(__DIR__) . "/layouts/MientrasHomeMetroLayout.htm" );
		$xtpl->assign('WEB_PATH', RastyConfig::getInstance()->getWebPath() );
		
		$this->parseMetaTags($xtpl);
        $this->parseStyles($xtpl);
        $this->parseScripts($xtpl);
        $this->parseLinks($xtpl);
        
        $this->parseErrors($xtpl);
        
		
		$xtpl->assign('title', $this->oPage->getTitle());
		
		$xtpl->assign('page',   $this->oPage->render() );

		//chequeamos si hay que mostrar errores.
		
		
		$xtpl->parse("main");
		$content = $xtpl->text("main");
		
		return $content;
	}
	
	
	public function getType(){
		
		return "MientrasHomeMetroLayout";
		
	}	

	
}
?>
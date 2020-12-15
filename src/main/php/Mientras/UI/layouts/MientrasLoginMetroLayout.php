<?php

namespace Mientras\UI\layouts;

use Rasty\Layout\layout\Rasty\Layout;

use Rasty\utils\XTemplate;


class MientrasLoginMetroLayout extends MientrasMetroLayout{

	public function getXTemplate($file_template=null){
		return parent::getXTemplate( dirname(__DIR__) . "/layouts/MientrasLoginMetroLayout.htm" );
	}

	public function getType(){
		
		return "MientrasLoginMetroLayout";
		
	}	

}
?>
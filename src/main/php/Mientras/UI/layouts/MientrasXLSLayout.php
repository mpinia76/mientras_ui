<?php

namespace Mientras\UI\layouts;

use Rasty\Layout\layout\RastyLayout;

use Rasty\utils\XTemplate;
use Rasty\conf\RastyConfig;

class MientrasXLSLayout extends RastyLayout{

	//nombre del archivo xls.
	private $fileName;

	public function getContent(){

		//se modifica el header para indicar la salida a un archivo xls.
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-Type: application/vnd.ms-excel; charset=UTF-8");


		header("Content-Disposition: attachment; filename=". $this->getPage()->getTitle().".xls");
		$header = $this->getComponentById("header");

		if(!empty($header))
			$header->setTitle( $this->getPage()->getTitle() );

		//contenido del componente..

		$xtpl = $this->getXTemplate( dirname(__DIR__) . "/layouts/MientrasXLSLayout.htm" );
		$xtpl->assign('WEB_PATH', RastyConfig::getInstance()->getWebPath() );

		$this->parseMetaTags($xtpl);



		$xtpl->assign('title', $this->oPage->getTitle());

		$xtpl->assign('page',   $this->oPage->render() );

		//chequeamos si hay que mostrar errores.


		$xtpl->parse("main");
		$content = $xtpl->text("main");

		/*
		echo "<pre>";
		var_dump($xtpl);
		echo "</pre>";
		*/

		return $content;
	}


	public function getType(){

		return "MientrasXLSLayout";

	}






	protected function parseMetaTags($xtpl) {

		$xtpl->assign('http_equiv', 'Content-Type');
        $xtpl->assign('meta_content', 'text/html; charset=utf-8');
        $xtpl->parse('main.meta_tag');

        /*$xtpl->assign('http_equiv', 'Content-Type');
        $xtpl->parse('main.meta_tag');

        $xtpl->assign('name', 'viewport');
        $xtpl->assign('meta_content', 'width=device-width, initial-scale=1.0');
        $xtpl->assign('http_equiv', '');
        $xtpl->parse('main.meta_tag');*/

    }



	public function getFileName()
	{
	    return $this->fileName;
	}

	public function setFileName($fileName)
	{
	    $this->fileName = $fileName;
	}
}
?>

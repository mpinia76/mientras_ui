<?php

namespace Mientras\UI\components\form\parametro;

use Mientras\UI\components\filter\model\UIParametroCriteria;

use Mientras\UI\service\finder\ParametroFinder;



use Mientras\UI\utils\MientrasUIUtils;

use Mientras\UI\service\UIServiceFactory;


use Rasty\Forms\form\Form;

use Rasty\components\RastyComponent;
use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;



use Rasty\utils\LinkBuilder;

/**
 * Formulario para parametro

 * @author Marcos
 * @since 16/07/2018
 */
class ParametroForm extends Form{
		
	

	/**
	 * label para el cancel
	 * @var string
	 */
	private $labelCancel;
	

	/**
	 * 
	 * @var Parametro
	 */
	private $parametro;
	
	
	public function __construct(){

		parent::__construct();
		$this->setLabelCancel("form.cancelar");
		
		$this->addProperty("nombre");
		$this->addProperty("valor");
		
		$this->setBackToOnSuccess("Parametros");
		$this->setBackToOnCancel("Parametros");
		
		
	}
	
	public function getOid(){
		
		return $this->getComponentById("oid")->getPopulatedValue( $this->getMethod() );
	}
	
	
	public function getType(){
		
		return "ParametroForm";
		
	}
	
	public function fillEntity($entity){
		
		parent::fillEntity($entity);
		
		
		
		
	}

	protected function parseXTemplate(XTemplate $xtpl){

		parent::parseXTemplate($xtpl);
		
		
		$xtpl->assign("cancel", $this->getLinkCancel() );
		$xtpl->assign("lbl_cancel", $this->localize( $this->getLabelCancel() ) );
		
		$xtpl->assign("lbl_nombre", $this->localize("parametro.nombre") );
		$xtpl->assign("lbl_valor", $this->localize("parametro.valor") );
		
	}


	public function getLabelCancel()
	{
	    return $this->labelCancel;
	}

	public function setLabelCancel($labelCancel)
	{
	    $this->labelCancel = $labelCancel;
	}


	
	public function getParametro()
	{
	    return $this->parametro;
	}

	public function setParametro($parametro)
	{
	    $this->parametro = $parametro;
	    
	}
	
	public function getLinkCancel(){
		$params = array();
		
		return LinkBuilder::getPageUrl( $this->getBackToOnCancel() , $params) ;
	}

	
	
	
}
?>
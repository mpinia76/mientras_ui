<?php

namespace Mientras\UI\components\form\tipoProducto;

use Mientras\UI\components\filter\model\UITipoProductoCriteria;

use Mientras\UI\service\finder\TipoProductoFinder;



use Mientras\UI\utils\MientrasUIUtils;

use Mientras\UI\service\UIServiceFactory;


use Rasty\Forms\form\Form;

use Rasty\components\RastyComponent;
use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;



use Rasty\utils\LinkBuilder;

/**
 * Formulario para tipoProducto

 * @author Marcos
 * @since 05/03/2018
 */
class TipoProductoForm extends Form{
		
	

	/**
	 * label para el cancel
	 * @var string
	 */
	private $labelCancel;
	

	/**
	 * 
	 * @var TipoProducto
	 */
	private $tipoProducto;
	
	
	public function __construct(){

		parent::__construct();
		$this->setLabelCancel("form.cancelar");
		
		$this->addProperty("nombre");
		
		
		$this->setBackToOnSuccess("TiposProducto");
		$this->setBackToOnCancel("TiposProducto");
		
		
	}
	
	public function getOid(){
		
		return $this->getComponentById("oid")->getPopulatedValue( $this->getMethod() );
	}
	
	
	public function getType(){
		
		return "TipoProductoForm";
		
	}
	
	public function fillEntity($entity){
		
		parent::fillEntity($entity);
		
		
		
		
	}

	protected function parseXTemplate(XTemplate $xtpl){

		parent::parseXTemplate($xtpl);
		
		
		$xtpl->assign("cancel", $this->getLinkCancel() );
		$xtpl->assign("lbl_cancel", $this->localize( $this->getLabelCancel() ) );
		
		$xtpl->assign("lbl_nombre", $this->localize("tipoProducto.nombre") );
		
		
	}


	public function getLabelCancel()
	{
	    return $this->labelCancel;
	}

	public function setLabelCancel($labelCancel)
	{
	    $this->labelCancel = $labelCancel;
	}


	
	public function getTipoProducto()
	{
	    return $this->tipoProducto;
	}

	public function setTipoProducto($tipoProducto)
	{
	    $this->tipoProducto = $tipoProducto;
	    
	}
	
	public function getLinkCancel(){
		$params = array();
		
		return LinkBuilder::getPageUrl( $this->getBackToOnCancel() , $params) ;
	}

	
	
	
}
?>
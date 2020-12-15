<?php

namespace Mientras\UI\components\form\cliente;

use Mientras\UI\components\filter\model\UIClienteCriteria;

use Mientras\UI\service\finder\ClienteFinder;



use Mientras\UI\utils\MientrasUIUtils;

use Mientras\UI\service\UIServiceFactory;


use Rasty\Forms\form\Form;

use Rasty\components\RastyComponent;
use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;


use Mientras\Core\model\Cliente;
use Mientras\Core\model\Sexo;

use Mientras\Core\model\TipoDocumento;

use Rasty\utils\LinkBuilder;

/**
 * Formulario para cliente

 * @author Marcos
 * @since 02/03/2018
 */
class ClienteForm extends Form{
		
	

	/**
	 * label para el cancel
	 * @var string
	 */
	private $labelCancel;
	

	/**
	 * 
	 * @var Cliente
	 */
	private $cliente;
	
	
	public function __construct($backToOnSuccess="Clientes"){
		
		parent::__construct();
		$this->setLabelCancel("form.cancelar");
		
		$this->addProperty("nombre");
		
		$this->addProperty("tipoDocumento");
		$this->addProperty("documento");
		$this->addProperty("cuit");
		$this->addProperty("nacimiento");
		$this->addProperty("sexo");
		$this->addProperty("telefono");
		$this->addProperty("celular");
		$this->addProperty("mail");
		$this->addProperty("direccion");
		$this->addProperty("observaciones");
		$this->addProperty("laboral");
		
		
		$url = parse_url($_SERVER['REQUEST_URI']);
		if (isset($url['query'])) {
			$arrayParametros = explode("&",$url['query']);
			foreach ($arrayParametros as $parametro) {
				$arrayParametro = explode("=",$parametro);
				if ($arrayParametro[0]=="onSuccessCallback") {
					$backToOnSuccess = $arrayParametro[1];
				}
			}
		}
		
		
		$this->setBackToOnSuccess($backToOnSuccess);
		$this->setBackToOnCancel($backToOnSuccess);
		
	}
	
	public function getOid(){
		
		return $this->getComponentById("oid")->getPopulatedValue( $this->getMethod() );
	}
	
	
	public function getType(){
		
		return "ClienteForm";
		
	}
	
	public function fillEntity($entity){
		
		parent::fillEntity($entity);
		
		//uppercase para el nombre
		//$entity->setNombre( strtoupper( $entity->getNombre() ) );
		$entity->setFecha(new \Datetime() );
		$entity->setUltModificacion(new \Datetime() );
		
		
	}

	protected function parseXTemplate(XTemplate $xtpl){

		parent::parseXTemplate($xtpl);
		
		
		$xtpl->assign("cancel", $this->getLinkCancel() );
		$xtpl->assign("lbl_cancel", $this->localize( $this->getLabelCancel() ) );
		
		$xtpl->assign("lbl_nombre", $this->localize("cliente.nombre") );
		$xtpl->assign("lbl_tipoDocumento", $this->localize("cliente.tipoDocumento") );
		$xtpl->assign("lbl_documento", $this->localize("cliente.documento") );
		$xtpl->assign("lbl_sexo", $this->localize("cliente.sexo") );
		$xtpl->assign("lbl_nacimiento", $this->localize("cliente.nacimiento") );
		$xtpl->assign("lbl_telefono", $this->localize("cliente.telefono") );
		$xtpl->assign("lbl_celular", $this->localize("cliente.celular") );
		$xtpl->assign("lbl_mail", $this->localize("cliente.mail") );
		$xtpl->assign("lbl_direccion", $this->localize("cliente.direccion") );
		$xtpl->assign("lbl_observaciones", $this->localize("cliente.observaciones") );
		$xtpl->assign("lbl_laboral", $this->localize("cliente.laboral") );
		$xtpl->assign("lbl_cuit", $this->localize("cliente.cuit") );
		
	}


	public function getLabelCancel()
	{
	    return $this->labelCancel;
	}

	public function setLabelCancel($labelCancel)
	{
	    $this->labelCancel = $labelCancel;
	}


	
	public function getCliente()
	{
	    return $this->cliente;
	}

	public function setCliente($cliente)
	{
	    $this->cliente = $cliente;
	    
	}
	
	public function getLinkCancel(){
		$params = array();
		
		return LinkBuilder::getPageUrl( $this->getBackToOnCancel() , $params) ;
	}

	public function getSexos(){
		
		return MientrasUIUtils::localizeEntities(Sexo::getItems());
	}
	
	public function getTiposDocumento(){
		
		return MientrasUIUtils::localizeEntities(TipoDocumento::getItems());
	}

	
}
?>
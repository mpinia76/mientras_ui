<?php
namespace Mientras\UI\components\filter\model;


use Mientras\UI\components\filter\model\UIMientrasCriteria;

use Rasty\utils\RastyUtils;
use Mientras\Core\criteria\ComboCriteria;

/**
 * Representa un criterio de búsqueda
 * para combos.
 * 
 * @author Marcos
 * @since 28/08/2019
 *
 */
class UIComboCriteria extends UIMientrasCriteria{

	
	
	private $nombre;
	
	
	
	public function __construct(){

		parent::__construct();

	}
		
	
	
	protected function newCoreCriteria(){
		return new ComboCriteria();
	}
	
	public function buildCoreCriteria(){
		
		$criteria = parent::buildCoreCriteria();
				
		$criteria->setNombre( $this->getNombre() );
		
		
		return $criteria;
	}


	

	

	

	public function getNombre()
	{
	    return $this->nombre;
	}

	public function setNombre($nombre)
	{
	    $this->nombre = $nombre;
	}
}
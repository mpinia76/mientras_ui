<?php
namespace Mientras\UI\components\filter\model;


use Mientras\UI\components\filter\model\UIMientrasCriteria;

use Rasty\utils\RastyUtils;
use Mientras\Core\criteria\MovimientoCajaCriteria;

/**
 * Representa un criterio de búsqueda
 * para movimientos de cuenta.
 * 
 * @author Marcos
 * @since 14/03/2018
 *
 */
class UIMovimientoCajaCriteria extends UIMientrasCriteria{


	private $fecha;
	
	private $fechaDesde;
	
	private $fechaHasta;
	
	private $cuenta;
	
	private $cuentas;
	
	
	private $user;
		
	public function __construct(){

		parent::__construct();

	}
		
	protected function newCoreCriteria(){
		return new MovimientoCajaCriteria();
	}
	
	public function buildCoreCriteria(){
		
		$criteria = parent::buildCoreCriteria();
				
		$criteria->setFecha( $this->getFecha() );
		$criteria->setFechaDesde( $this->getFechaDesde() );
		$criteria->setFechaHasta( $this->getFechaHasta() );
		$criteria->setCuenta( $this->getCuenta() );
		$criteria->setCuentas( $this->getCuentas() );
		$criteria->setUser( $this->getUser() );
		return $criteria;
	}


	public function getFecha()
	{
	    return $this->fecha;
	}

	public function setFecha($fecha)
	{
	    $this->fecha = $fecha;
	}

	public function getFechaDesde()
	{
	    return $this->fechaDesde;
	}

	public function setFechaDesde($fechaDesde)
	{
	    $this->fechaDesde = $fechaDesde;
	}

	public function getFechaHasta()
	{
	    return $this->fechaHasta;
	}

	public function setFechaHasta($fechaHasta)
	{
	    $this->fechaHasta = $fechaHasta;
	}

	

	public function getCuenta()
	{
	    return $this->cuenta;
	}

	public function setCuenta($cuenta)
	{
	    $this->cuenta = $cuenta;
	}

	public function getCuentas()
	{
	    return $this->cuentas;
	}

	public function setCuentas($cuentas)
	{
	    $this->cuentas = $cuentas;
	}

	public function getUser()
	{
	    return $this->user;
	}

	public function setUser($user)
	{
	    $this->user = $user;
	}
}
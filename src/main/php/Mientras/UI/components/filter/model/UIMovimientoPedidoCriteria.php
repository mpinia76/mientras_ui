<?php
namespace Mientras\UI\components\filter\model;


use Mientras\UI\components\filter\model\UIMientrasCriteria;

use Rasty\utils\RastyUtils;
use Mientras\Core\criteria\MovimientoPedidoCriteria;

/**
 * Representa un criterio de búsqueda
 * para movimientos de cuenta.
 * 
 * @author Marcos
 * @since 10/07/2020
 *
 */
class UIMovimientoPedidoCriteria extends UIMientrasCriteria{


	private $fecha;
	
	private $fechaDesde;
	
	private $fechaHasta;
	
	private $cuenta;
	
	private $pedido;
		
	public function __construct(){

		parent::__construct();

	}
		
	protected function newCoreCriteria(){
		return new MovimientoPedidoCriteria();
	}
	
	public function buildCoreCriteria(){
		
		$criteria = parent::buildCoreCriteria();
				
		$criteria->setFecha( $this->getFecha() );
		$criteria->setFechaDesde( $this->getFechaDesde() );
		$criteria->setFechaHasta( $this->getFechaHasta() );
		$criteria->setCuenta( $this->getCuenta() );
		$criteria->setPedido( $this->getPedido() );
		
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

	public function getPedido()
	{
	    return $this->pedido;
	}

	public function setPedido($pedido)
	{
	    $this->pedido = $pedido;
	}
}
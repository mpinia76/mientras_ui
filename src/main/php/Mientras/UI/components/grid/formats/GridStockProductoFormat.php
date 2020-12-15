<?php
namespace Cuentas\UI\components\grid\formats;

use Cuentas\Core\model\Sucursal;
use Cuentas\Core\model\Producto;
use Rasty\i18n\Locale;
use Rasty\Grid\entitygrid\model\GridValueFormat;
/**
 * Formato para mostrar el stock de un producto
 * para una sucursal
 *
 * @author Bernardo
 * @since 31-05-2014
 *
 */

class GridStockProductoFormat extends  GridValueFormat{

	private $sucursal;

	public function __construct(Sucursal $sucursal){
	
		$this->sucursal = $sucursal;
	}
	
	public function format( $value, $item=null ){
		
		if( $item !=null )
			return  $item->getStockEnSucursal( $this->getSucursal() );
		else $value;	
	}		
	

	public function getSucursal()
	{
	    return $this->sucursal;
	}

	public function setSucursal($sucursal)
	{
	    $this->sucursal = $sucursal;
	}
}
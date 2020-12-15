<?php
namespace Mientras\UI\components\grid\formats;

use Mientras\UI\utils\MientrasUIUtils;

use Mientras\Core\model\EstadoPresupuesto;
use Rasty\Grid\entitygrid\model\GridValueFormat;
use Rasty\i18n\Locale;

/**
 * Formato para renderizar el estado de una Presupuesto
 *
 * @author Marcos
 * @since 29-03-2019
 *
 */

class GridEstadoPresupuestoFormat extends  GridValueFormat{

	private $pattern;
	
	public function format( $value, $item=null ){
		
		if( !empty($value))
			return  Locale::localize( EstadoPresupuesto::getLabel( $value ) );
		else $value;	
	}		
	
	public function getColumnCssClass($value, $item=null){
	
		return MientrasUIUtils::getEstadoPresupuestoCss($value);
	}
	
	public function getPattern(){
		return $this->pattern;
	}
	
}
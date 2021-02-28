<?php
namespace Mientras\UI\service;

use Mientras\UI\components\filter\model\UIGastoCriteria;

use Rasty\components\RastyPage;
use Rasty\utils\XTemplate;
use Rasty\i18n\Locale;
use Rasty\exception\RastyException;
use Cose\criteria\impl\Criteria;

use Mientras\Core\model\Gasto;
use Mientras\Core\model\Caja;
use Mientras\Core\model\Cuenta;

use Mientras\Core\service\ServiceFactory;
use Cose\Security\model\User;

use Rasty\Grid\entitygrid\model\IEntityGridService;
use Rasty\Grid\filter\model\UICriteria;

/**
 *
 * UI service para Gasto.
 *
 * @author Marcos
 * @since 12/03/2018
 */
class UIGastoService  implements IEntityGridService{

    private static $instance;

    private function __construct() {}

    public static function getInstance() {

        if( self::$instance == null ) {

            self::$instance = new UIGastoService();

        }
        return self::$instance;
    }



    public function getList( UIGastoCriteria $uiCriteria){

        try{

            $criteria = $uiCriteria->buildCoreCriteria() ;

            //$criteria->addOrder("fechaHora", "ASC");

            $service = ServiceFactory::getGastoService();

            $gastos = $service->getList( $criteria );

            return $gastos;

        } catch (\Exception $e) {

            throw new RastyException($e->getMessage());

        }
    }


    public function get( $oid ){

        try{

            $service = ServiceFactory::getGastoService();

            return $service->get( $oid );

        } catch (\Exception $e) {

            throw new RastyException($e->getMessage());

        }
    }

    public function add( Gasto $gasto ){

        try {

            $service = ServiceFactory::getGastoService();

            return $service->add( $gasto );

        } catch (\Exception $e) {

            throw new RastyException($e->getMessage());

        }
    }


    function getEntitiesCount($uiCriteria){

        try{

            $criteria = $uiCriteria->buildCoreCriteria() ;

            $service = ServiceFactory::getGastoService();
            $gastos = $service->getCount( $criteria );

            return $gastos;

        } catch (\Exception $e) {

            throw new RastyException($e->getMessage());

        }
    }

    function getEntities($uiCriteria){

        return $this->getList($uiCriteria);
    }


    public function pagar(Gasto $gasto, Cuenta $cuenta, User $user){

        try {

            $service = ServiceFactory::getGastoService();

            return $service->pagar($gasto, $cuenta, $user);

        } catch (\Exception $e) {

            throw new RastyException( $e->getMessage() );

        }

    }

    public function getTotalesCuenta( Cuenta $cuenta=null, \DateTime $fecha=null ){

        try {

            $service = ServiceFactory::getMovimientoGastoService();

            $totales = $service->getTotales( $cuenta, $fecha );

            return $totales;

        } catch (\Exception $e) {

            throw new RastyException($e->getMessage());

        }
    }


    public function anular(Gasto $gasto, User $user){

        try {

            $service = ServiceFactory::getGastoService();

            return $service->anular($gasto, $user);

        } catch (\Exception $e) {

            throw new RastyException( $e->getMessage() );

        }

    }


    public function getGastosPorVencer(){

        try{

            $service = ServiceFactory::getGastoService();

            $gastos = $service->getGastosPorVencer( );

            return $gastos;

        } catch (\Exception $e) {

            throw new RastyException($e->getMessage());

        }
    }

    public function getTotalesCuentaMes( Cuenta $cuenta=null, \DateTime $fecha=null ){

        try {

            $service = ServiceFactory::getMovimientoGastoService();

            $totales = $service->getTotalesMes( $cuenta, $fecha );

            return $totales;

        } catch (\Exception $e) {

            throw new RastyException($e->getMessage());

        }
    }

    public function getTotalesCuentaAnioPorMes( Cuenta $cuenta=null, $anio ){

        try {

            $service = ServiceFactory::getMovimientoGastoService();

            $totales = $service->getTotalesAnioPorMes( $cuenta, $anio );

            return $totales;

        } catch (\Exception $e) {

            throw new RastyException($e->getMessage());

        }
    }

    public function getTotalesAnioPorMesConcepto($anio){

        try {

            $service = ServiceFactory::getMovimientoGastoService();

            $totales = $service->getTotalesAnioPorMesConcepto( $anio );

            return $totales;

        } catch (\Exception $e) {

            throw new RastyException($e->getMessage());

        }
    }

    public function getTotales( UIGastoCriteria $uiCriteria){

        try{

            $criteria = $uiCriteria->buildCoreCriteria() ;

            //$criteria->addOrder("fechaHora", "ASC");

            $service = ServiceFactory::getGastoService();

            $gastos = $service->getList( $criteria );

            $saldo = 0;
            foreach ($gastos as $gasto) {

                if($gasto->podesAnularte()){
                    $saldo += $gasto->getMonto();
                }
            }
            return $saldo;


        } catch (Exception $e) {

            throw new RastyException($e->getMessage());

        }
    }
}
?>

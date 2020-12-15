<?php
namespace Mientras\UI\service;

use Rasty\components\RastyPage;
use Rasty\utils\XTemplate;
use Rasty\i18n\Locale;
use Rasty\exception\RastyException;
use Cose\criteria\impl\Criteria;

use Cose\Security\criteria\UserCriteria;
use Mientras\Core\service\ServiceFactory;
use Cose\Security\model\User;

use Rasty\Grid\entitygrid\model\IEntityGridService;
use Rasty\Grid\filter\model\UICriteria;
use Cose\Security\Restful\model\UserRestful;

/**
 * 
 * UI service para User.
 * 
 * @author Marcos
 * @since 01/03/2018
 */
class UIUserService{
	
	private static $instance;
	
	private function __construct() {}
	
	public static function getInstance() {
		
		if( self::$instance == null ) {
			
			self::$instance = new UIUserService();
			
		}
		return self::$instance; 
	}

	public static function getUserByUsername( $username ){
		return \Cose\Security\service\ServiceFactory::getUserService()->getUserByUsername($username);
	}
	
	public static function getUsers( ){
		$criteria = new UserCriteria();
		$criteria->addOrder("name", "ASC");
		return \Cose\Security\service\ServiceFactory::getUserService()->getList($criteria);
	}
	
	
	
	public function get( $oid ){

		try{
			
			$service = \Cose\Security\service\ServiceFactory::getUserService();
		
			return $service->get( $oid );
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
	public static function loginRestful( $username, $password ){
		
		
		try{
			
			if(empty($username))
				throw new RastyException("username requerido");
				 
			if(empty($password))
				throw new RastyException("password requerido"); 
				
			//hacemos el login del usuario.
			$user = \Cose\Security\service\ServiceFactory::getSecurityService()->authenticate($username,$password);
		
			//creamos el token para restful.
			$ur = new UserRestful();
			$ur->setUserOid( $user->getOid());
			
			$date = new \DateTime();
			$date->modify('+1 month');
			$ur->setExpiration( $date );
			
			$serviceRestful = \Cose\Security\Restful\service\ServiceFactory::getUserRestfulService();
			$serviceRestful->add( $ur );
			
			//retornamos el token.
			return $ur->getToken();
			
		} catch (\Exception $e) {
			
			throw new RastyException($e->getMessage());
			
		}
	}
	
}
?>
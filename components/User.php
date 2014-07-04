<?php
/**
 *
 * @author Ricardo Obregón <ricardo@obregon.co>
 * @created 24/11/13 07:40 PM
 */

namespace core\components;

use Yii;
use yii\web\IdentityInterface;
use yii\db\Expression;
use core\components\DbManager;
use yii\db\Query;

/**
 * User is the class for the "user" application component that manages the user authentication status.
 *
 * @property \core\models\User $identity The identity object associated with the currently logged user. Null
 * is returned if the user is not logged in (not authenticated).
 *
 * @author Ricardo Obregón <robregonm@gmail.com>
 */
class User extends \yii\web\User
{
	/**
	 * @inheritdoc
	 */
	public $identityClass = '\core\models\User';

	/**
	 * @inheritdoc
	 */
	public $enableAutoLogin = true;

	/**
	 * @inheritdoc
	 */
	public $loginUrl = ['/core/default/login'];

	/**
	 * @inheritdoc
	 */
	protected function afterLogin($identity, $cookieBased, $duration)
	{
		parent::afterLogin($identity, $cookieBased, $duration);
		$this->identity->setScenario(self::EVENT_AFTER_LOGIN);
		$this->identity->setAttribute('last_visit_time', new Expression('CURRENT_TIMESTAMP'));
		// $this->identity->setAttribute('login_ip', ip2long(\Yii::$app->getRequest()->getUserIP()));
		$this->identity->save(false);
		$r = new DbManager;
		$r->revokeAll($this->identity->id);
		$role = $r->getRole($this->identity->Group_id);
		$r->assign($role, $this->identity->id);
	}

	public function getIsSuperAdmin()
	{
		if ($this->isGuest) {
			return false;
		}
		return $this->identity->getIsSuperAdmin();
	}

	public function checkAccess($operation, $params = [], $allowCaching = true)
	{
		//disable the super admins
		// Always return true when SuperAdmin user
		/*if ($this->getIsSuperAdmin()) {
			return true;
		}*/
		if(!$operation)
			return true;
		$key = $operation . serialize($params);
		$can = Yii::$app->cache->get($key);
		if(!$can) {
			//Yii::trace('Calculating permission ' . $operation);
			$can = parent::can($operation, $params, $allowCaching);
			Yii::$app->cache->set($key, $can);
		} else {
			//Yii::trace('Permission from cache ' . $operation);
		}
		
		return $can;
	}
}
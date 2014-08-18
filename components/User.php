<?php
/**
 *
 * @author Ricardo Obregón <ricardo@obregon.co>
 * @created 24/11/13 07:40 PM
 */

namespace core\components;

use Yii;
use yii\web\User as BaseUser;
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
class User extends BaseUser
{
	/**
	 * @inheritdoc
	 */
	public $identityClass = '\core\models\Administrator';

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
		$this->identity->setAttribute('name', $this->identity->name);
		$this->identity->save(false);
		$r = new DbManager;
		$r->revokeAll($this->identity->id);
		$role = $r->getRole($this->identity->Group_id);
		$r->assign($role, $this->identity->id);
	}

	public function checkAccess($operation, $params = [], $allowCaching = false)
	{
		if(!$operation)
			return true;
		$key = $operation . serialize($params);
		
		$can = Yii::$app->session->get($key);
		if(!$can) {
			$can = parent::can($operation, $params, $allowCaching);
			Yii::$app->session->set($key, $can);
		}
		return $can;
	}
}
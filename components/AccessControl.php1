<?php
/**
 * Auth AccessControl class file.
 * Behavior that automatically checks if the user has access to the current controller action.
 *
 * @author Ricardo Obregón <ricardo@obregon.co>
 * @copyright Copyright &copy; Ricardo Obregón 2012-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package core.components
 */

namespace core\components;

use Yii;
use yii\web\ForbiddenHttpException;

/**
 * Auth AccessControl provides RBAC access control.
 *
 * Auth AccessControl is an action filter. It will check the item names to find
 * the first match that will dictate whether to allow or deny the access to the requested controller
 * action. If no matches, the access will be denied.
 *
 * To use Auth AccessControl, declare it in the `behaviors()` method of your controller class.
 * For example, the following declaration will enable rbac filtering in your controller.
 *
 * ~~~
 * public function behaviors()
 * {
 *     return [
 *         'access' => [
 *             'class' => \core\components\AccessControl::className(),
 *         ],
 *     ];
 * }
 * ~~~
 *
 * @author Mihai Petrescu <mihai.petrescu@gmail.com>
 */
class AccessControl extends \yii\filters\AccessControl
{
	/**
	 * @var array name-value pairs that would be passed to business rules associated
	 * with the tasks and roles assigned to the user.
	 */
	public $params = [];

	/**
	 * @var callback a callback that will be called if the access should be denied
	 * to the current user. If not set, [[denyAccess()]] will be called.
	 *
	 * The signature of the callback should be as follows:
	 *
	 * ~~~
	 * function ($item, $action)
	 * ~~~
	 *
	 * where `$item` is this item name, and `$action` is the current [[Action|action]] object.
	 */
	public $denyCallback;

	private $separator = '::';

	private function getItemName($component)
	{
		return strtr(ucfirst($component->getUniqueId()), '::', $this->separator);
	}

	/**
	 * Denies the access of the user.
	 * The default implementation will redirect the user to the login page if he is a guest;
	 * if the user is already logged, a 403 HTTP exception will be thrown.
	 *
	 * @param User $user the current user
	 * @throws ForbiddenHttpException if the user is already logged in.
	 */
	protected function denyAccess($user)
	{
		if ($user->getIsGuest()) {
			$user->loginRequired();
		} else {
			throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
		}
	}

}

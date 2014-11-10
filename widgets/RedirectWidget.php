<?php
/**
 * AuthRedirectWidget class file.
 *
 * @author Mihai Petrescu <mihai.petrescu@gmail.com>
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace core\widgets;

use \Yii;
use yii\helpers\ArrayHelper;

/**
 * The EAuthRedirectWidget widget displays the redirect page after returning from provider.
 *
 * @package application.extensions.eauth
 */
class RedirectWidget extends Widget
{

	/**
	 * @var mixed the widget mode
	 */
	public $url = null;

	/**
	 * @var boolean whether to use redirect inside the popup window.
	 */
	public $redirect = true;

	/**
	 * @var string
	 */
	public $view = 'redirect';

	/**
	 * @var array
	 */
	public $params = [];

	/**
	 * Executes the widget.
	 */
	public function run()
	{
		echo $this->render($this->view,
			ArrayHelper::merge(array(
				'id' => $this->getId(),
				'url' => $this->url,
				'redirect' => $this->redirect,
			), $this->params)
		);
	}
}

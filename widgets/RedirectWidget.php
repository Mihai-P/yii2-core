<?php
/**
 * RedirectWidget class file.
 *
 * @author Mihai Petrescu <mihai.petrescu@gmail.com>
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace core\widgets;

use \Yii;
use yii\helpers\ArrayHelper;
use yii\base\Widget;

/**
 * The RedirectWidget widget displays the redirect page after returning from provider.
 *
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
		return $this->render($this->view,
			ArrayHelper::merge(array(
				'id' => $this->getId(),
				'url' => $this->url,
				'redirect' => $this->redirect,
			), $this->params)
		);
	}
}

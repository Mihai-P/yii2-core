<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace core\components;

use Yii;
use yii\base\Action;


/**
 * DetailsAction displays application errors using a specified view.
 *
 * To use DetailsAction, you need to do the following steps:
 *
 * First, declare an action of DetailsAction type in the `actions()` method of your `NameController`
 * class (or whatever controller you prefer), like the following:
 *
 * ```php
 * public function actions()
 * {
 *     return [
 *         'details' => ['class' => 'core\components\DetailsAction'],
 *     ];
 * }
 * ```
 *
 * @author Mihai Petrescu <mihai.petrescu@gmail.com>
 */
class DetailsAction extends Action
{
    public function run($id)
    {
        Yii::$app->response->format = 'json';
        return $this->controller->findModel($id);
    }
}

<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace core\components;

use Yii;
use yii\base\Action;
use Goodby\CSV\Export\Standard\Exporter;
use Goodby\CSV\Export\Standard\ExporterConfig;


/**
 * ErrorAction displays application errors using a specified view.
 *
 * To use ErrorAction, you need to do the following steps:
 *
 * First, declare an action of ErrorAction type in the `actions()` method of your `SiteController`
 * class (or whatever controller you prefer), like the following:
 *
 * ```php
 * public function actions()
 * {
 *     return [
 *         'error' => ['class' => 'yii\web\ErrorAction'],
 *     ];
 * }
 * ```
 *
 * Then, create a view file for this action. If the route of your error action is `site/error`, then
 * the view file should be `views/site/error.php`. In this view file, the following variables are available:
 *
 * - `$name`: the error name
 * - `$message`: the error message
 * - `$exception`: the exception being handled
 *
 * Finally, configure the "errorHandler" application component as follows,
 *
 * ```php
 * 'errorHandler' => [
 *     'errorAction' => 'site/error',
 * ]
 * ```
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class CsvAction extends Action
{
    /**
     * @var array the fields that will be shown in the CSV file
     */
    public $fields = ['id', 'name', 'status'];

    public function run()
    {
        $this->controller->getSearchCriteria();
        $this->controller->dataProvider->pagination = false;
        $query = $this->controller->dataProvider->query;

        $config = new ExporterConfig();
        $exporter = new Exporter($config);
        $result = $query->asArray()->all();
        $fields = $this->fields;
        $values = array_map(function ($ar) use ($fields) {
            $return = [];
            foreach($fields as $field) {
                $keyString = "['" . str_replace('.', "']['", $field) . "']"; 
                eval("\$return[] = \$ar".$keyString.";");
            }
            return $return;
        }, $result);
        Yii::$app->response->getHeaders()->set('Content-Type', 'application/csv');
        Yii::$app->response->getHeaders()->set('Content-Disposition', 'attachment; filename="'.$this->controller->getCompatibilityId().'.csv"');
        $exporter->export('php://output', array_merge([$this->fields], $values));
    }
}

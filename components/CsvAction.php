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
 * CsvAction displays application errors using a specified view.
 *
 * To use CsvAction, you need to do the following steps:
 *
 * Declare an action of CsvAction type in the `actions()` method of your `YyyController`
 * class (or whatever controller you prefer), like the following:
 *
 * ```php
 * public function actions()
 * {
 *     return [
 *         'error' => ['class' => 'core\components\CsvAction'],
 *     ];
 * }
 * ```
 *
 * @author Mihai Petrescu <mihai.petrescu@gmail.com>
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

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
use yii\web\Response;


/**
 * CsvAction displays application errors using a specified view.
 *
 * @property Controller $controller
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

    /**
     * Creates the pdf file for download
     */
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
        //$values = array_map(function () use ($fields) {
            $return = [];
            foreach($fields as $field) {
                $keyString = "['" . str_replace('.', "']['", $field) . "']"; 
                eval("\$return[] = \$ar".$keyString.";");
            }
            return $return;
        }, $result);
        if(isset($_GET['test'])) {
            return json_encode(array_merge([$this->fields], $values));
        } else {
            $this->setHttpHeaders('csv', $this->controller->getCompatibilityId(), 'text/plain');
            $exporter->export('php://output', array_merge([$this->fields], $values));
        }
    }


    /**
     * Sets the HTTP headers needed by file download action.
     */
    protected function setHttpHeaders($type, $name, $mime, $encoding = 'utf-8')
    {
        Yii::$app->response->format = Response::FORMAT_RAW;
        if (strstr($_SERVER["HTTP_USER_AGENT"], "MSIE") == false) {
            header("Cache-Control: no-cache");
            header("Pragma: no-cache");
        } else {
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Pragma: public");
        }
        header("Expires: Sat, 26 Jul 1979 05:00:00 GMT");
        header("Content-Encoding: {$encoding}");
        header("Content-Type: {$mime}; charset={$encoding}");
        header("Content-Disposition: attachment; filename={$name}.{$type}");
        header("Cache-Control: max-age=0");
    }
}

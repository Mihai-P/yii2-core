<?php
/**
 * HistoryWidget class file.
 *
 * @author Mihai Petrescu <mihai.petrescu@gmail.com>
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace core\widgets;

use \Yii;
use yii\base\Widget;
use core\models\History;
use yii\caching\DbDependency;

/**
 * The HistoryWidget widget displays some history from a history table.
 *
 */
class HistoryWidget extends Widget
{
    public function run()
    {
        $dependency = new DbDependency(['sql' => 'SELECT MAX(update_time) FROM History WHERE create_by = ' . Yii::$app->user->id]);
        $response = Yii::$app->cache->get('history' . Yii::$app->user->id);
        if ($response === false) {
            $response = $this->render('history', [
                'criteria' => History::find()->where('create_by = "'.Yii::$app->user->id.'"')->orderBy('create_time DESC')->groupBy('url')->limit(10),
            ]);
            Yii::$app->cache->set('history' . Yii::$app->user->id, $response, 30, $dependency);
        }
        return $response;
    }
}

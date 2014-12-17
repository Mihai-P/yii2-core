<?php
/**
 * RedirectWidget class file.
 *
 * @author Mihai Petrescu <mihai.petrescu@gmail.com>
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace core\widgets;

use \Yii;
use yii\base\Widget;
use core\models\Bookmark;

/**
 * The RedirectWidget widget displays the redirect page after returning from provider.
 *
 */
class BookmarkWidget extends Widget
{
    public function run()
    {
        $criteria = Bookmark::find()->where('create_by = "'.Yii::$app->user->id.'"')->andWhere('status = "active"')->orderBy('(reminder IS NULL), reminder ASC')->limit(10);
        return $this->render('bookmark',
            [
                'criteria' => $criteria,
                'counter' => Bookmark::find()->where('create_by = "'.Yii::$app->user->id.'"')->andWhere('status = "active"')->andWhere('reminder IS NOT NULL')->andWhere('reminder < NOW()')->limit(10)->count(),
            ]
        );
    }
}

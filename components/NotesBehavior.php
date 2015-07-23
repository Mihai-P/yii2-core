<?php
/**
 * SeoBehaviour allows tag management to controllers
 *
 * @author Mihai Petrescu <mihai.petrescu@gmail.com>
 */
namespace core\components;

use Yii;
use yii\base\Behavior;
use core\models\Note;

/**
 * SeoBehaviour allows tag management to controllers
 *
 * in the view at the top you should do a
 * $this->params['seo'] = $model->getSeoTags();
 */
class NotesBehavior extends Behavior
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotes()
    {
        return $this->owner->hasMany(Note::className(), ['Model_id' => 'id'])->where('Model = :Model', [':Model' => StringHelper::basename(get_class($this->owner))])->orderBy('update_time DESC');
    }
}

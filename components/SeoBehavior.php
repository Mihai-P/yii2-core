<?php
/**
 * SeoBehaviour allows tag management to controllers
 *
 * @author Mihai Petrescu <mihai.petrescu@gmail.com>
 */
namespace core\components;

use Yii;
use yii\base\Behavior;
use core\models\Seo;

/**
 * SeoBehaviour allows tag management to controllers
 *
 * in the view at the top you should do a
 * $this->params['seo'] = $model->getSeoTags();
 */
class SeoBehavior extends Behavior
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeo()
    {
        return $this->owner->hasOne(Seo::className(), ['Model_id' => 'id'])->where('Model = :Model', [':Model' => StringHelper::basename(get_class($this->owner))]);
    }
    /**
     * Get the seo tags as an array
     *
     * @return string
     */
    public function getSeoTags() {
        if($this->owner->seo) {
            $seo = $this->owner->seo->attributes;
            return array_filter(array_intersect_key($seo, array_flip(['meta_title', 'meta_keywords', 'meta_description'])));
        } else {
            return [];
        }
    }
}
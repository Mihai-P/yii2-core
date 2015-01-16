<?php
/**
 * DefaultQuery extends ActiveQuery to set the default parameters for the query.
 *
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace core\components;

use yii\db\ActiveQuery;

/**
 * DefaultQuery extends ActiveQuery to set the default parameters for the query.
 *
 * This includes setting the default status to "active" for record searches so
 * that only active records are found by default.
 *
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */
class DefaultQuery extends ActiveQuery
{
    /**
     * Adds the default query
     *
     * @return \yii\db\ActiveQuery
     */
    public function active()
    {
        $this->andWhere(['status' => 'active']);
        return $this;
    }
}
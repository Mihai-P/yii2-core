<?php
namespace core\components;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use core\components\HistoryBehavior;
use yii\db\BaseActiveRecord;
use sammaye\audittrail\LoggableBehavior;
use yii\db\Expression;


class ActiveRecord extends \yii\db\ActiveRecord
{
    /**
     * Deletes the table row corresponding to this active record.
     *
     * This method performs the following steps in order:
     *
     * 1. call [[beforeDelete()]]. If the method returns false, it will skip the
     *    rest of the steps;
     * 2. delete the record from the database;
     * 3. call [[afterDelete()]].
     *
     * In the above step 1 and 3, events named [[EVENT_BEFORE_DELETE]] and [[EVENT_AFTER_DELETE]]
     * will be raised by the corresponding methods.
     *
     * @return integer|boolean the number of rows deleted, or false if the deletion is unsuccessful for some reason.
     * Note that it is possible the number of rows deleted is 0, even though the deletion execution is successful.
     * @throws StaleObjectException if [[optimisticLock|optimistic locking]] is enabled and the data
     * being deleted is outdated.
     * @throws \Exception in case delete failed.
     */
    public function delete()
    {
        $this->status = 'deleted';
        $this->save(false);
        return true;
    }   

    public function behaviors()
    {
        return [
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => ['create_by', 'update_by'],
                    BaseActiveRecord::EVENT_BEFORE_UPDATE => 'update_by'
                ],                
            ],
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => ['create_time', 'update_time'],
                    BaseActiveRecord::EVENT_BEFORE_UPDATE => 'update_time',
                ],
                'value' => new Expression('NOW()'),
            ],
            'audit' => [
                'class' => LoggableBehavior::className(),
                'ignoredClasses' => ['core\models\History'],
                'ignored' => ['id', 'update_time', 'update_by', 'create_time', 'create_by'],
            ],
        ];
    }    
}
<?php
namespace core\components;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use core\components\HistoryBehavior;
use yii\db\BaseActiveRecord;
use sammaye\audittrail\LoggableBehavior;
use yii\db\Expression;
use yii\db\StaleObjectException;


class ActiveRecord extends \yii\db\ActiveRecord
{
    /**
     * Marks an ActiveRecord as deleted in the database
     * @return integer|boolean the number of rows deleted, or false if the deletion is unsuccessful for some reason.
     * Note that it is possible the number of rows deleted is 0, even though the deletion execution is successful.
     * @throws StaleObjectException
     */
    public function deleteInternal()
    {
        $result = false;
        if ($this->beforeDelete()) {
            // we do not check the return value of deleteAll() because it's possible
            // the record is already deleted in the database and thus the method will return 0
            $condition = $this->getOldPrimaryKey(true);
            $lock = $this->optimisticLock();
            if ($lock !== null) {
                $condition[$lock] = $this->$lock;
            }
            $this->status = 'deleted';
            $result = $this->save(false);
            if ($lock !== null && !$result) {
                throw new StaleObjectException('The object being deleted is outdated.');
            }
            $this->setOldAttributes(null);
            $this->afterDelete();
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
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
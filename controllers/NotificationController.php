<?php
namespace core\controllers;

use Yii;
use yii\db\Query;
use core\models\Email;
/**
 * Import controller
 */
class NotificationController extends \yii\console\Controller
{
    public function actionIndex()
    {
        $emails = Email::find()->where('status="pending" AND tries<10')->all();
        foreach($emails as $email) {
            if(\Yii::$app->mailer->compose()
                ->setHtmlBody($email->html)
                ->setFrom($email->from_email)
                ->setTo($email->to_email)
                ->setSubject($email->subject)
                ->send()) {
                $email->status = 'sent';
            } else {
                $email->tries++;
            }
            $email->detachBehavior('blameable');
            $email->detachBehavior('audit');
            $email->save(false);
        }   
    }    
}
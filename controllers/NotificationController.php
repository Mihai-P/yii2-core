<?php
namespace core\controllers;

use Yii;
use yii\db\Query;
use core\models\Email;
use Mandrill;
/**
 * Import controller
 */
class NotificationController extends \yii\console\Controller
{
    public function actionIndex()
    {
        $emails = Email::find()->where('status="pending" AND tries<10')->all();
        foreach($emails as $email) {
            $mandrill = new Mandrill(Yii::$app->params['mandrill']['key']);
            $message = array(
                'html' => $email->html,
                'text' => $email->text,
                'subject' => $email->subject,
                'from_email' => $email->from_email,
                'from_name' => $email->from_name,
                'track_opens' => true,
                'track_clicks' => true,
                'auto_text' => true,
                'to'=>array(array('email' => $email->to_email, 'name' => $email->to_name))
            ); 
            $email->detachBehavior('blameable');
              
            $result = $mandrill->messages->send($message);
            
            if($result[0]['status'] == 'sent') {
                $email->status = 'sent';
            } else {
                $email->tries++;
            }
            $email->save(false);
        }
    }    
}
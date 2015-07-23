<?php
namespace core\controllers;

use Yii;
use yii\db\Query;
use core\models\Email;
use yii\helpers\ArrayHelper;
/**
 * Import controller
 */
class NotificationController extends \yii\console\Controller
{
    public function actionIndex()
    {
        $emails = Email::find()->where('status="pending" AND tries<10')->all();
        foreach($emails as $email) {
            $data = @unserialize($email->html);
            if ($data !== false) {
                \Yii::$app->mailer->useMandrillTemplates = true;
                \Yii::$app->mailer->templateLanguage = \nickcv\mandrill\Mailer::LANGUAGE_HANDLEBARS;

                $template = ArrayHelper::remove($data, 'template');
                if($template) {
                    $result = \Yii::$app->mailer->compose('notificationOrderConfirmation', $data)
                        ->setTo(['mihai.petrescu+5@gmail.com' => 'Mihai Petrescu'])
                        ->send();
                } else {
                    $result = false;
                }
            } else {
                \Yii::$app->mailer->useMandrillTemplates = false;
                $result = \Yii::$app->mailer->compose()
                    ->setHtmlBody($email->html)
                    ->setFrom($email->from_email)
                    ->setTo(['mihai.petrescu+5@gmail.com' => 'Mihai Petrescu'])
                    ->setSubject($email->subject)
                    ->send();
            }

            if($result) {
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

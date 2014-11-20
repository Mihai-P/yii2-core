<?php
namespace core\models;

use Yii;
use core\models\Administrator;
use yii\base\Model;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => Administrator::className(),
                'filter' => ['status' => User::STATUS_ACTIVE, 'type' => 'Administrator'],
                'message' => 'There was an error sending the email.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = Administrator::find()->where([
            'status' => Administrator::STATUS_ACTIVE,
            'email' => $this->email,
        ])->one();

        if ($user) {
            if (!Administrator::isPasswordResetTokenValid($user->password_reset_token)) {
                $user->generatePasswordResetToken();
            }

            if ($user->save()) {
                Email::create()
                    ->html(Yii::$app->view->renderFile('@core/views/emails/passwordResetToken.php', ['user' => $user]))
                    ->subject("Reset Password")
                    ->to(['email' => $user->email, 'name'=> $user->name])
                    ->send();

                return true;
            } else {
                return false;
            }
        }

        return false;
    }
}
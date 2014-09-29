<?php

namespace core\models;

use Yii;
use Mandrill;

/**
 * This is the model class for table "Email".
 *
 * @property integer $id
 * @property string $from_email
 * @property string $from_name
 * @property string $to_email
 * @property string $to_name
 * @property string $subject
 * @property string $text
 * @property string $html
 * @property string $route
 * @property integer $tries
 * @property string $status
 * @property string $update_time
 * @property integer $update_by
 * @property string $create_time
 * @property integer $create_by
 */
class Email extends \core\components\ActiveRecord
{
    /**
     * array that holds multiple recipients
     */
    var $multiple_repicients;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Email';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from_email', 'from_name'], 'required'],
            [['text', 'reply_to', 'html', 'route', 'status'], 'string'],
            [['tries', 'update_by', 'create_by'], 'integer'],
            [['update_time', 'create_time'], 'safe'],
            [['from_email', 'from_name', 'to_email', 'to_name', 'subject'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'from_email' => 'From Email',
            'from_name' => 'From Name',
            'to_email' => 'To Email',
            'to_name' => 'To Name',
            'reply_to' => 'Reply To',
            'subject' => 'Subject',
            'text' => 'Text',
            'html' => 'Html',
            'route' => 'Route',
            'tries' => 'Tries',
            'status' => 'Status',
            'update_time' => 'Update Time',
            'update_by' => 'Update By',
            'create_time' => 'Create Time',
            'create_by' => 'Create By',
        ];
    }

    /**
     * Creates a new email model and returns it
     *
     * @access  public
     * @return  this
     */ 
    public static function create() {
        $email = new static();
        $email->from_email = Yii::$app->params['mandrill']['from_email'];
        $email->from_name = Yii::$app->params['mandrill']['from_name'];
        return $email;
    }

    /**
     * Magic function to set attributes
     *
     * Allows you to set the attributes like this
     * $email->subject('Hello World');
     *
     * @access  public
     * @return  this
     */ 
    public function __call($funcname, $args = []) {
        if($this->hasAttribute($funcname)) {
            $this->$funcname = $args[0];
        }

        return $this;
    }

    /**
     * Sets the from fields
     *
     * Usage:
     * $email->from('name', 'name@test.com');
     *
     * @access  public
     * @param string $name the name of the receiver
     * @param string $email array with the keys email, name
     * @return  this
     */ 

    public function from($name, $email) {
        $this->from_email = $email;
        $this->from_name = $name;

        return $this;
    }

    /**
     * Allows sending to multiple recipients
     *
     * Usage:
     * $email
     *      ->to(["email" = > "test@test.com", "name"=>"Test User"])
     *      ->to(["email" = > "test2@test.com", "name"=>"Test User"]);
     *
     * @access  public
     * @param array $recipient array with the keys email, name
     * @return  this
     */ 

    public function to($recipient) {
        $this->multiple_repicients[] = $recipient;
        return $this;
    }

    /**
     * Sends the email to the email queue
     * 
     * Usage:
     * $success = \Email::create()
     *          ->html("Hello World!!!")
     *          ->subject("Hello");
     *          ->to(['email' => 'recipient1@biti.ro', 'name' => 'Recipient1'])
     *          ->to(['email' => 'recipient2@biti.ro', 'name' => 'Recipient2'])
     *          ->send()
     * if($success) {}
     *
     * it returns true if it was succesfull or the errors of the model 
     *
     * @access  public
     * @return  mixed
     */ 
    public function send() {
        if(!$this->validate()) {
            return $this->getErrors();
        }

        foreach( $this->multiple_repicients as $to )
        {
            $email_copy = clone $this;
            if(is_array($to)) {
                $email_copy->to_email = $to['email'];
                $email_copy->to_name = $to['name'];
            } else {
                $email_copy->to_email = $to;
                $email_copy->to_name = '';
            }
            $email_copy->save(false);
        }
        return true;        
    } 

    /**
     * Tries to send the email to mandril
     *
     * If it is successfull then it updates the email
     * If it is NOT successfull then it updates number of tries
     *
     * @access  public
     */ 
    public function sendEmail() {
        $mandrill = new Mandrill(Yii::$app->params['mandrill']['key']);
        $message = [
            'html' => $this->html,
            'text' => $this->text,
            'subject' => $this->subject,
            'from_email' => $this->from_email,
            'from_name' => $this->from_name,
            'track_opens' => true,
            'track_clicks' => true,
            'auto_text' => true,
            'to'=>[['email' => $this->to_email, 'name' => $this->to_name]],
            'bcc_address'=>'mihai.petrescu@gmail.com',
        ]; 
        $result = $mandrill->messages->send($message);
        if($result[0]['status'] == 'sent') {
            $this->status = 'sent';
        } else {
            $this->tries++;
        }
        $this->save();
    }    
}
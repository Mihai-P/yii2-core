<?php

namespace core\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * ContactSearch represents the model behind the search form about `core\models\Contact`.
 */
class ContactSearch extends Contact
{
    /**
     * @var string search registered from - to for the model
     */    
    var $create_time_from;
    var $create_time_to;    
    /**
     * @var string search keyword for the model
     */    
    var $keyword;
    /**
     * @var string search tag for the model
     */    
    var $tag;

    public function rules()
    {
        return [
            [['id', 'login_attempts', 'update_by', 'create_by'], 'integer'],
            [['keyword', 'create_time_from', 'create_time_to', 'tag', 'type', 'password', 'password_reset_token', 'auth_key', 'name', 'firstname', 'lastname', 'picture', 'email', 'phone', 'mobile', 'validation_key', 'status', 'update_time', 'create_time'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            [
                'create_time_from' => 'Registered From',
                'create_time_to' => 'To',
            ],
            parent::attributeLabels()
        );
    }

    public function search($params)
    {
        $query = Contact::find()->where('User.type = "Contact" AND User.status <> "deleted"');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->session->get(get_parent_class($this) . 'Pagination'),
            ],             
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        if($this->keyword) {
            if(preg_match("/[A-Za-z]+/", $this->keyword) == true) {
                $query->andFilterWhere(['like', 'LOWER(name)', strtolower($this->keyword)]);
            } else {
                $query->andFilterWhere(['id' => $this->keyword]);
            }            
        }
        if($this->create_time_from) {
            $query->andWhere('User.create_time >= :create_time_from', [':create_time_from' => date('Y-m-d 00:00:00', strtotime($this->create_time_from))]);
        }
        if($this->create_time_to) {
            $query->andWhere('User.create_time < :create_time_to', [':create_time_to' => date('Y-m-d 00:00:00', strtotime($this->create_time_to) + 60*60*24)]);
        }

        if($this->tag) {
            $query->join('INNER JOIN', 'Contact_Tag', 'User.id = Contact_Tag.Contact_id')->andWhere('Contact_Tag.Tag_id = :Tag_id AND Contact_Tag.status = "active"', [':Tag_id' => $this->tag]);
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'update_time' => $this->update_time,
            'update_by' => $this->update_by,
            'create_time' => $this->create_time,
            'create_by' => $this->create_by,
            'User.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['like', 'picture', $this->picture])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'mobile', $this->mobile]);

        return $dataProvider;
    }
}

<?php

namespace core\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use core\models\Group;

/**
 * GroupSearch represents the model behind the search form about `core\models\Group`.
 */
class GroupSearch extends Group
{
    /**
     * @var string search keyword for the model
     */    
    var $keyword;

    public function rules()
    {
        return [
            [['keyword', 'name', 'status', 'update_time', 'update_by', 'create_time', 'create_by'], 'safe'],
            [['id'], 'integer'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Group::find()->where('status <> "deleted"');

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
        $query->andFilterWhere([
            'status' => $this->status,
            'id' => $this->id,
            'update_time' => $this->update_time,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'update_by', $this->update_by])
            ->andFilterWhere(['like', 'create_by', $this->create_by]);

        return $dataProvider;
    }
}

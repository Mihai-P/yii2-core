<?php

namespace core\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TagSearch represents the model behind the search form about `core\models\Tag`.
 */
class TagSearch extends Tag
{
    /**
     * @var string search keyword for the model
     */    
    var $keyword;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['keyword', 'name', 'type', 'status', 'update_time', 'create_time'], 'safe'],
            [['id', 'update_by', 'create_by'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * @param array $params the criteria for the search
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Tag::find()->where('status <> "deleted"');

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
            'update_by' => $this->update_by,
            'create_time' => $this->create_time,
            'create_by' => $this->create_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'type', $this->type]);

        return $dataProvider;
    }
}

<?php

namespace core\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * BookmarkSearch represents the model behind the search form about `core\models\Bookmark`.
 */
class BookmarkSearch extends Bookmark
{
    /**
     * @var string search keyword for the model
     */    
    var $keyword;

    public function rules()
    {
        return [
            [['keyword', 'name', 'url', 'reminder', 'status', 'update_time', 'create_time'], 'safe'],
            [['id', 'order', 'update_by', 'create_by'], 'integer'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Bookmark::find()->where('status <> "deleted"');

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
            'reminder' => $this->reminder,
            'order' => $this->order,
            'update_time' => $this->update_time,
            'update_by' => $this->update_by,
            'create_time' => $this->create_time,
            'create_by' => Yii::$app->user->id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'url', $this->url]);

        return $dataProvider;
    }
}

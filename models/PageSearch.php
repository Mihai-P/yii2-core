<?php

namespace core\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use core\models\Page;

/**
 * PageSearch represents the model behind the search form about `core\models\Page`.
 */
class PageSearch extends Page
{
    /**
     * @var string search keyword for the model
     */    
    var $keyword;

    public function rules()
    {
        return [
            [['keyword', 'name', 'url', 'template', 'content', 'status', 'update_time', 'create_time'], 'safe'],
            [['id', 'PageTemplate_id', 'update_by', 'create_by'], 'integer'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Page::find()->where('status <> "deleted"');

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
            'PageTemplate_id' => $this->PageTemplate_id,
            'update_time' => $this->update_time,
            'update_by' => $this->update_by,
            'create_time' => $this->create_time,
            'create_by' => $this->create_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'template', $this->template])
            ->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}

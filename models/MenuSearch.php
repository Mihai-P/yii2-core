<?php

namespace core\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * MenuSearch represents the model behind the search form about `core\models\Menu`.
 */
class MenuSearch extends Menu
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
            [['keyword', 'name', 'internal', 'url', 'rel', 'target', 'ap', 'status', 'update_time', 'create_time'], 'safe'],
            [['id', 'Menu_id', 'order', 'root', 'lft', 'rgt', 'level', 'update_by', 'create_by'], 'integer'],
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
        $query = Menu::find()->where('status <> "deleted"')->orderBy(['root'=>SORT_ASC, 'lft'=>SORT_ASC]);

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
        if($this->Menu_id == -1) {
            $query->andWhere('Menu_id IS NULL');
        } elseif ($this->Menu_id > 0) {
            $query->andFilterWhere([
                'Menu_id' => $this->Menu_id,
            ]);
        }

        $query->andFilterWhere([
            'status' => $this->status,
            'id' => $this->id,
            'order' => $this->order,
            'root' => $this->root,
            'lft' => $this->lft,
            'rgt' => $this->rgt,
            'level' => $this->level,
            'update_time' => $this->update_time,
            'update_by' => $this->update_by,
            'create_time' => $this->create_time,
            'create_by' => $this->create_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'internal', $this->internal])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'rel', $this->rel])
            ->andFilterWhere(['like', 'target', $this->target])
            ->andFilterWhere(['like', 'ap', $this->ap]);

        return $dataProvider;
    }
}

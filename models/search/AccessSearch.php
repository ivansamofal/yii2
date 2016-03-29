<?php

namespace app\models\search;

use app\models\Note;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Access;

/**
 * AccessSearch represents the model behind the search form about `app\models\Access`.
 */
class AccessSearch extends Access
{
    /**
     * @var Note
     */
    public $noteCreator;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'note_id', 'user_id'], 'integer'],
            [['noteCreator'], 'safe'],
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
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Access::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['noteCreator'] = [
            'asc' => ['evrnt_note.creator' => SORT_ASC],
            'desc' => ['evrnt_note.creator' => SORT_DESC],
        ];

        $this->load($params);

        if (!($this->load($params) && $this->validate())) {
            $query->joinWith(['note']);
            return $dataProvider;
        }

        $query->andFilterWhere([
            'evrnt_access.id' => $this->id,
            'evrnt_access.note_id' => $this->note_id,
            'evrnt_access.user_id' => $this->user_id,
        ]);

        $query->joinWith(['noteCreator' => function ($q) {
            $q->where(['evrnt_note.creator' => $this->noteCreator]);
        }]);

        return $dataProvider;
    }
}

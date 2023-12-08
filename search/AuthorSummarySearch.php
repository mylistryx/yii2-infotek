<?php

namespace app\search;

use app\models\Author;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;

class AuthorSummarySearch extends Author
{
    public ?int $yearCounter = null;
    public ?int $year = null;

    public function rules(): array
    {
        return [
            [['year'], 'safe'],
        ];
    }

    public function search(?array $params = null): DataProviderInterface
    {


        $query = static::find()
            ->select('T1.*, count(*) as yearCounter')
            ->from(['T1' => 'author'])
            ->joinWith(['bookAuthors'])
            ->joinWith(['books'])
            ->groupBy('T1.id')
            ->orderBy(['yearCounter' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
        }

        $query->andFilterWhere(['year' => $this->year]);

        return $dataProvider;
    }
}
<?php

namespace app\search;

use app\models\Author;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;

class AuthorSearch extends Author
{
    public function rules(): array
    {
        return [
            [['name', 'surname', 'patronymic'], 'string'],
        ];
    }

    public function search(array $params = []): DataProviderInterface
    {
        $query = static::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
        }

        $query->andFilterWhere(['LIKE', 'name', $this->name]);
        $query->andFilterWhere(['LIKE', 'surname', $this->surname]);
        $query->andFilterWhere(['LIKE', 'patronymic', $this->patronymic]);

        return $dataProvider;
    }

    public function summary(?int $year = null): DataProviderInterface
    {

        $query = static::find()
            ->select('T1.*, count(*) as yearCounter')
            ->from(['T1' => 'author'])
            ->joinWith(['bookAuthors'])
            ->joinWith(['books'])
            ->groupBy('T1.id')
            ->orderBy(['yearCounter' => SORT_DESC]);

        if ($year) {
            $query->where(['book.year' => $year]);
        }

        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }
}
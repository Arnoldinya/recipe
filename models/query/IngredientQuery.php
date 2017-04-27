<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\Ingredient]].
 *
 * @see \app\models\Ingredient
 */
class IngredientQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere([
            'is_active' => 1,
        ]);
    }
}

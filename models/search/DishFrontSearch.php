<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\SqlDataProvider;
use yii\db\Query;
use yii\db\Expression;
use app\models\Dish;

/**
 * DishFrontSearch represents the model behind the search form of `app\models\Dish`.
 */
class DishFrontSearch extends Dish
{
    /** @var array */
    public $f_ingredient_ids;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['f_ingredient_ids'], 'validateIngredient'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateIngredient($attribute, $params)
    {
        if (count($this->$attribute) < 2) {
            $this->addError($attribute, 'Выберите больше ингредиентов.');
        }
        if (count($this->$attribute) >5 ) {
            $this->addError($attribute, 'Выберите не более 5 ингредиентов.');
        }
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
     * @return SqlDataProvider
     */
    public function search($params)
    {
        $this->load($params);

        if (!$this->validate()) {
        	$sql = 'select * from dish where 0=1';
        	$dataProvider = new SqlDataProvider([
	            'sql' => $sql,
	        ]);
            return $dataProvider;
        }

        if($this->f_ingredient_ids)
        {
	        $sql = 'select d.*, count(di.ingredient_id), count(case when di.ingredient_id in ('.implode(', ', $this->f_ingredient_ids).') then 1 else null end)
			from dish d 
			join dish_to_ingredient di on di.dish_id = d.id 
			join ingredient i on di.ingredient_id = i.id 
			group by d.id 
			having count(di.ingredient_id) = count(case when di.ingredient_id in ('.implode(', ', $this->f_ingredient_ids).') then 1 else null end) and count(i.is_active) = '.count($this->f_ingredient_ids);        

	        $dataProvider = new SqlDataProvider([
	            'sql' => $sql,
	        ]);

	        if($dataProvider->totalCount == 0)
	        {
	        	$sql = 'select d.*, count(di.ingredient_id) - count(case when di.ingredient_id in ('.implode(', ', $this->f_ingredient_ids).') then 1 else null end), count(case when i.is_active = 0 then 1 else null end)
					from dish d 
					join dish_to_ingredient di on di.dish_id = d.id
					join ingredient i on di.ingredient_id = i.id 
					group by d.id 
					having count(case when di.ingredient_id in ('.implode(', ', $this->f_ingredient_ids).') then 1 else null end) >= 2 and count(case when i.is_active = 0 then 1 else null end) = 0 
					order by count(di.ingredient_id) - count(case when di.ingredient_id in ('.implode(', ', $this->f_ingredient_ids).') then 1 else null end)';
				$dataProvider = new SqlDataProvider([
		            'sql' => $sql,
		        ]);
	        }

	        return $dataProvider;
    	}
    }
}

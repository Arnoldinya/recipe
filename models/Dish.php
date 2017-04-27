<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "dish".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 *
 * @property DishToIngredient[] $dishToIngredients
 * @property Ingredient[] $ingredients
 */
class Dish extends \yii\db\ActiveRecord
{
    /** @var array */
    private $_new_ingredient_ids = null;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dish';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 255],
            ['ingredient_ids', 'each', 'rule' => ['exist', 'targetAttribute' => 'id', 'targetClass' => Ingredient::className()]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'             => 'ID',
            'title'          => 'Название',
            'description'    => 'Описание',
            'ingredient_ids' => 'Ингредиенты',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDishToIngredients()
    {
        return $this->hasMany(DishToIngredient::className(), ['dish_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIngredients()
    {
        return $this->hasMany(Ingredient::className(), ['id' => 'ingredient_id'])->viaTable('dish_to_ingredient', ['dish_id' => 'id']);
    }

    /**
     * @return array
     */
    public function getIngredient_ids()
    {
        return $this->_new_ingredient_ids;
    }

    /**
     * @param array $value
     * @return array
     */
    public function setIngredient_ids($value)
    {
        $this->_new_ingredient_ids = $value;
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        DishToIngredient::deleteAll(['dish_id' => $this->id]);

        if($this->_new_ingredient_ids)
        {
            $ingredients = array_unique($this->_new_ingredient_ids);

            foreach ($ingredients as $ingredient_id)
            {
                (new DishToIngredient([
                    'ingredient_id' => $ingredient_id,
                    'dish_id'       => $this->id,
                ]))->save();
            }
        }
        
        parent::afterSave($insert, $changedAttributes);
    }
}

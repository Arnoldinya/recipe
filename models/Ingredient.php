<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\query\IngredientQuery;

/**
 * This is the model class for table "ingredient".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $is_active
 *
 * @property DishToIngredient[] $dishToIngredients
 * @property Dish[] $dishes
 */
class Ingredient extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ingredient';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['description'], 'string'],
            [['is_active'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'title'       => 'Название',
            'description' => 'Описание',
            'is_active'   => 'Активность',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDishToIngredients()
    {
        return $this->hasMany(DishToIngredient::className(), ['ingredient_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDishes()
    {
        return $this->hasMany(Dish::className(), ['id' => 'dish_id'])->viaTable('dish_to_ingredient', ['ingredient_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\query\IngredientQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new IngredientQuery(get_called_class());
    }

    /**
    * @return array
    */
    public static function getIngredientList($active = false)
    {
        $query = $active ? self::find()->active()->all() : self::find()->all();
        $ingredients = ArrayHelper::map($query, 'id', 'title');

        ksort($ingredients);

        return $ingredients;
    }
}

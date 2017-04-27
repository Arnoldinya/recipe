<?php

use yii\helpers\Html;
use app\models\Ingredient;

/* @var $this       yii\web\View */
/* @var $ingredient app\models\Ingredient */
?>
<div class="row ingredient-row" data-index="<?= $index ?>" style="margin-top: 5px">
    <div class="col-sm-5">
        <?= Html::dropDownList('Dish[ingredient_ids]['.$index.']', $ingredient->id, 
            Ingredient::getIngredientList(), [
            'class' => 'form-control'
        ]) ?>
    </div>
    <div class="col-sm-1">
        <?=  Html::a(
            'Удалить',
            'javascript:void(0)',
            [
                'title' => 'Удалить',
                'class' => 'delete-ingredient',
                'style' => 'margin-top: 6px; display: inline-block',
            ]
        )?>
    </div>
</div>
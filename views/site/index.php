<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use app\models\Ingredient;
use app\models\Dish;

/* @var $this         yii\web\View */
/* @var $searchModel  app\models\search\DishFrontSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Поиск рецептов';
?>
<div class="site-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <h3>
        Выберите ингредиенты (от 2 до 5)
    </h3>

    <?= Html::beginForm(['site/index'], 'get') ?>

        <div class="form-group">
            <?= Html::dropDownList('DishFrontSearch[f_ingredient_ids][]', $searchModel->f_ingredient_ids, Ingredient::getIngredientList(true), [
                'class' => 'form-control',
                'multiple' => true,
            ]) ?>
        </div>

        <div class="form-group">
            <?= Html::submitButton('Найти', [
                'class' => 'btn btn-success',
            ]) ?>
        </div>

    <?= Html::endForm() ?>

    <?php if (Yii::$app->request->queryParams): ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        //'emptyText' => $searchModel->errors ? false : 'Ничего не найдено.',
        'layout' => $searchModel->errors ? "{errors}" : "{summary}\n{items}\n{pager}",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'title',
                'value'     => function ($data) {
                    return Html::a($data['title'], Url::to(['dish/update', 'id' => $data['id']]));
                },
                'format'   => 'html',
            ],
            'description:ntext',
            [
                'attribute' => 'ingredient_ids',
                'value'     => function ($data) {
                    $model = Dish::findOne($data['id']);
                    return implode(', ', ArrayHelper::map($model->ingredients, 'id', 'title'));
                },
            ],
        ],
    ]) ?>

    <?php endif ?>
</div>

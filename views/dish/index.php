<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

/* @var $this         yii\web\View */
/* @var $searchModel  app\models\search\DishSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Блюда';
$this->params['breadcrumbs'][] = 'Админка';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dish-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'title',
                'value'     => function ($model) {
                    return Html::a($model->title, Url::to(['dish/update', 'id' => $model->id]));
                },
                'format'   => 'html',
            ],
            'description:ntext',
            [
                'attribute' => 'ingredient_ids',
                'value'     => function ($model) {
                    return implode(', ', ArrayHelper::map($model->ingredients, 'id', 'title'));
                },
            ],

            [
                'class'    => 'yii\grid\ActionColumn',
                'template' => '{delete}',
            ],
        ],
    ]) ?>
</div>

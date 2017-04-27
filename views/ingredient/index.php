<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\IngredientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ингредиенты';
$this->params['breadcrumbs'][] = 'Админка';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ingredient-index">

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
                    return Html::a($model->title, Url::to(['ingredient/update', 'id' => $model->id]));
                },
                'format'   => 'html',
            ],
            'description:ntext',
            [
                'attribute' => 'is_active',
                'value'     => function ($model) {
                    return $model->is_active ? 'Да' : 'Нет';
                },
                'filter'    => [
                    0 => 'Нет',
                    1 => 'Да',
                ],
            ],            

            [
                'class'    => 'yii\grid\ActionColumn',
                'template' => '{delete}',
            ],
        ],
    ]); ?>
</div>

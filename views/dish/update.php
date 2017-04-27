<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Dish */

$this->title = 'Редактирование';
$this->params['breadcrumbs'][] = ['label' => 'Блюда', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dish-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

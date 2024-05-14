<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ReturnedBook $model */

$this->title = 'Update Returned Book: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Returned Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="returned-book-update w-50 m-auto">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

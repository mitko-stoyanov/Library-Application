<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Saved $model */

$this->title = 'Редактиране на запазена книга: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Запазени книги', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактиране';
?>
<div class="saved-update w-50 m-auto">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

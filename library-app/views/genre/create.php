<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Genre $model */

$this->title = 'Добави жанр';
$this->params['breadcrumbs'][] = ['label' => 'Жанрове', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="genre-create w-50 m-auto">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

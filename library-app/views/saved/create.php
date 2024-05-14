<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Saved $model */

$this->title = 'Запази книга';
$this->params['breadcrumbs'][] = ['label' => 'Запазени', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="saved-create w-50 m-auto">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

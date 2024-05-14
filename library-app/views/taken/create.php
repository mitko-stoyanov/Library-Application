<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TakenBook $model */

$this->title = 'Create Taken Book';
$this->params['breadcrumbs'][] = ['label' => 'Taken Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="taken-book-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

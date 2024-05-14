<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\User $model */

$this->title = 'Създай Потребител';
$this->params['breadcrumbs'][] = ['label' => 'Потребители', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create w-50 m-auto">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

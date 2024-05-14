<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ReturnedBook $model */

$this->title = 'Връщане на книга';
$this->params['breadcrumbs'][] = ['label' => 'Върнати книги', 'url' => ['index', 'user_id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="returned-book-create w-50 m-auto">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

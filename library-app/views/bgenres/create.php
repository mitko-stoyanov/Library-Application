<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\BookGenres $model */

$this->title = 'Create Book Genres';
$this->params['breadcrumbs'][] = ['label' => 'Book Genres', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-genres-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

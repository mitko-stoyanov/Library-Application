<?php

use app\models\Book;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\TakenBook $model */

$this->title = Book::findOne(['id' => $model->book_id])->title;
$this->params['breadcrumbs'][] = ['label' => 'Взети Книги', 'url' => ['index', 'user_id' => $model->user_id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="taken-book-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактирай', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Изтрий', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Сигурни ли сте, че искате да изтриете тази книга?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'book_id',
            'pick_up_date',
            'count',
            'return_date',
        ],
    ]) ?>

</div>

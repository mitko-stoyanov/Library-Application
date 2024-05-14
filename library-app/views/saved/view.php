<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Book;

/** @var yii\web\View $this */
/** @var app\models\Saved $model */

$this->title = 'ТЕСТ';
$this->params['breadcrumbs'][] = ['label' => 'Запазени книги', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="saved-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактиране', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Изтриване', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Сигурни ли сте, че искате да изтриете тази запазена книга?',
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
            'count',
            'save_date',
        ],
    ]) ?>

</div>

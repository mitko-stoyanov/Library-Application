<?php

use app\models\TakenBook;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\TakenSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Взети Книги';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="taken-book-index">

    <h1><?= Html::encode($this->title) ?></h1>



    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            [
                'attribute' => 'user_id',
                'value' => 'user.full_name'
            ],
            [
                'attribute' => 'book_id',
                'value' => 'book.title'
            ],
            'pick_up_date',
            'return_date',
            'count',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, TakenBook $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
            [
                'header' => 'Админ Панел',
                'class' => ActionColumn::className(),
                'template' => '{process} {edit} {close}', //here will be all posible buttons
                'buttons' => [
                    'process' => function($url, $model, $key) {
                        return Html::a('Върни', ['taken/return', 'book_id' => $model->book_id, 'user_id' => $model->user_id, 'taken_book_id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'method' => 'post',
                            ],
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>


</div>

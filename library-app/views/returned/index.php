<?php

use app\models\Book;
use app\models\ReturnedBook;
use app\models\TakenBook;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ReturnedSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Върнати Книги';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="returned-book-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- <p>
        <?= Html::a('Върни Книга', ['create'], ['class' => 'btn btn-secondary']) ?>
    </p> -->

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'options' => [
            'class' => 'table-responsive'
        ],
        'columns' => [

            'id',
            [
                'attribute' => 'user_id',
                'value' => 'user.full_name'
            ],
            [
                'attribute' => 'taken_book_id',
                'value' => function($model) {
                    $book_id = TakenBook::findOne(['id' => $model->taken_book_id]);
                    return Book::findOne(['id' => $book_id])->title;
                }
            ],
            'count',
            'return_date',
            'pick_up_date',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, ReturnedBook $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
                'visible' => Yii::$app->user->identity->type != 'Читател'
            ],
            // [
            //     'class' => ActionColumn::className(),
            //     'urlCreator' => function ($action, ReturnedBook $model, $key, $index, $column) {
            //         return Url::toRoute([$action, 'id' => $model->id]);
            //     },
            //     'visible' => !Yii::$app->user->identity->type != 'Читател'
            // ],
        ],
    ]); ?>



</div>

<?php

use app\models\Saved;
use Symfony\Component\DomCrawler\Form;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\DataColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\SavedSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Запазени книги';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="saved-index">
    <?php $user_id = $_GET['user_id'] ?>
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Запази книга', ['create'], ['class' => 'btn btn-secondary']) ?>
        <?php if(!Yii::$app->user->identity->type == 'Читател'): ?>
            <?= Html::a('Вземи всички', ['saveall', 'user_id' => $user_id], ['class' => 'btn btn-secondary']) ?>
            <p><?= Yii::$app->user->identity->type ?></p>
        <?php endif; ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'showOnEmpty'=>false,
        // 'filterModel' => $searchModel,
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
            'count',
            'save_date',
            [
                'header' => 'Действия',
                'class' => ActionColumn::className(),
                'template' => '{process} {edit} {close}', //here will be all posible buttons
                'buttons' => [
                    'process' => function($url, $model, $key) {
                        return Html::a('Добави', ['saved/increment', 'saved_id' => $model->id, 'book_id' => $model->book_id], [
                            'class' => 'btn btn-warning',
                            'data' => [
                                'method' => 'post',
                            ],
                        ]);
                    },
                    'edit' => function($url, $model, $key) {
                        return Html::a('Извади', ['saved/decrement', 'saved_id' => $model->id, 'book_id' => $model->book_id], [
                            'class' => 'btn btn-info',
                            'data' => [
                                'method' => 'post',
                            ],
                        ]);
                    },
                    'close' => function ($url, $model, $key) {
                        return Html::a('Изтриване', ['saved/remove', 'saved_id' => $model->id, 'book_id' => $model->book_id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'method' => 'post',
                            ],
                        ]);
                    },
                ],
            ],
            // [
            //     'header' => 'Админ Панел',
            //     'class' => ActionColumn::className(),
            //     'template' => '{take}',
            //     'buttons' => [
            //         'take' => function($url, $model, $key) {
            //             return Html::textInput('qty','', ['class' => 'w-25 ml-3'])
            //             .Html::a('Вземи', ['saved/take', 'book_id' => $model->book_id, 'user_id' => $model->user_id, 'saved_book_id' => $model->id], [
            //                 'class' => 'btn btn-warning',
            //                 'data' => [
            //                     'method' => 'post',
            //                 ],
            //             ]);
            //         },
            //     ],
            // ],

           
            
        ],
    ]); ?>


</div>

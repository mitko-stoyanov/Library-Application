<?php

use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Потребители: ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Създай потребител', ['create'], ['class' => 'btn btn-secondary']) ?>
    </p>

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'options' => [
            'class' => 'table-responsive'
        ],
        'columns' => [
            'id',
            'full_name',
            'phone_number',
            'email:email',
            // 'password',
            'type',
            //'address',
            //'taken_book',
            //'books_to_return',
            'notes:ntext',
            'is_active',
            //'auth_key',
            //'access_token',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, User $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
            [
                'header' => 'Действия',
                'class' => ActionColumn::className(),
                'template' => '{process} {edit} {close}', //here will be all posible buttons
                'buttons' => [
                    'process' => function($url, $model, $key) {
                        return Html::a('Взети', ['/taken', 'user_id' => $model->id], [
                            'class' => 'btn btn-warning',
                            'data' => [
                                'method' => 'post',
                            ],
                        ]);
                    },
                    'edit' => function($url, $model, $key) {
                        return Html::a('Върнати', ['/returned', 'user_id' => $model->id], [
                            'class' => 'btn btn-info',
                            'data' => [
                                'method' => 'post',
                            ],
                        ]);
                    },
                    'close' => function ($url, $model, $key) {
                        return Html::a('Запазени', ['/saved', 'user_id' => $model->id], [
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

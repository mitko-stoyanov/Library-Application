<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\User $model */

$this->title = $model->full_name;
$this->params['breadcrumbs'][] = ['label' => 'Потребители', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактиране', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Изтриване', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <!-- TODO: ако трябва и паролата да се вижда добавяме -> 'password', -->
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'full_name',
            'phone_number',
            'email:email',
            'type',
            'address',
            // 'taken_book',
            // 'books_to_return',
            'notes:ntext',
            'is_active',
            // 'auth_key',
            // 'access_token',
        ],
    ]) ?>

</div>

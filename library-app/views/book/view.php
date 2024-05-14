<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Book $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Книги', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="book-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if(!Yii::$app->user->isGuest && Yii::$app->user->identity->type != 'Читател'): ?>
    <p>
        <?= Html::a('Редактиране', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Изтриване', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Наистина ли искаш да изтриеш тази книга?',
                    'method' => 'post',
                ],
            ]) ?>

    </p>
    <?php endif; ?>
    <?php if($model->available_count > 0 && $model->available_count <= $model->total_count): ?>
        <form action="<?=yii\helpers\Url::to(['saved', 'book_id' => $model->id])?>" method="post" d="saved-form"
            class="d-flex justify-content-start align-items-center mt-3 mb-3">
            <div class="mr-4">
                <input type="text" name="qty" id="book-qty" placeholder="Брой...">
            </div>
            <div>
                <button class="btn btn-secondary">Запази</button>
            </div>
        </form>
    <?php endif; ?>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'isbn',
            'title',
            'authors',
            [
                'attribute' => 'Наличност',
                'value' => function($model) {
                    if($model->available_count > 0 && $model->available_count <= $model->total_count) {
                        return 'Налична. Наличен брой: ' . $model->available_count;
                    } else {
                        return 'Не е налична.';
                    }
                }
            ],
            'annotation:ntext',
            'year',
            'genre_id',
            'total_count',
            'available_count',
            // 'cover_images:ntext',
            [
                'attribute'=>'cover_image',
                'value'=> function ($model) {
                   $html = ''; 

                   if($model->cover_images) {
                        $images = explode(', ', $model->cover_images);
                        if(count($images) > 1){
                            array_pop($images);
                        }
                        foreach ($images as $img) { 
                            $html .= Html::img($img, ['width' => '200px', 'height' => '300px', 'style' => ['margin-left' => '25px']]);
                        } 

                        return $html; 
                    } 
                },
                'format' => 'raw',
            ],
            
        ],
    ]) ?>

</div>
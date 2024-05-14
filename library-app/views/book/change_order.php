<?php

use app\models\Book;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ListView;
use app\assets\AppAsset;

/** @var yii\web\View $this */
/** @var app\models\BookSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

AppAsset::register($this);



$this->title = 'Промяна на подредбата -> ' . $model->title;
$this->params['breadcrumbs'][] = $this->title;
?>



<div class="book-change">

    <h2 class="mb-5"><?= Html::encode($this->title) ?></h2>


    <div class="container">
        <div class="row">
            
            <?php if(is_array($model->getAllImages())): ?>
                <?php foreach($model->getAllImages() as $image): ?> 
                    <div class="card border-0 text-center" style="max-width: 25rem; height: 100%; margin-right: 20px">
                        <?php if($model->getAllImages()[0] == $image): ?>
                            <span class="mb-3">ПРЕДНА КОРИЦА</span>
                        <?php else: ?>
                            <span class="mb-3">ЗАДНА КОРИЦА/СТРАНИЦА</span>
                        <?php endif; ?>
                        <img class="card-img-top" src="<?= $image ?>" alt="Card image cap">
                        <div class="card-body d-flex justify-content-center gap-2">
                            <?php if($model->getAllImages()[0] != $image): ?>
                                <a href=<?= Url::to(['book/left', 'image_path' => $image, 'book_id' => $model->id])?>
                                    class="btn btn-warning">&#8592;</a>
                            <?php else: ?>
                                <a href=<?= Url::to(['book/left', 'image_path' => $image, 'book_id' => $model->id])?>
                                    class="btn btn-warning disabled">&#8592;</a>
                            <?php endif; ?>
                            <a href=<?= Url::to(['book/remove', 'image_path' => $image, 'book_id' => $model->id])?>
                                class="btn btn-danger">&#x2715;</a>
                            <?php 
                                $images = $model->getAllImages();
                                if(end($images) != $image): ?>
                                <a href=<?= Url::to(['book/right', 'image_path' => $image, 'book_id' => $model->id])?>
                                class="btn btn-warning">&#8594;</a>
                            <?php else: ?>
                                <a href=<?= Url::to(['book/right', 'image_path' => $image, 'book_id' => $model->id])?>
                                class="btn btn-warning disabled">&#8594;</a>
                            <?php endif; ?>
                            
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-danger"><b>---- Тази книга няма добавена корица и не може да се размества редът ----</b></p>
            <?php endif; ?>
        </div>
    </div>
</div>

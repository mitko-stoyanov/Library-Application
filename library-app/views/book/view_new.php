<?php

use app\models\BookGenres;
use app\models\Genre;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Book $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Книги', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
</script>

<div class="book-view">

    <h1 class="mb-5 mt-5"><?= Html::encode($this->title) ?></h1>
    <div class="container">
        <div class="row">
            <div class="col-lg mb-5">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">

                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                                <img class="d-block w-100 h-100" src=<?= $model->getCoverImage() ?> alt="Second slide">
                            </div>
                        <?php foreach($model->getCoverImages() as $image): ?>
                            <div class="carousel-item">
                                <img class="d-block w-100 h-100" src=<?= $image ?> alt="Second slide">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <div class="col-lg mb-5">
                <table class="table table-striped">
                    <tbody>
                        <?php if(Yii::$app->user->identity): ?>
                            <?php if(Yii::$app->user->identity->type != 'Читател'): ?>
                                <tr>
                                    <th scope="row">ИД</th>
                                    <td><?= $model->id ?></td>
                                </tr>
                            <?php endif; ?>
                        <?php endif; ?>
                        <tr>
                            <th scope="row">ISBN</th>
                            <td><?= $model->isbn ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Заглавие</th>
                            <td><?= $model->title ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Автори</th>
                            <td><?= $model->authors ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Година</th>
                            <td><?= $model->year ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Жанр</th>
                            <td><?= $genres ?></td>
                            <?php 
                                $genres = BookGenres::findAll(['book_id' => $model->id]);
                                echo $model->genres
                            ?>
                        </tr>
                        <?php if(Yii::$app->user->identity): ?>
                            <?php if(Yii::$app->user->identity->type != 'Читател'): ?>
                                <tr>
                                    <th scope="row">Обща наличност</th>
                                    <td><?= $model->total_count ?></td>
                                </tr>
                            <?php endif; ?>
                        <?php endif; ?>
                        <tr>
                            <th scope="row">Налични вмомента</th>
                            <td><?= $model->available_count ?></td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-center">
                    <h4 class="mb-4">Анотация</h4>
                    <p class="text-justify"><?= $model-> annotation ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-around align-items-center mt-3">
        <!-- <a class="btn btn-info w-25">Редактиране</button>
        <a class="btn btn-info w-25">Изтриване</button> -->
        <?php if(Yii::$app->user->identity): ?>
            <?php if(Yii::$app->user->identity->type != 'Читател'): ?>
                <?= Html::a('Редактиране', ['update', 'id' => $model->id], ['class' => 'btn btn-info view-book-button']) ?>
                <?= Html::a('Промяна на подредбата', ['/book/change', 'book_id' => $model->id], ['class' => 'btn btn-info view-book-button']) ?>
                <?= Html::a('Изтриване', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger view-book-button',
                        'data' => [
                            'confirm' => 'Наистина ли искаш да изтриеш тази книга?',
                            'method' => 'post',
                        ],
                    ]) ?>
            <?php endif; ?>
            <form id="my-form" action="<?=yii\helpers\Url::to(['saved', 'book_id' => $model->id])?>" method="post" d="saved-form"
                class="d-flex justify-content-center align-items-center view-book-button">
                <input type="text" name="qty" id="book-qty" class="form-control" placeholder="Брой...">
                <button class="btn btn-info">Запази</button>
            </form>
        <?php endif; ?>
    </div>
</div>
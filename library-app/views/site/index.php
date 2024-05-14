<?php

/** @var yii\web\View $this */

$this->title = 'Начало';

?>
<div class="site-index">
    

    <div class="jumbotron text-center bg-transparent title">
        <h1>Библиотека</h1>
        <p class="lead">Книги, обединяващи хората.</p>
    </div>

    <div class="body-content">
        <div class="banner">
            <img class="w-100" src="https://timelinecovers.pro/facebook-cover/download/library-facebook-cover.jpg"
                alt="library-image">
        </div>
        <br>
        <h2 class="text-center mb-5">Нови книги:</h2>

        <div class="container">
            <div class="row">
                <?php foreach($last_books as $book): ?>
                    <div class="col-sm mb-5">
                        <div class="card" style="height: 100%">
                            <img class="card-img-top" src="<?= $book->getCoverImage() ?>" alt="Card image cap">
                            <div class="card-body index-book">
                                <h5 class="card-title"><?= $book->title ?></h5>
                                <p class="card-text"><?php echo \yii\helpers\StringHelper::truncateWords($book->annotation, 25) ?></p>
                                <a href="<?php echo \yii\helpers\Url::to(['book/view', 'id' => $book->id]) ?>" class="btn btn-secondary stretched-link d-flex justify-content-center">Виж повече</a>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">Автор: <?= $book->authors ?></small>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>




</div>
</div>
<?php
/** @var $model \app\models\Books */
use PharIo\Manifest\Library;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\Saved;
?>

<div class="container d-flex justify-content-center mt-3 book-container" style="height: 100%">
    <div class="card mb-5" id="book-card">
        <img class="card-img-top" src=<?php echo $model->getCoverImage() ?> alt="Card image" style="width:100%">
        <div class="card-body">
            <h4 class="card-title mb-0"><?php echo $model->title ?></h4>
            <span class="author-span"><?= $model->authors ?></span>
            <p class="card-text mt-3">
                <?php echo \yii\helpers\StringHelper::truncateWords(\yii\helpers\Html::encode($model->annotation), 20)  ?>
            </p>

            <p>Оставащ брой: <?php echo $model->available_count ?></p>

            <div class="book-actions d-flex justify-content-between align-items-center">
                <a href="<?php echo \yii\helpers\Url::to(['view', 'id' => $model->id]) ?>" class="btn btn-secondary see-more">Виж
                    повече</a>
                <form action="<?=yii\helpers\Url::to(['saved', 'book_id' => $model->id])?>" method="post" d="saved-form" class="d-flex justify-content-end align-items-center">
                    <input class="form-control book-index" type="text" name="qty" id="book-qty" placeholder="Брой...">
                    <button class="btn btn-secondary save-book-buton">Запази</button>
                </form>
            </div>
        </div>
    </div>
</div>
<br>
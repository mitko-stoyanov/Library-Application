<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\BookSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="book-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <!-- <form>
        <div class="row align-items-center justify-content-center mb-4 mt-4">
            <?= $form->field($model, 'globalSearch')->textInput(['placeholder' => "Търсене по заглавие, година, автор, жанр и ISBN..."])
                                            ->label(false) ?>
            <?= Html::submitButton('dsadasd', ['class' => 'btn btn-primary']) ?>
        </div>
    </form> -->

    <form>
        <div class="row text-center mb-4 mt-4">
            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
            <div class="col-10">
                <?= $form->field($model, 'globalSearch')->textInput(['placeholder' => "Търсене по заглавие, година, автор и ISBN..."])
                                            ->label(false) ?>
            </div>
            <div class="col-2">
                <?= Html::submitButton('🔍', ['class' => 'btn btn-info w-75']) ?>
            </div>
        </div>
    </form>


    <!-- <?= $form->field($model, 'id') ?> -->

    <!-- <?= $form->field($model, 'isbn') ?> -->

    <!-- <?= $form->field($model, 'authors') ?> -->

    <!-- <?= $form->field($model, 'annotation') ?> -->

    <?php // echo $form->field($model, 'year') ?>

    <?php // echo $form->field($model, 'genre_id') ?>

    <?php // echo $form->field($model, 'total_count') ?>

    <?php // echo $form->field($model, 'available_count') ?>

    <?php // echo $form->field($model, 'cover_images') ?>

    <?php ActiveForm::end(); ?>

</div>
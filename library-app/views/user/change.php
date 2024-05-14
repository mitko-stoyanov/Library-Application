<?php

use yii\helpers\Html;;
use yii\bootstrap5\ActiveForm;
?>

<div class="user-form w-50 m-auto">
    <h1 class="mb-5">Промяна на парола</h1>
    <?php $form = ActiveForm::begin(); ?>
    <form action="<?=yii\helpers\Url::to(['saved', 'book_id' => $model->id])?>" method="post" id="saved-form" class="mt-3 w-50">
        <label for="qty" class="form-label">Текуща Парола:</label>
        <input type="password" name="old-pass" id="book-qty" class="form-control">
        <br>
        <label for="qty" class="form-label">Нова парола:</label>
        <input type="password" name="new-pass" id="book-qty" class="form-control">
        <br>
        <label for="qty" class="form-label">Повтори парола:</label>
        <input type="password" name="new-pass-confirm" id="book-qty" class="form-control">
        <br>
        <div class="form-group text-center">
            <button class="mt-2 btn btn-info w-50">Промени</button>
        </div>
    </form>

    <?php ActiveForm::end(); ?>
</div>
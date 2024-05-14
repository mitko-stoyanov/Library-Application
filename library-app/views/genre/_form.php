<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Genre $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="genre-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Име*') ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6])->label('Описание*') ?>

    <div class="form-group text-center">
        <?= Html::submitButton('Добави', ['class' => 'btn btn-info mt-3 w-50']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <div class="form-group text-center mt-3">
        <span class="text-danger w-100">Всички полета отбелязани със * са задължителни!</span>
    </div>
</div>
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-form w-50 m-auto">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'old_password')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'new_password')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'repeat_password')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Смени парола', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
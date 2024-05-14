<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'full_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
    <!-- <?php if(!Yii::$app->user->isGuest && Yii::$app->user->identity->type != 'Читател'): ?> -->
        <!-- <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?> -->
        <!-- <?= $form->field($model, 'taken_book')->textInput(['maxlength' => true]) ?> -->
        <!-- <?= $form->field($model, 'books_to_return')->textInput(['maxlength' => true]) ?> -->
        <?= $form->field($model, 'notes')->textarea(['rows' => 6]) ?>
        <?= $form->field($model, 'is_active')->textInput() ?>
        <!-- <?= $form->field($model, 'auth_key')->textInput(['maxlength' => true]) ?> -->
        <!-- <?= $form->field($model, 'access_token')->textInput(['maxlength' => true]) ?> -->
    <!-- <?php endif; ?> -->

    <?php if(!Yii::$app->user->isGuest && Yii::$app->user->identity->type == 'Администратор'): ?>
        <?= $form->field($model, 'type')->dropDownList([ 'Читател' => 'Читател', 'Библиотекар' => 'Библиотекар', 'Администратор' => 'Администратор', ], ['prompt' => '']) ?>
    <?php endif; ?>



    <div class="form-group text-center">
        <?= Html::submitButton('Запази', ['class' => 'btn btn-info mt-3 w-50']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\SignupForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login w-50 m-auto">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'signup-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
            'inputOptions' => ['class' => 'col-lg-3 form-control'],
            'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
        ],
    ]); ?>

    <?= $form->field($model, 'email')->textInput(['autofocus' => true])->label('Имейл*') ?>
    <?= $form->field($model, 'full_name')->textInput()->label('Пълно име*', ['class'=>'col-form-label mr-lg-3']) ?>
    <?= $form->field($model, 'phone_number')->textInput()->label('Телефонен номер*', ['class'=>'col-form-label mr-lg-3']) ?>
    <?= $form->field($model, 'password')->passwordInput()->label('Парола*') ?>
    <?= $form->field($model, 'password_repeat')->passwordInput()->label('Повтори парола*', ['class'=>'col-form-label mr-lg-3']) ?>



    <div class="form-group text-center">
        <?= Html::submitButton('Регистрация', ['class' => 'btn btn-info mt-3 w-50', 'name' => 'login-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <div class="form-group text-center mt-3">
        <span class="text-danger w-100">Всички полета отбелязани със * са задължителни!</span>
    </div>
</div>
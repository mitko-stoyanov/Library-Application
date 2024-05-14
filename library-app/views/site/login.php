<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Влизане';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login w-50 m-auto">
    <h1><?= Html::encode($this->title) ?></h1>


    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
            'inputOptions' => ['class' => 'col-lg-3 form-control'],
            'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
        ],
    ]); ?>

    <?= $form->field($model, 'email')->textInput(['autofocus' => true])->label('Имейл*') ?>

    <?= $form->field($model, 'password')->passwordInput()->label('Парола*') ?>

    <!-- <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "<div class=\"offset-lg-1 col-lg-3 custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
        ]) ?> -->

    <div class="form-group text-center">
        <?= Html::submitButton('Влизане', ['class' => 'btn btn-info mt-3 w-50', 'name' => 'login-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <div class="form-group text-center mt-3">
        <span class="text-danger w-100">Всички полета отбелязани със * са задължителни!</span>
    </div>
</div>
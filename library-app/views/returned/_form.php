<?php

use app\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ReturnedBook $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="returned-book-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- <?= $form->field($model, 'user_id')->textInput(['maxlength' => true]) ?> -->
    <?= $form->field($model, 'user_id')->dropDownList(
        ArrayHelper::map(User::find()->all(), 'id', 'full_name'),
        [
            'prompt' => 'Избери Потребител',
            // 'multiple' => 'multiple'
        ]
    ) ?>

    <?= $form->field($model, 'taken_book_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'count')->textInput() ?>

    <!-- <?= $form->field($model, 'return_date')->textInput() ?> -->

    <!-- <?= $form->field($model, 'pick_up_date')->textInput() ?> -->

    <div class="form-group text-center">
        <?= Html::submitButton('Запази', ['class' => 'btn btn-success mt-3 w-50']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

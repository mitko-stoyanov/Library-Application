<?php

use app\models\Book;
use app\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Saved $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="saved-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->dropDownList(
        ArrayHelper::map(User::find()->all(), 'id', 'full_name'),
        ['prompt' => 'Избери Потребител']
    ) ?>

    <?= $form->field($model, 'book_id')->dropDownList(
        ArrayHelper::map(Book::find()->all(), 'id', 'title'),
        ['prompt' => 'Избери Книга']
    ) ?>

    <?= $form->field($model, 'count')->textInput() ?>

    <!-- <?= $form->field($model, 'save_date')->textInput() ?> -->

    <div class="form-group text-center">
        <?= Html::submitButton('Запази', ['class' => 'btn btn-success mt-3 w-50']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

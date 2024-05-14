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

<div class="saved-form w-50 m-auto">

    <h1>Смени потребител</h1>
    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'user_id')->dropDownList(
            ArrayHelper::map(User::find()->all(), 'id', 'full_name'),
            ['prompt' => 'Избери Потребител']
        ) ?>

        <!-- <?= $form->field($model, 'books[]')->dropDownList(
            ArrayHelper::map(Book::find()->all(), 'id', 'title'),
            ['prompt' => 'Избери Книга',
            'multiple' => 'multiple']
        )->label('Избери книга') ?> -->

        <!-- <?= $form->field($model, 'count')->textInput() ?> -->

        <!-- <?= $form->field($model, 'save_date')->textInput() ?> -->

        <div class="form-group text-center">
            <?= Html::submitButton('Смени', ['class' => 'btn btn-info mt-3 w-50']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
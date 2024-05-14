<?php

use app\models\Genre;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Book $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="book-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    
    <?= $form->field($model, 'isbn')->textInput(['maxlength' => true])->label('ISBN*') ?>
    
    <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label('Заглавие*') ?>
    
    <?= $form->field($model, 'authors')->textInput(['maxlength' => true])->label('Автори*') ?>

    <?= $form->field($model, 'annotation')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'year')->textInput(['maxlength' => true])->label('Година*') ?>
    
    <?= $form->field($model, 'total_count')->textInput()->label('Общо бройки*') ?>
    
    <?= $form->field($model, 'available_count')->textInput()->label('Налични бройки*') ?>
    
    <?= $form->field($model, 'genres')->dropDownList(ArrayHelper::map(Genre::find()->all(), 'id', 'name'), ['multiple'=>'multiple']
        )->label("Добави категория*");
        ?>

<?= $form->field($model, 'files[]', ['options' => ['class' => 'mt-3']])->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>

<!-- <?= $form->field($model, 'cover_images')->textarea(['rows' => 6]) ?> -->
<div class="form-group text-center">
    <?= Html::submitButton('Създай', ['class' => 'btn btn-info mt-3 w-50']) ?>
</div>

<?php ActiveForm::end(); ?>
<div class="form-group text-center mt-3">
    <span class="text-danger w-100">Всички полета отбелязани със * са задължителни!</span>
</div>
</div>
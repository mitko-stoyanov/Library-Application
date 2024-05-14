<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\GenreSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="genre-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <form>
        <div class="row text-center mb-4 mt-4">
            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
            <div class="col-10">
                <?= $form->field($model, 'globalSearch')->textInput(['placeholder' => "Търсене по име и описание..."])
                                            ->label(false)?>
            </div>
            <div class="col-2">
                <?= Html::submitButton('🔍', ['class' => 'btn btn-info w-75']) ?>
            </div>
        </div>
    </form>

    <?php ActiveForm::end(); ?>

</div>
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
    
    <h1>Вземи книга</h1>
    <?= $form->field($model, 'user_id')->dropDownList(
        ArrayHelper::map(User::find()->all(), 'id', 'full_name'),
        ['prompt' => 'Избери Потребител']
    ) ?>

    </br>

    <table class="table table-striped">
        <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Заглавие</th>
                <th scope="col">Автори</th>
                <th scope="col">Handle</th>
                </tr>
        </thead>
        <tbody>
            <?php foreach($books as $book): ?>
                <tr>
                <th scope="row"><?= $book->id ?></th>
                <td><?= $book->title ?></td>
                <td><?= $book->authors ?></td>
                <?= $form->field($model, 'check')->checkbox()->label('Hi'); ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
            
        </table>
    <?php ActiveForm::end(); ?>

</div>
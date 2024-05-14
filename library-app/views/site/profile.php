<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Профил';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>


    <h2 class="mt-5">Информация:</h2>
    <br>
    <div class="container">
        <table class="table table-striped">
            <tbody>
                <tr>
                    <th scope="row">ID</th>
                    <td><?= Yii::$app->user->identity->id ?></td>
                </tr>
                <tr>
                    <th scope="row">Име</th>
                    <td><?= Yii::$app->user->identity->full_name ?></td>
                </tr>
                <tr>
                    <th scope="row">Тел.номер</th>
                    <td><?= Yii::$app->user->identity->phone_number ?></td>
                </tr>
                <tr>
                    <th scope="row">Имейл</th>
                    <td><?= Yii::$app->user->identity->email ?></td>
                </tr>
                <tr>
                    <th scope="row">Тип потребител</th>
                    <td><?= Yii::$app->user->identity->type ?></td>
                </tr>
                <tr>
                    <th scope="row">Адрес</th>
                    <td>
                        <?php if (!Yii::$app->user->identity->address == null && !Yii::$app->user->identity->address == '') { ?>
                        <?= Yii::$app->user->identity->address ?>
                        <?php } else { ?>
                        Не е предоставен адрес
                        <?php } ?>
                    </td>
                </tr>
            </tbody>

        </table>


    </div>

    <div class="buttons text-center mt-5">
        <?php if(!Yii::$app->user->isGuest && Yii::$app->user->identity->type != 'Читател'): ?>
            <?= Html::a('Смени потребител', ['/saved/add'], ['class' => 'btn btn-secondary']) ?>
            <?= Html::a('Просрочено Връщане', ['site/delayed'], ['class' => 'btn btn-secondary']) ?>
        <?php endif; ?>
        <?= Html::a('Редактиране на профил', ['user/update', 'id' => Yii::$app->user->id], ['class' => 'btn btn-secondary']) ?>
        <?= Html::a('Смяна на парола', ['user/change', 'id' => Yii::$app->user->id], ['class' => 'btn btn-secondary']) ?>
    </div>
    
</div>
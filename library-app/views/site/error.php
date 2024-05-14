<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception$exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>
    <!-- <h1><?= $_GET['message'] ?></h1> -->
    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        Грешката се появи, докато се опитвахме да обработим заявката ви.
    </p>
    <p>
        Ако мислите, че е грешка ни пишете на имейл <b><u>test-email@gmail.com</u></b>
    </p>

</div>

<?php

use app\models\Book;
use app\models\Genre;
use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var app\models\BookSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */





$this->title = 'Книги';
$this->params['breadcrumbs'][] = $this->title;
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<div class="book-index">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <!-- <p>
        <?= Html::a('Create Book', ['create'], ['class' => 'btn btn-success']) ?>
    </p> -->

    <div class="jumbotron text-center bg-transparent title">
        <h1><?= Html::encode($this->title) ?></h1>
        <p class="lead">Книги, обединяващи хората.</p>
    </div>
    <?php if(!Yii::$app->user->isGuest && Yii::$app->user->identity->type != 'Читател'): ?>
    <div class="btn-create text-center">
        <p>
            <?= Html::a('Добави книга', ['book/create'], ['class' => 'btn btn-secondary']) ?>
            <?= Html::a('Добави жанр', ['genre/create'], ['class' => 'btn btn-secondary']) ?>
    </div>
    <?php endif; ?>

    <p class="mt-5 text-center">Филтрирай по жанр:</p>
    <form id="form" action="<?=yii\helpers\Url::to(['index'])?>" method="post"
        class="d-flex justify-content-center g-form mb-5">
        <select class="selectpicker select-genre w-25" name="genres[]" title="Моля изберете жанр" id="inscompSelected" multiple data-live-search="true">
            <?php foreach(Genre::find()->all() as $genre): ?>
            <option class="test" value=<?= $genre->id ?>><?= $genre->name ?></option>
            <?php endforeach; ?>
        </select>
        <input class="see-btn" type="submit" value="Виж">
    </form>
    </p>

    <?php echo $this->render('_search', ['model' => $searchModel]);  ?>
    <?php $session = Yii::$app->session; ?>
    <?php if($session['user_id']): ?>
    <div class="cur-user d-flex justify-content-center align-items-center">
        <p class="mb-0">Настоящ потребител: <b><?= User::findOne(['id' => $session['user_id']])->full_name ?></b> (ИД:
            <?= $session['user_id']?>)</p>
        <form id="form" action="<?=yii\helpers\Url::to(['saved/delusr'])?>" method="post">
            <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
            <input type="submit" value="Премахни" class="form-control remove-btn-usr">
        </form>
    </div>
    <?php endif; ?>
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_book_item',
        'options' => [
            'tag' => 'div',
            'class' => 'row',
        ],
        'itemOptions' => [
            'tag' => 'div',
            'class' => 'col-lg-4 col-sm-6',
        ]
        
    ]); ?>


</div>
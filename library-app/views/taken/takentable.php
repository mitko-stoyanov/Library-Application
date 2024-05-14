<?php

use app\models\Book;
use app\models\Saved;
use app\models\TakenBook;
use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\TakenSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Взети Книги';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="taken-book-index">
    <?php $user_id = $_GET['user_id'] ?>
    <h1><?= Html::encode($this->title) ?></h1>

    <!-- <p>
        <?= Html::a('Вземи Книга', ['create'], ['class' => 'btn btn-secondary']) ?>
    </p> -->

    <?php if($taken_books): ?>
        <div class="table-responsive-md">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">ИД</th>
                        <th scope="col">Потребител</th>
                        <th scope="col">Книга</th>
                        <th scope="col">Брой</th>
                        <th scope="col">Дата на запазване</th>
                        <th scope="col">Дата на връщане</th>
                        <?php if(Yii::$app->user->identity->type != 'Читател'): ?>
                            <th scope="col">Връщане</th>
                            <th scope="col">Админ Панел</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($taken_books as $book): ?>
                        <?php if( time() >= strtotime($book->return_date)): ?>
                            <tr class="bg-danger">
                                <th scope="row"><?= $book->id ?></th>
                                <td><?= User::findOne(['id' => $user_id])->full_name ?></td>
                                <td><?= Book::findOne(['id' => $book->book_id])->title ?></td>
                                <td><?= $book->count ?></td>
                                <td><?= $book->pick_up_date ?></td>
                                <td><?= $book->return_date ?></td>
                                <?php if(Yii::$app->user->identity->type != 'Читател'): ?>
                                    <td>
                                        <form
                                            action="<?=yii\helpers\Url::to(['taken/return', 'book_id' => $book->book_id, 'user_id' => (new Saved)->checkUser(), 'taken_book_id' => $book->id])?>"
                                            method="post" d="saved-form">
                                            <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>"
                                                value="<?= Yii::$app->request->csrfToken; ?>" />
                                            <input type="text" name="qty" id="book-qty" class="w-50" placeholder="Брой...">
                                            <button class="btn btn-secondary">Върни</button>
                                        </form>
                                    </td>
                                    <td>
                                        <a href=<?= Url::to(['taken/view', 'id' => $book->id])?>>&#128065;</a>
                                        <a href=<?= Url::to(['taken/update', 'id' => $book->id])?>>&#128221;</a>
                                        <!-- <a href=<?= Url::to(['saved/remove', 'saved_id' => $book->id, 'book_id' => $book->book_id])?>>&#10060;</a> -->

                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php else: ?>
                            <tr>
                                <th scope="row"><?= $book->id ?></th>
                                <td><?= User::findOne(['id' => $user_id])->full_name ?></td>
                                <td><?= Book::findOne(['id' => $book->book_id])->title ?></td>
                                <td><?= $book->count ?></td>
                                <td><?= $book->pick_up_date ?></td>
                                <td><?= $book->return_date ?></td>
                                <?php if(Yii::$app->user->identity->type != 'Читател'): ?>
                                    <td>
                                        <form
                                            action="<?=yii\helpers\Url::to(['taken/return', 'book_id' => $book->book_id, 'user_id' => (new Saved)->checkUser(), 'taken_book_id' => $book->id])?>"
                                            method="post" d="saved-form">
                                            <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>"
                                                value="<?= Yii::$app->request->csrfToken; ?>" />
                                            <input type="text" name="qty" id="book-qty" class="w-50" placeholder="Брой...">
                                            <button class="btn btn-secondary">Върни</button>
                                        </form>
                                    </td>
                                    <td>
                                        <a href=<?= Url::to(['taken/view', 'id' => $book->id])?>>&#128065;</a>
                                        <a href=<?= Url::to(['taken/update', 'id' => $book->id])?>>&#128221;</a>
                                        <!-- <a href=<?= Url::to(['saved/remove', 'saved_id' => $book->id, 'book_id' => $book->book_id])?>>&#10060;</a> -->

                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <h3>---- Няма взети книги. ----</h3>
    <?php endif; ?>



</div>
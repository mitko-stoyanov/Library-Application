<?php

use app\models\Book;
use app\models\Saved;
use app\models\User;
use Symfony\Component\DomCrawler\Form;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\DataColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\SavedSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Запазени книги';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="saved-index">
    <?php $user_id = $_GET['user_id'] ?>
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <!-- <?= Html::a('Запази книга', ['create'], ['class' => 'btn btn-secondary']) ?> -->
        <?php if(!Yii::$app->user->identity->type == 'Читател'): ?>
            <?php if($saved_books): ?>
                <?= Html::a('Вземи всички', ['saveall', 'user_id' => (new Saved)->checkUser()], ['class' => 'btn btn-secondary']) ?>
            <?php endif; ?>
        <?php endif; ?>

        <?php if(!$saved_books): ?>
            <h3>---- Няма запазени книги. ----</h3>
        <?php endif; ?> 
    </p>
    <?php if($saved_books): ?>
        <div class="table-responsive-md">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">ИД</th>
                        <th scope="col">Потребител</th>
                        <th scope="col">Книга</th>
                        <th scope="col">Брой</th>
                        <th scope="col">Дата на запазване</th>
                        <th scope="col">Действия</th>
                            <?php if(Yii::$app->user->identity->type != 'Читател'): ?>
                                <th scope="col">Вземане</th>
                            <th scope="col">Админ Панел</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($saved_books as $book): ?>
                    <tr>
                        <th scope="row"><?= $book->id ?></th>
                        <td><?= User::findOne(['id' => $user_id])->full_name ?></td>
                        <td><?= Book::findOne(['id' => $book->book_id])->title ?></td>
                        <td><?= $book->count ?></td>
                        <td><?= $book->save_date ?></td>
                            <td>
                            <a href=<?= Url::to(['saved/increment', 'saved_id' => $book->id, 'book_id' => $book->book_id])?>
                                class="btn btn-warning">&#10133;</a>
                            <a href=<?= Url::to(['saved/decrement', 'saved_id' => $book->id, 'book_id' => $book->book_id])?>
                                class="btn btn-info">&#10134;</a>
                            <a href=<?= Url::to(['saved/remove', 'saved_id' => $book->id, 'book_id' => $book->book_id])?>
                                class="btn btn-danger">&#x2715;</a>
                        </td>
                        <?php if(Yii::$app->user->identity->type != 'Читател'): ?>
                            <td>
                                <form
                                    action="<?=yii\helpers\Url::to(['saved/take', 'book_id' => $book->book_id, 'user_id' => (new Saved)->checkUser(), 'saved_book_id' => $book->id])?>"
                                    method="post" d="saved-form">
                                    <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>"
                                        value="<?= Yii::$app->request->csrfToken; ?>" />
                                    <input type="text" name="qty" id="book-qty" class="w-50" placeholder="Брой...">
                                    <button class="btn btn-secondary">Вземи</button>
                                </form>
                            </td>
                            <td>
                                <a href=<?= Url::to(['saved/view', 'id' => $book->id])?>>&#128065;</a>
                                <a href=<?= Url::to(['saved/update', 'id' => $book->id])?>>&#128221;</a>
                                <!-- <a href=<?= Url::to(['saved/remove', 'saved_id' => $book->id, 'book_id' => $book->book_id])?>>&#10060;</a> -->

                            </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>


</div>
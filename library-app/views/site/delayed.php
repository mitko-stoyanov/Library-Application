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

$this->title = 'Просрочено връщане';
$this->params['breadcrumbs'][] = $this->title;

?>
<script src="https://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script>

<div class="saved-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if($delayed_books): ?>
        
            <table class="table table-striped sortable" id="delayed-table">
                <thead>
                    <tr>
                        <th scope="col" class="head-table">Потребител</th>
                        <th scope="col" class="head-table">Книга</th>
                        <th scope="col" class="head-table">Брой</th>
                        <th scope="col" class="head-table">Дата на взимане</th>
                        <th scope="col" class="head-table">Дата на Връщане</th>
                        <th scope="col" class="head-table">Просрочено с</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($delayed_books as $book): ?>
                        <tr>
                            <td><a href="<?= Url::to(['/user/view', 'id' => $book->user_id]) ?>"><?= User::findOne(['id' => $book->user_id])->full_name ?></a></td>
                            <td><?= Book::findOne(['id' => $book->book_id])->title ?></td>
                            <td><?= $book->count ?></td>
                            <td><?= $book->pick_up_date ?></td>
                            <td><?= $book->return_date ?></td>
                            <td><?php
                                $delayed_dayes = (time() - strtotime($book->return_date)) / (60 * 60 * 24);
                                echo (int) $delayed_dayes . ' дни'
                            ?></td>
                        </tr>
                    <?php endforeach; ?> 
                </tbody>
            </table>
    <?php else: ?>
        <h3>---- Няма просрочени книги. ----</h3>
    <?php endif; ?>
</div>
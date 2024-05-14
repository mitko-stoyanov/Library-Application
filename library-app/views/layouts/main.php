<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\models\Saved;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);


$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <header id="header">
        <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top']
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => [
            ['label' => 'Начало', 'url' => ['/']],
            ['label' => 'Каталог', 'url' => ['/book']],
            !Yii::$app->user->isGuest && Yii::$app->user->identity->type != 'Читател' ? ['label' => 'Жанрове', 'url' => ['/genre']] : '',
            Yii::$app->user->isGuest
                ? '' :  [
                    'label' => 'Провери',
                    'items' => [
                        ['label' => 'Запазени книги', 'url' => ['/saved', 'user_id' => (new Saved)->checkUser()]],
                        ['label' => 'Взети книги', 'url' => ['/taken', 'user_id' => (new Saved)->checkUser()]],
                        ['label' => 'Върнати книги', 'url' => ['/returned', 'user_id' => (new Saved)->checkUser()]],
                    ],
                ],     
                ['label' => 'За Нас', 'url' => ['/site/about']],
                !Yii::$app->user->isGuest && Yii::$app->user->identity->type != 'Читател' ? ['label' => 'Потребители', 'url' => ['/user']] : '',
                Yii::$app->user->isGuest
                ? ['label' => 'Регистрация', 'url' => ['/site/signup']]
                : ['label' => 'Профил', 'url' => ['/site/profile']],
            Yii::$app->user->isGuest
                ? ['label' => 'Влизане', 'url' => ['/site/login']]
                : '',   
        ],
    ]);
    if(!Yii::$app->user->isGuest) {
        echo '<div class="right-side d-flex justify-content-center align-items-center">';
        echo Html::beginForm(['/site/logout'])
            . Html::submitButton(
                    'Излизане',
                    ['class' => 'logout pt-0']
                )
                . Html::endForm();
        echo Html::a('&#128722;' . '(' . (new Saved)->checkQty() . ')', ['/saved', 'user_id' => (new Saved)->checkUser()], ['class' => 'cart-btn']);
        echo '</div>';  
    }
    
    NavBar::end();
    ?>
    </header>

    <main id="main" class="flex-shrink-0" role="main">
        <div class="container">
            <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
            <?php endif ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>

    <footer id="footer" class="mt-auto py-3 bg-light text-center">
        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dolorem suscipit distinctio expedita, nemo esse iusto
        quidem libero.
    </footer>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>
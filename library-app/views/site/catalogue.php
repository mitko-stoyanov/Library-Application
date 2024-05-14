<?php

use yii\helpers\Html;

/** @var yii\web\View $this */

$this->title = 'Каталог';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent title">
        <h1>Каталог</h1>
        <p class="lead">Книги, обединяващи хората.</p>

    </div>

    <?php if(Yii::$app->user->identity->type != 'Читател'): ?>
        <div class="btn-create text-center">
            <p>
                <?= Html::a('Създай книга', ['book/create'], ['class' => 'btn btn-secondary btn-block']) ?>
            </p>
        </div>
    <?php endif; ?> 
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">🔍</span>
        </div>
        <input type="text" class="form-control" placeholder="Търси книга..." aria-label="Username"
            aria-describedby="basic-addon1">
        <button>Търси</button>
    </div>

    <div class="top-books mt-4">
        <div class="card" style="width:400px">
            <img class="card-img-top"
                src="https://sportshub.cbsistatic.com/i/2022/06/10/91e49e5d-41c3-4252-a649-fbf540595907/english-harry-potter-7-epub-9781781100264.jpg?auto=webp&width=1200&height=1800&crop=0.667:1,smart"
                alt="Card image">
            <div class="card-body">
                <h4 class="card-title">Harry Potter and the Deathly Hallows</h4>
                <p class="card-text">Some example text.</p>
                <a href="#" class="btn btn-primary">See Profile</a>
            </div>
        </div>
        <div class="card" style="width:400px">
            <img class="card-img-top"
                src="https://sportshub.cbsistatic.com/i/2022/06/10/91e49e5d-41c3-4252-a649-fbf540595907/english-harry-potter-7-epub-9781781100264.jpg?auto=webp&width=1200&height=1800&crop=0.667:1,smart"
                alt="Card image">
            <div class="card-body">
                <h4 class="card-title">Harry Potter and the Deathly Hallows</h4>
                <p class="card-text">Some example text.</p>
                <a href="#" class="btn btn-primary">See Profile</a>
            </div>
        </div>
        <div class="card" style="width:400px">
            <img class="card-img-top"
                src="https://sportshub.cbsistatic.com/i/2022/06/10/91e49e5d-41c3-4252-a649-fbf540595907/english-harry-potter-7-epub-9781781100264.jpg?auto=webp&width=1200&height=1800&crop=0.667:1,smart"
                alt="Card image">
            <div class="card-body">
                <h4 class="card-title">Harry Potter and the Deathly Hallows</h4>
                <p class="card-text">Some example text.</p>
                <a href="#" class="btn btn-primary">See Profile</a>
            </div>
        </div>
    </div>

    <div class="top-books mt-5">
        <div class="card" style="width:400px">
            <img class="card-img-top"
                src="https://sportshub.cbsistatic.com/i/2022/06/10/91e49e5d-41c3-4252-a649-fbf540595907/english-harry-potter-7-epub-9781781100264.jpg?auto=webp&width=1200&height=1800&crop=0.667:1,smart"
                alt="Card image">
            <div class="card-body">
                <h4 class="card-title">Harry Potter and the Deathly Hallows</h4>
                <p class="card-text">Some example text.</p>
                <a href="#" class="btn btn-primary">See Profile</a>
            </div>
        </div>
        <div class="card" style="width:400px">
            <img class="card-img-top"
                src="https://sportshub.cbsistatic.com/i/2022/06/10/91e49e5d-41c3-4252-a649-fbf540595907/english-harry-potter-7-epub-9781781100264.jpg?auto=webp&width=1200&height=1800&crop=0.667:1,smart"
                alt="Card image">
            <div class="card-body">
                <h4 class="card-title">Harry Potter and the Deathly Hallows</h4>
                <p class="card-text">Some example text.</p>
                <a href="#" class="btn btn-primary">See Profile</a>
            </div>
        </div>
        <div class="card" style="width:400px">
            <img class="card-img-top"
                src="https://sportshub.cbsistatic.com/i/2022/06/10/91e49e5d-41c3-4252-a649-fbf540595907/english-harry-potter-7-epub-9781781100264.jpg?auto=webp&width=1200&height=1800&crop=0.667:1,smart"
                alt="Card image">
            <div class="card-body">
                <h4 class="card-title">Harry Potter and the Deathly Hallows</h4>
                <p class="card-text">Some example text.</p>
                <a href="#" class="btn btn-primary">See Profile</a>
            </div>
        </div>
    </div>

    <div class="top-books mt-5">
        <div class="card" style="width:400px">
            <img class="card-img-top"
                src="https://sportshub.cbsistatic.com/i/2022/06/10/91e49e5d-41c3-4252-a649-fbf540595907/english-harry-potter-7-epub-9781781100264.jpg?auto=webp&width=1200&height=1800&crop=0.667:1,smart"
                alt="Card image">
            <div class="card-body">
                <h4 class="card-title">Harry Potter and the Deathly Hallows</h4>
                <p class="card-text">Some example text.</p>
                <a href="#" class="btn btn-primary">See Profile</a>
            </div>
        </div>
        <div class="card" style="width:400px">
            <img class="card-img-top"
                src="https://sportshub.cbsistatic.com/i/2022/06/10/91e49e5d-41c3-4252-a649-fbf540595907/english-harry-potter-7-epub-9781781100264.jpg?auto=webp&width=1200&height=1800&crop=0.667:1,smart"
                alt="Card image">
            <div class="card-body">
                <h4 class="card-title">Harry Potter and the Deathly Hallows</h4>
                <p class="card-text">Some example text.</p>
                <a href="#" class="btn btn-primary">See Profile</a>
            </div>
        </div>
        <div class="card" style="width:400px">
            <img class="card-img-top"
                src="https://sportshub.cbsistatic.com/i/2022/06/10/91e49e5d-41c3-4252-a649-fbf540595907/english-harry-potter-7-epub-9781781100264.jpg?auto=webp&width=1200&height=1800&crop=0.667:1,smart"
                alt="Card image">
            <div class="card-body">
                <h4 class="card-title">Harry Potter and the Deathly Hallows</h4>
                <p class="card-text">Some example text.</p>
                <a href="#" class="btn btn-primary">See Profile</a>
            </div>
        </div>
    </div>


</div>
</div>
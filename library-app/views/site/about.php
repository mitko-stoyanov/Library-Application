<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'За нас';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="container">
        <div class="row">
            <div class="col-lg mb-5">
                <div class="map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2932.722699454556!2d23.324817676820192!3d42.68841597116437!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40aa850b7cc7530d%3A0xa97925ce6022f122!2z0JHQuNCx0LvQuNC-0YLQtdC60LA!5e0!3m2!1sbg!2sbg!4v1684156436629!5m2!1sbg!2sbg" style="border:0; min-width: 200px; min-height: 100px; width: 100%; height: 450px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
            <div class="col-lg mb-5 d-flex align-items-center">
                <ul>
                    <li>Адрес: бул. „Патриарх Евтимий“ 6, 1142 София център, София</li>
                    <li>Тел: +3592 981 26 04, 0879 402 137. Имейл: biblio@gmail.com</li>
                    <li>Работно време: 
                        сутрин от понеделник до петък от 09.00 до 13.00 ч.<br> Вечер от понеделник до четвъртък от 17.30 до 20.30 ч.</li>
                    <li>Всички български и чуждестранни потребители на библиотеката, които искат да заемат книги за дома, трябва задължително да попълнят формуляра за записване, предоставен от секретариата на Италианския културен институт. За да могат да се регистрират, е нужно да покажат валиден документ за самоличност, на който ще бъде направено копие за съхранение 
                        в регистъра на библиотеката, надлежно да попълнят формуляра за записване и да подпишат правилника и разпоредбите за обработка на личните данни.</li>
                </ul>
            </div>
    </div>
</div>

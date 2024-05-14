<?php

namespace app\controllers;

use app\models\Book;
use app\models\SignupForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\TakenBook;
use app\models\User;
use PhpParser\Node\Stmt\Foreach_;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $last_books = Book::find()->where('available_count > 0')->orderBy(["id" => SORT_DESC])->limit(3)->all();
        return $this->render('index', [
            'last_books' => $last_books,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $current_user = User::findOne(['email' => $model->email]); 
            Yii::$app->session->setFlash('success', "Здравейте, " . $current_user->full_name . ". Логнахте се успешно.");
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', "Профилът е създаден успешно. Може да се логнете с данните си.");
            return $this->redirect(Yii::$app->homeUrl);
        }

        return $this->render('signup', [
            'model' => $model
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionCatalogue()
    {
        return $this->render('catalogue');
    }

    public function actionDelayed()
    {
        date_default_timezone_set("Europe/Sofia");
        $cur_time = time();

        //TODO: optimize search in db 
        // $delayed_books = TakenBook::find()->where($cur_time >= strtotime($return_date))->all();
        
        $delayed_books = TakenBook::find()->all();
        $result = [];

        foreach($delayed_books as $book){
            if($cur_time >= strtotime($book->return_date)) {
                array_push($result, $book);
            }
        }
        

        return $this->render('delayed', [
            'delayed_books' => $result
        ]);
    }

    public function actionProfile()
    {
        return $this->render('profile');
    }
}

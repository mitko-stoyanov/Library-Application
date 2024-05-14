<?php

namespace app\controllers;

use app\models\Book;
use app\models\Saved;
use app\models\SavedSearch;
use app\models\TakenBook;
use DateInterval;
use DateTime;
use Error;
use Exception;
use PDOException;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use yii\web\ForbiddenHttpException;

/**
 * SavedController implements the CRUD actions for Saved model.
 */
class SavedController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Saved models.
     *
     * @return string
     */
    public function actionIndex($user_id)
    {
        if(Yii::$app->user->identity->type == 'Читател' && Yii::$app->user->identity->id != $user_id) {
            throw new ForbiddenHttpException('Нямате право да преглеждате чужди запазени книги.');
        }

        if(Yii::$app->user->can('view-saved')) {
            $searchModel = new SavedSearch();
            $dataProvider = $searchModel->search($this->request->queryParams, $user_id);
            $saved_books = Saved::findAll(['user_id' => $user_id]);
    
            return $this->render('savedtable', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'saved_books' => $saved_books
            ]);
        } else {
                    throw new ForbiddenHttpException('Нямате право да създавате книги.');
                }

       
    }

    /**
     * Displays a single Saved model.
     * @param string $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        
    }

    /**
     * Creates a new Saved model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Saved();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionSaveall()
    {
        if(Yii::$app->user->can('take-book')) {
            $user_id = $_GET['user_id'];
            
            $saved_books = Saved::findAll(['user_id' => $user_id]);
            foreach($saved_books as $book) {
                $this->actionTake($book->book_id, $user_id, $book->id, strval($book->count));
            }
        } else {
                    throw new ForbiddenHttpException('Нямате право да създавате книги.');
                }
        
        
    }
    
    public function actionAdd()
    {
        if(Yii::$app->user->can('add-books-user')) {
            $model = new Saved();

            if ($model->load($this->request->post())) {
                $session = Yii::$app->session;
                if($model->user_id != Yii::$app->user->identity->id) {
                    $session['user_id'] = $model->user_id;
                    Yii::$app->session->setFlash('success', "Успешно променихте текущия потребител. Може да започнете да добавяте книги.");
                } else {
                    Yii::$app->session->setFlash('error', "Моля изберете друг потребител освен вас.");
                    return $this->redirect(['/saved/add']);
                }
                return $this->redirect(['/book']);
            }

            return $this->render('add', [
                'model' => $model,
            ]);
        } else {
                    throw new ForbiddenHttpException('Нямате право да добавяте книги на даден потребител.');
                }
        
    }

    public function actionDelusr() {
        $session = Yii::$app->session;
        $session->remove('user_id');
        Yii::$app->session->setFlash('success', "Успешно променихте текущия потребител. Всички книги, ще се добавят към вашия акаунт - " . Yii::$app->user->identity->full_name);
        return $this->redirect(['/book']);
    }

    public function actionSetSession()
    {
        // $model = new Saved();
        // $session = Yii::$app->session;
        // $session['id'] = $model->user_id;
    }

    /**
     * Updates an existing Saved model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Saved model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    // Saved Book actions:
    public function actionIncrement($saved_id, $book_id)
    {
        $saved_book = Saved::findOne(['id' => $saved_id]);
        $book = Book::findOne(['id' => $book_id]);
        
        if($book->available_count >= 1) {
            $saved_book->count += 1;
            $book->available_count -= 1;
            $saved_book->save();
            $book->save();
            Yii::$app->session->setFlash('info', "Успешно запазихте една нова книга.");
        } else{
            Yii::$app->session->setFlash('error', "Няма повече налични книги в библиотеката.");
        };
        
        $session = Yii::$app->session;
        if($session['user_id']) {
            return $this->redirect(['/saved', 'user_id' => Yii::$app->session['user_id']]);
        }
        return $this->redirect(['/saved', 'user_id' => Yii::$app->user->identity->id]);
    }

    public function actionDecrement($saved_id, $book_id)
    {
        $saved_book = Saved::findOne(['id' => $saved_id]);
        $book = Book::findOne(['id' => $book_id]);
        if($saved_book->count >= 1) {
            $saved_book->count -= 1;
            $book->available_count += 1;
            $saved_book->save();
            $book->save();
            Yii::$app->session->setFlash('info', "Успешно премахнахте от запазени една нова книга.");
        }

        if($saved_book->count == 0){
            $saved_book->delete();
        }

        $session = Yii::$app->session;
        if($session['user_id']) {
            return $this->redirect(['/saved', 'user_id' => Yii::$app->session['user_id']]);
        }
        return $this->redirect(['/saved', 'user_id' => Yii::$app->user->identity->id]);
    }

    public function actionRemove($saved_id, $book_id)
    {
        $saved_book = Saved::findOne(['id' => $saved_id]);
        $book = Book::findOne(['id' => $book_id]);

        $book->available_count += $saved_book->count;
        $book->save();
        $saved_book->delete();
        Yii::$app->session->setFlash('info', "Успешно изтрихте избраните запазени книги.");

        $session = Yii::$app->session;
        if($session['user_id']) {
            return $this->redirect(['/saved', 'user_id' => Yii::$app->session['user_id']]);
        }
        return $this->redirect(['/saved', 'user_id' => Yii::$app->user->identity->id]);
    }

    public function actionTake($book_id, $user_id, $saved_book_id, $quantity = 1)
    {
        if(Yii::$app->user->can('take-book')) {
            $saved_book = Saved::findOne(['id' => $saved_book_id]);
            if ($this->request->isPost) {
                $quantity =  $_POST['qty'];
            }
    
            if($saved_book->count < $quantity || $quantity < 1) {
                Yii::$app->session->setFlash('error', "Моля запазете брой по-малък или равен на броя на запазените книги. Освен това броят трябва да е по-голям от 0");
                return $this->redirect(['/saved', 'user_id' => $user_id]);
            }
    
            if(!ctype_digit($quantity)) {
                Yii::$app->session->setFlash('error', "Моля въведете цяло число за брой.");
                return $this->redirect(['/saved', 'user_id' => $user_id]);
            }
            
            $saved_book->count -= $quantity;
            $saved_book->save();
            if($saved_book->count == 0) {
                $saved_book->delete();
            }
            
    
            try {
                $taken_book = TakenBook::findOne(['user_id' => $user_id, 'book_id' => $book_id]);
                $taken_book->count += $quantity;
                $taken_book->pick_up_date = date('Y-m-d');
                $taken_book->return_date = date('Y-m-d',strtotime('+14 day')); 
                $taken_book->save();
    
            } catch (Error $e) {
                $taken_book = new TakenBook();
                $taken_book->user_id = $user_id;
                $taken_book->book_id = $book_id;
                $taken_book->count = $quantity;
                $taken_book->return_date = date('Y-m-d',strtotime('+14 day')); 
    
                $taken_book->save();
            }
            Yii::$app->session->setFlash('success', "Успешно взехте избраните книги.");

            $session = Yii::$app->session;

            if($session['user_id']) {
                return $this->redirect(['/saved', 'user_id' => $session['user_id']]);
            }
            return $this->redirect(['/saved', 'user_id' => Yii::$app->user->identity->id]);
        } else {
                    throw new ForbiddenHttpException('Нямате право да вземате книги.');
                }
   

    }

    /**
     * Finds the Saved model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id ID
     * @return Saved the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Saved::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

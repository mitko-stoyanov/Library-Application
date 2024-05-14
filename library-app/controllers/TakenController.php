<?php

namespace app\controllers;

use app\models\ReturnedBook;
use app\models\Saved;
use app\models\TakenBook;
use app\models\TakenSearch;
use Error;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;

/**
 * TakenController implements the CRUD actions for TakenBook model.
 */
class TakenController extends Controller
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
     * Lists all TakenBook models.
     *
     * @return string
     */
    public function actionIndex($user_id)
    {
        if(Yii::$app->user->identity->type == 'Читател' && Yii::$app->user->identity->id != $user_id) {
            throw new ForbiddenHttpException('Нямате право да преглеждате чужди взети книги.');
        }

        $searchModel = new TakenSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, $user_id);
        $taken_books = TakenBook::findAll(['user_id' => $user_id]);

        return $this->render('takentable', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'taken_books' => $taken_books
        ]);
    }

    /**
     * Displays a single TakenBook model.
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
     * Creates a new TakenBook model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new TakenBook();

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

    /**
     * Updates an existing TakenBook model.
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
     * Deletes an existing TakenBook model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['user/']);
    }

    public function actionReturn($book_id, $user_id, $taken_book_id, $quantity = 1)
    {
        if(Yii::$app->user->can('return-book')) {
            $taken_book = TakenBook::findOne(['user_id' => $user_id, 'book_id' => $book_id]);

            if ($this->request->isPost) {
                $quantity =  $_POST['qty'];
            }
    
            if($taken_book->count == 0){
                Yii::$app->session->setFlash('error', "Няма повече книги за връщане.");
                return $this->redirect(['/taken', 'user_id' => $user_id]);
            }
    
            if($taken_book->count < $quantity || $quantity < 1) {
                Yii::$app->session->setFlash('error', "Моля върнете брой по-малък или равен на взетия. Освен това броят трябва да е по-голям от 0");
                return $this->redirect(['/taken', 'user_id' => $user_id]);
            }
    
            if(!ctype_digit($quantity)) {
                Yii::$app->session->setFlash('error', "Моля въведете цяло число за брой.");
                return $this->redirect(['/taken', 'user_id' => $user_id]);
            }
    
            $taken_book->count -= $quantity;
            $taken_book->save();
            
            try {
                $returned_book = ReturnedBook::findOne(['user_id' => $user_id, 'taken_book_id' => $taken_book_id]);
                $returned_book->count += $quantity;
                $returned_book->pick_up_date = $taken_book->pick_up_date;
                $returned_book->return_date = date('Y-m-d'); 
                $returned_book->save();
            } catch (Error $e) {
                $returned_book = new ReturnedBook();
                $returned_book->user_id = $user_id;
                $returned_book->count = $quantity;
                $returned_book->taken_book_id =  $taken_book_id;
                $returned_book->pick_up_date = $taken_book->pick_up_date;
                $returned_book->return_date = date('Y-m-d'); 
    
                $returned_book->save();
            }
            
            $session = Yii::$app->session;
            if($session['user_id']) {
                return $this->redirect(['/returned', 'user_id' => $session['user_id']]);
            }
            return $this->redirect(['/returned', 'user_id' => $user_id]);
        } else {
                    throw new ForbiddenHttpException('Нямате право да връщате книги.');
                }
       
    }

    /**
     * Finds the TakenBook model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id ID
     * @return TakenBook the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TakenBook::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

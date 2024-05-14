<?php

namespace app\controllers;

use app\models\AuthAssignment;
use app\models\User;
use app\models\UserSearch;
use Error;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        if(Yii::$app->user->can('view-user')) {
            $searchModel = new UserSearch();
            $dataProvider = $searchModel->search($this->request->queryParams);
    
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
                    throw new ForbiddenHttpException('Нямате право да преглеждате потребителите.');
                }
       
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        if(Yii::$app->user->can('create-user')) {
            $model = new User();

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
        } else {
                    throw new ForbiddenHttpException('Нямате право да създавате потребители.');
                }

    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if(Yii::$app->user->identity->type == 'Читател' && Yii::$app->user->identity->id != $id) {
            throw new ForbiddenHttpException('Нямате право да редактирате чужди профили.');
        }
        $old_save = User::findOne(['id' => $id]);
        $model = $this->findModel($id);
        
        if ($this->request->isPost && $model->load($this->request->post())) {
            if($model->type != $old_save->type){
                if($model->type == 'Администратор') {
                    $new_admin = new AuthAssignment();
                    $new_admin->user_id = $id;
                    $new_admin->item_name = 'admin';
                    $new_admin->save();
                } else if($model->type == 'Читател') {
                    $cur_admin = AuthAssignment::findOne(['user_id' => $id]);
                    $cur_admin->delete();
                } else if($model->type == 'Библиотекар') {
                    $new_admin = new AuthAssignment();
                    $new_admin->user_id = $id;
                    $new_admin->item_name = 'librarian';
                    $new_admin->save();
                }
            }
            $model->save();
            Yii::$app->session->setFlash('success', "Успешно редактирахте информацията за този профил.");
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionChange($id) {
        if(Yii::$app->user->identity->type == 'Читател' && Yii::$app->user->identity->id != $id) {
            throw new ForbiddenHttpException('Нямате право да променяте чужда парола.');
        }

        $user = User::findOne(['id' => $id]);

        if ($this->request->isPost) {
            $old_password = $_POST['old-pass'];
            $new_password = $_POST['new-pass'];
            $confirm_password = $_POST['new-pass-confirm'];
            if($user->comparePass($id, $user, $new_password, $old_password, $confirm_password)) {
                $user->password = md5($new_password . $id);
                $user->save();
                return $this->redirect(['/site/profile']);
            } else{
                throw new Error('Нещо се обърка. Паролата не може да бъде променена.');
            }
        }

        return $this->render('change', [
            'model' => $user,
        ]);
    }

    /**
     * Deletes an existing User model.
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

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id ID
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

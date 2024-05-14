<?php

namespace app\controllers;

use app\models\Book;
use app\models\BookGenres;
use app\models\BookSearch;
use app\models\Genre;
use app\models\Saved;
use app\models\User;
use Error;
use Exception;
use InvalidArgumentException;
// use GuzzleHttp\Psr7\UploadedFile;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

use \models\SavedBookForm;
use SebastianBergmann\Type\NullType;
use yii\base\Model;
use yii\data\ArrayDataProvider;
use yii\helpers\FileHelper;
use yii\web\ForbiddenHttpException;

/**
 * BookController implements the CRUD actions for Book model.
 */
class BookController extends Controller
{
    public $enableCsrfValidation = false;

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
     * Lists all Book models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new BookSearch();
        if(isset($_POST['genres'])) {
            $selected_genres = $_POST['genres'];
            $result = [];

            foreach($selected_genres as $genre_id) {
                $book_genres = BookGenres::findAll(['genre_id' => $genre_id]);
                foreach($book_genres as $book_genre) {
                    if(!in_array(Book::findOne(['id' => $book_genre->book_id]), $result)) {
                        array_push($result, Book::findOne(['id' => $book_genre->book_id]));
                    }
                }
            }

            $provider = new ArrayDataProvider([
                'allModels' => $result,
                'pagination' => [
                    'pageSize' => 12,
                ],
                'sort' => [
                    'attributes' => ['id', 'name'],
                ],
            ]);

            $dataProvider = $provider;
        } else {
            $dataProvider = $searchModel->search($this->request->queryParams);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Book model.
     * @param string $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {   
        $genres = '';
        $all_genres = BookGenres::findAll(['book_id' => $id]);
        foreach($all_genres as $cur_genre) {
            $genres .= Genre::findOne(['id' => $cur_genre->genre_id])->name . ', ';
        }


        return $this->render('view_new', [
            'model' => $this->findModel($id),
            'genres' => substr($genres, 0, -2)
        ]);
        
    }

    /**
     * Creates a new Book model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        if(Yii::$app->user->can('admin')) {
            $model = new Book();

            if ($this->request->isPost) { 
                if ($model->load($this->request->post())) {
    
                    $model->files = UploadedFile::getInstances($model, 'files');
                    $model->save();
                    foreach($model->genres as $genre) {
                        $bgenres = new BookGenres();
                        $bgenres->book_id = $model->id;
                        $bgenres->genre_id = $genre;
                        $bgenres->save();
                    }
                    // save images
                    $this->saveImages($model);
                    $model->save();
    
                    return $this->redirect(['view', 'id' => $model->id]);
                    
                }
            } else {
                $model->loadDefaultValues();
            }
    
            return $this->render('create', [
                'model' => $model,
            ]);
        } else {
            throw new ForbiddenHttpException('Нямате право да създавате книги.');
        }
 
    }

    /**
     * Updates an existing Book model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */

    public static function deleteDir($dirPath) {
        if (! is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }

    public function saveImages($model) {
        $images_paths = '';
    
        foreach($model->files as $file){
            $img_name = 'book_'.$model->id.'_'.rand();
            $dir_name = 'book_'.$model->id;
            if(!file_exists('uploads/'.$dir_name)){
                mkdir('uploads/'.$dir_name);
            }

            while (file_exists('uploads/'.$dir_name.'/'.$img_name)) {
                $img_name = 'book_'.$model->id.'_'.rand();
            }
            
            $file->saveAs('uploads/'.$dir_name.'/'.$img_name.'.'.$file->extension);
            $images_paths .= 'uploads/'.$dir_name.'/'.$img_name.'.'.$file->extension.', ';
            
        }

        $model->cover_images = $images_paths;
    }
    
    public function actionUpdate($id)
    {
        if(Yii::$app->user->can('admin')) {
            $model = $this->findModel($id);
            
            if ($this->request->isPost && $model->load($this->request->post())) {
                if($_POST['Book']['genres']) {
                    $genres = BookGenres::findAll(['book_id' => $id]);
                    foreach($genres as $genre) {
                        $genre->delete();
                    }
                    
                    foreach($_POST['Book']['genres'] as $new_genre) {
                        $bgenres = new BookGenres();
                        $bgenres->book_id = $id;
                        $bgenres->genre_id = (int) $new_genre;
                        $bgenres->save();
                    }
                }
                
                $model->files = UploadedFile::getInstances($model, 'files');
                if($model->files) {
                    // delete old images
                    $path = '/var/www/html/library-app/web/uploads/book_' . $model->id;
                    $this->deleteDir($path);
                    // save new images
                    $this->saveImages($model);
                }
                $model->save();

                return $this->redirect(['view', 'id' => $model->id]);
            }
    
            return $this->render('update', [
                'model' => $model,
            ]);
        } else {
                    throw new ForbiddenHttpException('Нямате право да редактирате книга.');
                }
        
    }

    /**
     * Deletes an existing Book model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if(Yii::$app->user->can('admin')) {
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        } else {
                    throw new ForbiddenHttpException('Нямате право да триете книга.');
                }

    }

    public function actionSaved($book_id) {
        if(!Yii::$app->user->identity) {
            Yii::$app->session->setFlash('error', "Моля логнете се, за да запазите тази книга.");
            return $this->redirect(['/book']);
        }

        if(Yii::$app->user->can('save-book')) {
            if ($this->request->isPost) {
                $quantity =  $_POST['qty'];
                $book = Book::findOne(['id' => $book_id]);
                $session = Yii::$app->session;
                if($session['user_id']) {
                    $user = User::findOne(['id'=> $session['user_id']]);
                } else {
                    $user = Yii::$app->user->identity;
                }
                
                if($book->available_count < $quantity || $quantity < 1) {
                    Yii::$app->session->setFlash('error', "Моля запазете брой по-малък или равен на наличният. Освен това броят трябва да е по-голям от 0");
                    return $this->refresh();
                }
    
                if(!ctype_digit($quantity)) {
                    Yii::$app->session->setFlash('error', "Моля въведете цяло число за брой.");
                    return $this->refresh();
                }
    
                try {
                    $saved_book = Saved::findOne(['user_id' => $user->id, 'book_id' => $book_id]);
                    $saved_book->count += $quantity;
                    $saved_book->save();
                    Yii::$app->session->setFlash('success', "Към вече запазената книга се добави желаният брой.");
                    
                } catch (Error $e) {
                    $saved = new Saved();
                    $saved->user_id = $user->id;
                    $saved->book_id = $book_id;
                    $saved->count =  $quantity;
                    $saved->save();
                    $book->available_count -= $quantity;
                    $book->save();
                    Yii::$app->session->setFlash('success', "Книгите бяха запазени успешно.");
                }
            }
            
            return $this->redirect(['/book']);

        } else {
                    throw new ForbiddenHttpException('Нямате право да запазвате книги.');
                }

    }

    /**
     * Finds the Book model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id ID
     * @return Book the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Book::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    // Change cover images order

    public function actionChange($book_id) {
        $model = Book::findOne(['id' => $book_id]);
        $book_images = $model->cover_images;
        return $this->render('change_order', [
            'images' => $book_images,
            'model' => $model
        ]);
    }


    public function actionLeft($image_path, $book_id) {
        $book = Book::findOne(['id' => $book_id]);
        $images = explode(', ', $book->cover_images);
        array_pop($images);
        $image_key = array_search($image_path , $images);
        [$images[$image_key], $images[$image_key - 1]] = [$images[$image_key - 1], $images[$image_key]];
        
        $result = implode(', ', $images) . ', ';
        $book->cover_images = $result;
        $book->save();

        return $this->redirect(['/book/change', 'book_id' => $book_id]);
    }

    public function actionRight($image_path, $book_id) {
        $book = Book::findOne(['id' => $book_id]);
        $images = explode(', ', $book->cover_images);
        array_pop($images);

        $image_key = array_search($image_path , $images);
        [$images[$image_key], $images[$image_key + 1]] = [$images[$image_key + 1], $images[$image_key]];
        
        $result = implode(', ', $images) . ', ';
        $book->cover_images = $result;
        $book->save();
        
        return $this->redirect(['/book/change', 'book_id' => $book_id]);
    }

    public function actionRemove($image_path, $book_id)
    {
        $book = Book::findOne(['id' => $book_id]);
        $images = explode(', ', $book->cover_images);
        array_pop($images);


        $image_key = array_search($image_path , $images);
        unset($images[$image_key]);

        $images = array_values($images);
        $result = $book->cover_images = implode(', ', $images) . ', ';
        if($result == ', '){
            $result = '';
        }
        $book->cover_images = $result;
        $book->save();

        return $this->redirect(['/book/change', 'book_id' => $book_id]);
    }

    // book_[0-9]+_.*
}

<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\Book;
use app\models\Saved;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class SavedController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionTest()
    {
        date_default_timezone_set("Europe/Sofia");
        
        $saved_books = Saved::find()->all();
        foreach($saved_books as $book) {
            // added 1 day to db record time
            $final_time = strtotime($book->save_date) + 86400;
            if(time() >= $final_time) {
                $regular_book = Book::findOne(['id' => $book->book_id]);
                $regular_book->available_count += $book->count;
                $regular_book->save();
                $book->delete();
            }
        }

        return ExitCode::OK;
    }
}

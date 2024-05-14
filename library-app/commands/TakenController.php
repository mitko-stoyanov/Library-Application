<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\Book;
use app\models\Saved;
use Yii;
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
        $session = Yii::$app->session;
        if($session['user_id']) {
            // $saved_books = Saved::findAll(['user_id' => $session['user_id']]);
            // if(count($saved_books) == 0) {
            $session->remove('user_id');
            // }
        }

        return ExitCode::OK;
    }
}
